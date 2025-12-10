<?php

declare(strict_types=1);

namespace Codewithkyrian\Tokenizers;

/**
 * Represents the output of tokenization.
 */
class Encoding
{
    /**
     * @param int[]    $ids     The list of token IDs
     * @param string[] $tokens  The list of tokens
     * @param int[]    $typeIds The list of type IDs
     */
    public function __construct(
        public readonly array $ids,
        public readonly array $tokens,
        public readonly array $typeIds = [],
    ) {}
}
