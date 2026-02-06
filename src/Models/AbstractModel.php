<?php

declare(strict_types=1);

namespace Codewithkyrian\Tokenizers\Models;

use Codewithkyrian\Tokenizers\Contracts\ModelInterface;

abstract class AbstractModel implements ModelInterface
{
    /**
     * @var array<int, string>
     */
    protected array $vocab = [];

    /**
     * @var array<string, int>
     */
    protected array $tokenToIds = [];
    protected ?string $unkToken = null;
    protected ?int $unkTokenId = null;

    /**
     * @return array<int, string>
     */
    public function getVocab(): array
    {
        return $this->vocab;
    }

    public function getVocabSize(): int
    {
        return \count($this->vocab);
    }

    /**
     * @param int[] $ids
     *
     * @return string[]
     */
    public function decode(array $ids): array
    {
        $tokens = [];
        foreach ($ids as $id) {
            $tokens[] = $this->vocab[$id] ?? $this->unkToken ?? null;
        }

        return array_filter($tokens, static fn ($t) => null !== $t);
    }

    /**
     * @param string[] $tokens
     *
     * @return int[]
     */
    public function encode(array $tokens): array
    {
        $ids = [];
        foreach ($tokens as $token) {
            if (isset($this->tokenToIds[$token])) {
                $ids[] = $this->tokenToIds[$token];
            } else {
                $ids[] = $this->unkTokenId;
            }
        }

        // Removing nulls in case unkTokenId is null (though should exist)
        return array_filter($ids, static fn ($id) => null !== $id);
    }

    /**
     * Add a token to the vocabulary.
     *
     * @param string $token The token content
     * @param int    $id    The token ID
     */
    public function addToken(string $token, int $id): void
    {
        $this->tokenToIds[$token] = $id;
        $this->vocab[$id] = $token;
    }

    /**
     * @param string[] $tokens
     *
     * @return string[]
     */
    abstract public function tokenize(array $tokens): array;
}
