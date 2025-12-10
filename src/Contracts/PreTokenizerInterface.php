<?php

declare(strict_types=1);

namespace Codewithkyrian\Tokenizers\Contracts;

interface PreTokenizerInterface
{
    /**
     * Pre-tokenize the given text.
     *
     * @param string|string[]      $text
     * @param array<string, mixed> $options
     *
     * @return string[]
     */
    public function preTokenize(array|string $text, array $options = []): array;
}
