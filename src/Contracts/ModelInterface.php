<?php

declare(strict_types=1);

namespace Codewithkyrian\Tokenizers\Contracts;

interface ModelInterface
{
    /**
     * Tokenize a list of pre-tokenized words into subwords.
     *
     * @param string[] $tokens
     *
     * @return string[]
     */
    public function tokenize(array $tokens): array;

    /**
     * Encode a list of tokens to a list of token IDs.
     *
     * @param string[] $tokens
     *
     * @return int[]
     */
    public function encode(array $tokens): array;

    /**
     * Decode a list of token IDs to a list of tokens.
     *
     * @param int[] $ids
     *
     * @return string[]
     */
    public function decode(array $ids): array;

    /**
     * Get the vocabulary of the model.
     *
     * @return array<int, string>
     */
    public function getVocab(): array;

    /**
     * Get the size of the vocabulary.
     */
    public function getVocabSize(): int;

    /**
     * Add a token to the vocabulary.
     *
     * @param string $token The token content
     * @param int    $id    The token ID
     */
    public function addToken(string $token, int $id): void;

    /**
     * Get the end of word suffix, if any.
     * Only some models (like BPE) have this property.
     *
     * @return null|string the end of word suffix
     */
    public function getEndOfWordSuffix(): ?string;
}
