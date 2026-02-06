<?php

declare(strict_types=1);

namespace Codewithkyrian\Tokenizers;

/**
 * Represents the output of tokenization.
 */
readonly class Encoding implements \Countable
{
    /**
     * @param int[]    $ids     The list of token IDs
     * @param string[] $tokens  The list of tokens
     * @param int[]    $typeIds The list of type IDs
     */
    public function __construct(
        public array $ids,
        public array $tokens,
        public array $typeIds = [],
    ) {}

    public function count(): int
    {
        return \count($this->ids);
    }
}
