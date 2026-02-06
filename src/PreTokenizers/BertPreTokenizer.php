<?php

declare(strict_types=1);

namespace Codewithkyrian\Tokenizers\PreTokenizers;

use Codewithkyrian\Tokenizers\Contracts\PreTokenizerInterface;

class BertPreTokenizer implements PreTokenizerInterface
{
    protected string $pattern;

    public function __construct()
    {
        // Equivalent to removing whitespace and splitting on punctuation (both \p{P} and other ascii characters)
        $PUNCTUATION_REGEX = '\p{P}\x{0021}-\x{002F}\x{003A}-\x{0040}\x{005B}-\x{0060}\x{007B}-\x{007E}';
        $this->pattern = "/([{$PUNCTUATION_REGEX}])|\\s+/u";
    }

    /**
     * @param string|string[]      $text    the text to pre-tokenize
     * @param array<string, mixed> $options the options for the pre-tokenizer
     *
     * @return string[] the pre-tokenized text
     */
    public function preTokenize(array|string $text, array $options = []): array
    {
        if (\is_array($text)) {
            $result = [];
            foreach ($text as $t) {
                $result = array_merge($result, $this->preTokenize($t, $options));
            }

            return $result;
        }

        return $this->bertPreTokenize($text);
    }

    public function getConfig(?string $key = null, mixed $default = null): mixed
    {
        if (null === $key) {
            return ['type' => 'BertPreTokenizer'];
        }

        return 'type' === $key ? 'BertPreTokenizer' : $default;
    }

    /**
     * @param string $text the text to pre-tokenize
     *
     * @return string[] the pre-tokenized text
     */
    private function bertPreTokenize(string $text): array
    {
        $tokens = preg_split($this->pattern, $text, -1, \PREG_SPLIT_DELIM_CAPTURE | \PREG_SPLIT_NO_EMPTY);

        return \is_array($tokens) ? $tokens : [];
    }
}
