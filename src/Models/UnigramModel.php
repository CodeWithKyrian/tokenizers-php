<?php

declare(strict_types=1);

namespace Codewithkyrian\Tokenizers\Models;

use Codewithkyrian\Tokenizers\DataStructures\CharTrie;
use Codewithkyrian\Tokenizers\DataStructures\TokenLattice;

class UnigramModel extends AbstractModel
{
    /**
     * @var array<int, float>
     */
    protected array $scores = [];
    protected ?string $bosToken;
    protected ?int $bosTokenId;
    protected ?string $eosToken;
    protected ?int $eosTokenId;
    protected float $minScore = 0;
    protected float $unkScore = 0;
    protected CharTrie $trie;
    protected bool $fuseUnk;

    /**
     * @param array<array{0: string, 1: float}> $vocab    Array of [token, score] pairs
     * @param null|int                          $unkId    The unknown token ID
     * @param string                            $eosToken The end-of-sentence token (default: '</s>')
     */
    public function __construct(
        array $vocab,
        ?int $unkId = null,
        string $eosToken = '</s>'
    ) {
        foreach ($vocab as $piece) {
            $this->vocab[] = $piece[0];
            $this->scores[] = $piece[1];
        }

        $this->unkTokenId = $unkId;
        if (null !== $this->unkTokenId) {
            $this->unkToken = $this->vocab[$this->unkTokenId] ?? null;
        }

        $this->tokenToIds = array_flip($this->vocab);

        $this->bosToken = ' ';
        $this->bosTokenId = $this->tokenToIds[$this->bosToken] ?? null;

        $this->eosToken = $eosToken;
        $this->eosTokenId = $this->tokenToIds[$this->eosToken] ?? null;

        // Populate scores handling
        $this->minScore = !empty($this->scores) ? min($this->scores) : 0.0;
        $this->unkScore = $this->minScore - 10.0;

        if (null !== $this->unkTokenId) {
            $this->scores[$this->unkTokenId] = $this->unkScore;
        }

        $this->trie = new CharTrie();
        $this->trie->extend($this->vocab);

        // NOTE: `fuseUnk` is hardcoded to true for Unigram models
        // See: https://github.com/huggingface/tokenizers/blob/b58227c7f1ccf8b73ee2268354336da56d91e492/tokenizers/src/models/unigram/model.rs#L119
        $this->fuseUnk = true;
    }

    public function getConfig(?string $key = null, mixed $default = null): mixed
    {
        if (null !== $key) {
            return match ($key) {
                'type' => 'Unigram',
                'vocab' => $this->getVocabWithScores(),
                'unk_id' => $this->unkTokenId,
                'eos_token' => $this->eosToken,
                default => $default,
            };
        }

        return [
            'type' => 'Unigram',
            'vocab' => $this->getVocabWithScores(),
            'unk_id' => $this->unkTokenId,
            'eos_token' => $this->eosToken,
        ];
    }

    /**
     * @param string[] $tokens the tokens to tokenize
     *
     * @return string[]
     */
    public function tokenize(array $tokens): array
    {
        $result = [];
        foreach ($tokens as $token) {
            $tokenized = $this->tokenizeString($token);
            $result = array_merge($result, $tokenized);
        }

        if ($this->fuseUnk) {
            $result = $this->fuseUnknownTokens($result);
        }

        return $result;
    }

    /**
     * @param TokenLattice $lattice the lattice to populate nodes
     */
    public function populateNodes(TokenLattice $lattice): void
    {
        $sentence = $lattice->sentence;
        $len = mb_strlen($sentence);

        $beginPos = 0;

        while ($beginPos < $len) {
            $mblen = 1;
            $hasSingleNode = false;

            foreach ($this->trie->commonPrefixSearch(mb_substr($sentence, $beginPos)) as $token) {
                $tokenId = $this->tokenToIds[$token];
                $tokenScore = $this->scores[$tokenId];
                $n = mb_strlen($token);
                $lattice->insert($beginPos, $n, $tokenScore, $tokenId);
                if (!$hasSingleNode && $n === $mblen) {
                    $hasSingleNode = true;
                }
            }
            if (!$hasSingleNode) {
                $lattice->insert($beginPos, $mblen, $this->unkScore, $this->unkTokenId ?? 0); // fallback 0 if null
            }
            $beginPos += $mblen;
        }
    }

    /**
     * Reconstructs the vocabulary array as [ [token, score], ... ].
     *
     * @return array<array{0: string, 1: float}>
     */
    protected function getVocabWithScores(): array
    {
        $vocab = [];
        foreach ($this->vocab as $i => $token) {
            $vocab[] = [$token, $this->scores[$i]];
        }

        return $vocab;
    }

    /**
     * @param string $normalized the normalized string to tokenize
     *
     * @return string[]
     */
    protected function tokenizeString(string $normalized): array
    {
        $lattice = new TokenLattice($normalized, $this->bosTokenId, $this->eosTokenId);
        $this->populateNodes($lattice);

        return $lattice->tokens();
    }

    /**
     * Fuse consecutive unknown tokens by concatenating them into a single token string.
     *
     * @param string[] $tokens the tokens to fuse
     *
     * @return string[]
     */
    protected function fuseUnknownTokens(array $tokens): array
    {
        $fused = [];
        $i = 0;
        $length = \count($tokens);

        while ($i < $length) {
            $current = $tokens[$i];
            $tokenId = $this->tokenToIds[$current] ?? $this->unkTokenId;

            // If current token is not unknown, keep as-is.
            if ($tokenId !== $this->unkTokenId) {
                $fused[] = $current;
                ++$i;

                continue;
            }

            // Current token is unknown: start a buffer and merge subsequent unknowns.
            $buffer = $current;
            ++$i;
            while ($i < $length && (($this->tokenToIds[$tokens[$i]] ?? $this->unkTokenId) === $this->unkTokenId)) {
                $buffer .= $tokens[$i];
                ++$i;
            }

            // Add the merged unknown token as a single element.
            $fused[] = $buffer;
        }

        return $fused;
    }
}
