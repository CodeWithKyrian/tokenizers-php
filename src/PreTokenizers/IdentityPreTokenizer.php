<?php

declare(strict_types=1);

namespace Codewithkyrian\Tokenizers\PreTokenizers;

use Codewithkyrian\Tokenizers\Contracts\PreTokenizerInterface;

/**
 * An identity pre-tokenizer that wraps the text in an array without modification.
 * Used as a default when no pre-tokenizer is specified.
 */
class IdentityPreTokenizer implements PreTokenizerInterface
{
    public function preTokenize(array|string $text, array $options = []): array
    {
        if (\is_array($text)) {
            return $text;
        }

        return [$text];
    }
}
