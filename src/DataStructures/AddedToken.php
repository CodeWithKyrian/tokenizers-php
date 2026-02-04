<?php

declare(strict_types=1);

namespace Codewithkyrian\Tokenizers\DataStructures;

/**
 * Represents a token added by the user on top of the existing Model vocabulary.
 * AddedToken can be configured to specify the behavior they should have in various situations like:
 *   - Whether they should only match single words
 *   - Whether to include any whitespace on its left or right.
 */
readonly class AddedToken
{
    public function __construct(
        /**
         * The content of the added token.
         */
        public readonly string $content,
        /**
         * The unique ID associated to this token.
         */
        public readonly int $id,
        /**
         * Whether this token must be a single word or can break words.
         */
        public readonly bool $singleWord = true,
        /**
         * Whether this token should strip whitespaces on its left.
         */
        public readonly bool $lStrip = false,
        /**
         * Whether this token should strip whitespaces on its right.
         */
        public readonly bool $rStrip = false,
        /**
         * Whether this token should be normalized.
         */
        public readonly bool $normalized = true,
        /**
         * Whether this token is a special token.
         */
        public readonly bool $special = false,
    ) {}

    /**
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): self
    {
        return new self(
            $data['content'],
            $data['id'],
            $data['single_word'] ?? true,
            $data['lstrip'] ?? false,
            $data['rstrip'] ?? false,
            $data['normalized'] ?? true,
            $data['special'] ?? false,
        );
    }
}
