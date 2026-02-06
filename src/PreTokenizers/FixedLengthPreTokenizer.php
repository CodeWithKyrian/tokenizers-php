<?php

declare(strict_types=1);

namespace Codewithkyrian\Tokenizers\PreTokenizers;

use Codewithkyrian\Tokenizers\Contracts\PreTokenizerInterface;

/**
 * Splits text into fixed-length tokens.
 */
class FixedLengthPreTokenizer implements PreTokenizerInterface
{
    public function __construct(
        protected int $length
    ) {}

    public function preTokenize(array|string $text, array $options = []): array
    {
        if (\is_array($text)) {
            $result = [];
            foreach ($text as $t) {
                $result = array_merge($result, $this->preTokenize($t, $options));
            }

            return $result;
        }

        $tokens = [];
        $len = mb_strlen($text);

        for ($i = 0; $i < $len; $i += $this->length) {
            $tokens[] = mb_substr($text, $i, $this->length);
        }

        return $tokens;
    }
}
