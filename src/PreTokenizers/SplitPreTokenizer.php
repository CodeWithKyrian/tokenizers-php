<?php

declare(strict_types=1);

namespace Codewithkyrian\Tokenizers\PreTokenizers;

use Codewithkyrian\Tokenizers\Contracts\PreTokenizerInterface;
use Codewithkyrian\Tokenizers\Utils\RegexUtils;

class SplitPreTokenizer implements PreTokenizerInterface
{
    protected ?string $pattern;

    /**
     * @param string|string[] $pattern the pattern to split on
     * @param bool            $invert  whether to invert the pattern
     */
    public function __construct(
        array|string $pattern,
        protected bool $invert = true
    ) {
        $this->pattern = RegexUtils::createPattern($pattern, $invert);
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

        if (null === $this->pattern) {
            return [$text];
        }

        $delimiter = str_contains($this->pattern, '/') ? '#' : '/';
        $regex = "{$delimiter}{$this->pattern}{$delimiter}u";

        if ($this->invert) {
            $result = @preg_match_all($regex, $text, $matches);
            if (false === $result || !isset($matches[0])) {
                return [$text];
            }

            return $matches[0];
        }
        $result = [];
        $offset = 0;

        $matchResult = @preg_match_all($regex, $text, $matches, \PREG_OFFSET_CAPTURE);

        if (false === $matchResult || !isset($matches[0]) || empty($matches[0])) {
            return [$text];
        }

        foreach ($matches[0] as $match) {
            $fullMatch = $match[0];
            $matchIndex = $match[1];

            if ($offset < $matchIndex) {
                $result[] = substr($text, $offset, $matchIndex - $offset);
            }

            if ('' !== $fullMatch) {
                $result[] = $fullMatch;
            }

            $offset = $matchIndex + \strlen($fullMatch);
        }

        if ($offset < \strlen($text)) {
            $result[] = substr($text, $offset);
        }

        return $result;
    }

    public function getConfig(?string $key = null, mixed $default = null): mixed
    {
        if (null !== $key) {
            return match ($key) {
                'type' => 'Split',
                'pattern' => $this->pattern, // Ideally this should be the original pattern string, not compiled regex?
                'invert' => $this->invert,
                default => $default,
            };
        }

        return [
            'type' => 'Split',
            'pattern' => $this->pattern,
            'invert' => $this->invert,
        ];
    }
}
