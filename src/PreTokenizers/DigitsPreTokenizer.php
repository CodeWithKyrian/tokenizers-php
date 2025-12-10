<?php

declare(strict_types=1);

namespace Codewithkyrian\Tokenizers\PreTokenizers;

use Codewithkyrian\Tokenizers\Contracts\PreTokenizerInterface;

class DigitsPreTokenizer implements PreTokenizerInterface
{
    protected string $pattern;

    public function __construct(protected bool $individualDigits = false)
    {
        $individualDigits = $this->individualDigits ? '' : '+';
        $digitPattern = "[\\D]+|\\d{$individualDigits}";
        $this->pattern = "/{$digitPattern}/u";
    }

    public function preTokenize(array|string $text, array $options = []): array
    {
        if (\is_array($text)) {
            $result = [];
            foreach ($text as $t) {
                $result = array_merge($result, $this->preTokenize($t, $options));
            }

            return $result;
        }

        preg_match_all($this->pattern, $text, $matches, \PREG_SPLIT_NO_EMPTY);

        return $matches[0] ?? [];
    }
}
