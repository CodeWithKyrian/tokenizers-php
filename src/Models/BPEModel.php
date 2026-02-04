<?php

declare(strict_types=1);

namespace Codewithkyrian\Tokenizers\Models;

use Codewithkyrian\Tokenizers\DataStructures\LRUCache;

class BPEModel extends AbstractModel
{
    protected const BPE_SPLIT_TOKEN = ' ';

    /**
     * @var array<string, int>
     */
    protected array $bpeRanks;

    /**
     * @var array<array<string>>
     */
    protected array $merges;
    protected ?string $continuingSubwordSuffix;
    protected ?string $endOfWordSuffix;

    protected bool $byteFallback;

    protected bool $ignoreMerges;

    /**
     * @var LRUCache<string[]>
     */
    protected LRUCache $cache;

    protected int $maxLengthToCache = 256;

    protected int $cacheCapacity = 10000;

    /**
     * @param array<string, int>                          $vocab
     * @param array<array{0: string, 1: string}>|string[] $merges
     */
    public function __construct(
        array $vocab,
        array $merges = [],
        ?string $unkToken = null,
        ?string $endOfWordSuffix = null,
        ?string $continuingSubwordSuffix = null,
        bool $byteFallback = false,
        bool $ignoreMerges = false
    ) {
        $this->tokenToIds = $vocab;
        $this->unkToken = $unkToken;
        $this->unkTokenId = $this->tokenToIds[$this->unkToken] ?? null;
        $this->vocab = array_flip($vocab);

        $useNewMergeFormat = !empty($merges) && \is_array($merges[0]);

        if ($useNewMergeFormat) {
            $this->merges = $merges;
        } else {
            $this->merges = array_map(
                static fn ($merge) => \is_string($merge) ? explode(' ', $merge, 2) : $merge,
                $merges
            );
        }

        $this->bpeRanks = [];
        foreach ($this->merges as $i => $pair) {
            $key = json_encode($pair);
            $this->bpeRanks[$key] = $i;
        }

        $this->endOfWordSuffix = $endOfWordSuffix;
        $this->continuingSubwordSuffix = $continuingSubwordSuffix;
        $this->byteFallback = $byteFallback;
        $this->ignoreMerges = $ignoreMerges;

        $this->cache = new LRUCache($this->cacheCapacity);
    }

    public function getEndOfWordSuffix(): ?string
    {
        return $this->endOfWordSuffix;
    }

    /**
     * @param string[] $tokens
     *
     * @return string[]
     */
    public function tokenize(array $tokens): array
    {
        $outputTokens = [];

        foreach ($tokens as $token) {
            if ($this->ignoreMerges && isset($this->tokenToIds[$token])) {
                $outputTokens[] = $token;

                continue;
            }

            $bpeTokenList = $this->bpe($token);

            foreach ($bpeTokenList as $bpeToken) {
                if (\array_key_exists($bpeToken, $this->tokenToIds)) {
                    $outputTokens[] = $bpeToken;
                } else {
                    if ($this->byteFallback) {
                        $bytes = unpack('C*', $bpeToken);
                        $byteTokens = [];
                        foreach ($bytes as $byte) {
                            $byteToken = \sprintf('<0x%02X>', $byte);
                            if (isset($this->tokenToIds[$byteToken])) {
                                $byteTokens[] = $byteToken;
                            } else {
                                // If any byte token is not in vocab, fall back to unk_token
                                $byteTokens = [$this->unkToken];

                                break;
                            }
                        }
                        $outputTokens = array_merge($outputTokens, $byteTokens);
                    } else {
                        $outputTokens[] = $this->unkToken;
                    }
                }
            }
        }

        return $outputTokens;
    }

    /**
     * Clears the cache.
     */
    public function clearCache(): void
    {
        $this->cache->clear();
    }

    /**
     * @param \SplPriorityQueue<float, BPENode> $queue the queue to add the node to
     * @param BPENode                           $node  the node to add to the queue
     */
    public function addNodeToQueue(\SplPriorityQueue $queue, BPENode $node): void
    {
        $pairKey = json_encode([$node->token, $node->next->token]);
        $rank = $this->bpeRanks[$pairKey] ?? null;

        if (null !== $rank) {
            $node->score = -($rank + $node->bias);
            $queue->insert($node, $node->score);
        }
    }

    /**
     * @param string $token the token to BPE
     *
     * @return string[]
     */
    protected function bpe(string $token): array
    {
        if (0 === mb_strlen($token)) {
            return [];
        }

        $cached = $this->cache->get($token);
        if (null !== $cached) {
            return $cached;
        }

        $word = preg_split('//u', $token, -1, \PREG_SPLIT_NO_EMPTY);

        if ($this->endOfWordSuffix) {
            $word[\count($word) - 1] .= $this->endOfWordSuffix;
        }

        $result = [];
        if (\count($word) > 1) {
            $queue = new \SplPriorityQueue();
            $queue->setExtractFlags(\SplPriorityQueue::EXTR_DATA);

            $startingNode = new BPENode($word[0], 0);
            $previousNode = $startingNode;

            for ($i = 1; $i < \count($word); ++$i) {
                $currentNode = new BPENode(
                    $word[$i],
                    $i / \count($word),
                    $previousNode,
                );
                $previousNode->next = $currentNode;
                $this->addNodeToQueue($queue, $previousNode);
                $previousNode = $currentNode;
            }

            while (!$queue->isEmpty()) {
                /** @var BPENode $node */
                $node = $queue->extract();

                if ($node->deleted || !$node->next || $node->next->deleted) {
                    continue;
                }

                $node->deleted = true;
                $node->next->deleted = true;

                if ($node->prev) {
                    $newPrevNode = clone $node->prev;
                    $node->prev->deleted = true;
                    $node->prev = $newPrevNode;
                    if ($newPrevNode->prev) {
                        $newPrevNode->prev->next = $newPrevNode;
                    } else {
                        $startingNode = $newPrevNode;
                    }
                }

                $merged = new BPENode($node->token.$node->next->token, $node->bias, $node->prev, $node->next->next);

                if ($merged->prev) {
                    $merged->prev->next = $merged;
                    $this->addNodeToQueue($queue, $merged->prev);
                } else {
                    $startingNode = $merged;
                }

                if ($merged->next) {
                    $merged->next->prev = $merged;
                    $this->addNodeToQueue($queue, $merged);
                }
            }

            for ($node = $startingNode; null != $node; $node = $node->next) {
                $result[] = $node->token;
            }
        } else {
            $result = $word;
        }

        if ($this->continuingSubwordSuffix) {
            for ($i = 0; $i < \count($result) - 1; ++$i) {
                $result[$i] .= $this->continuingSubwordSuffix;
            }
        }

        if (mb_strlen($token) < $this->maxLengthToCache) {
            $this->cache->put($token, $result);
        }

        return $result;
    }
}
