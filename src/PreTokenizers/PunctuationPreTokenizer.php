<?php

declare(strict_types=1);

namespace Codewithkyrian\Tokenizers\PreTokenizers;

use Codewithkyrian\Tokenizers\Contracts\PreTokenizerInterface;

class PunctuationPreTokenizer implements PreTokenizerInterface
{
    protected string $pattern;

    public function __construct(protected string $behavior = 'isolated')
    {
        $PUNCTUATION_REGEX = '\p{P}\x{0021}-\x{002F}\x{003A}-\x{0040}\x{005B}-\x{0060}\x{007B}-\x{007E}';
        $this->pattern = "/[^{$PUNCTUATION_REGEX}]+|[{$PUNCTUATION_REGEX}]+/u";
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

        preg_match_all($this->pattern, $text, $matches);

        return $matches[0] ?? [];
    }
}
