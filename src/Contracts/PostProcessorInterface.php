<?php

declare(strict_types=1);

namespace Codewithkyrian\Tokenizers\Contracts;

interface PostProcessorInterface
{
    /**
     * Post-process the encoded tokens.
     *
     * @param string[]      $tokens
     * @param null|string[] $pair
     *
     * @return array{0: string[], 1: int[]} the processed tokens and type IDs
     */
    public function process(array $tokens, ?array $pair = null, bool $addSpecialTokens = true): array;
}
