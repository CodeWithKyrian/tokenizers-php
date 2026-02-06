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
     * Get configuration value(s).
     *
     * @param null|string $key     The configuration key (e.g., 'dropout'). If null, returns all config.
     * @param mixed       $default The default value if the key doesn't exist (ignored when $key is null)
     *
     * @return mixed the configuration value, or full config array if $key is null
     */
    public function getConfig(?string $key = null, mixed $default = null): mixed;
}
