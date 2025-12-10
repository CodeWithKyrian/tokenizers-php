<?php

declare(strict_types=1);

namespace Codewithkyrian\Tokenizers\Contracts;

interface DecoderInterface
{
    /**
     * Decode a list of tokens to a string.
     *
     * @param string[] $tokens
     */
    public function decode(array $tokens): string;
}
