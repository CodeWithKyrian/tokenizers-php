<?php

declare(strict_types=1);

namespace Codewithkyrian\Tokenizers\DataStructures;

/**
 * A data structure which uses a trie to split a string into tokens based on a dictionary.
 * It efficiently finds all occurrences of dictionary words in the input text using longest-match-first strategy.
 */
class DictionarySplitter
{
    /**
     * @var array<string, mixed> The root node of the trie
     */
    private array $trie;

    /**
     * @param string[] $dictionary the dictionary of words to use for splitting
     */
    public function __construct(array $dictionary)
    {
        $this->trie = $this->buildTrie($dictionary);
    }

    /**
     * Splits the input text into tokens based on the dictionary.
     * Uses longest-match-first strategy to handle overlapping matches.
     *
     * @param string $text the input text to split
     *
     * @return string[] an array of tokens (both dictionary words and non-matching text segments)
     */
    public function split(string $text): array
    {
        $result = [];
        $length = mb_strlen($text);
        $start = 0;
        $i = 0;

        while ($i < $length) {
            $node = $this->trie;
            $match = null;
            $matchLength = 0;
            $j = $i;

            // Try to find the longest match starting at position $i
            while ($j < $length) {
                $char = mb_substr($text, $j, 1);
                if (!isset($node[$char])) {
                    break;
                }

                $node = $node[$char];

                // If we found an end marker, record this as a potential match
                if (isset($node['__end__'])) {
                    $match = $node['__end__'];
                    $matchLength = $j - $i + 1;
                }

                ++$j;
            }

            if (null !== $match) {
                // Add any text before the match
                if ($i > $start) {
                    $result[] = mb_substr($text, $start, $i - $start);
                }

                // Add the matched token
                $result[] = $match;
                $i += $matchLength;
                $start = $i;
            } else {
                ++$i;
            }
        }

        // Add any remaining text
        if ($start < $length) {
            $result[] = mb_substr($text, $start);
        }

        return $result;
    }

    /**
     * Builds a trie from the given dictionary.
     *
     * @param string[] $dictionary the dictionary of words to build the trie from
     *
     * @return array<string, mixed> the root node of the trie
     */
    private function buildTrie(array $dictionary): array
    {
        /** @var array<string, mixed> $trie */
        $trie = [];

        foreach ($dictionary as $word) {
            $node = &$trie;
            $length = mb_strlen($word);

            for ($i = 0; $i < $length; ++$i) {
                $char = mb_substr($word, $i, 1);
                if (!isset($node[$char])) {
                    $node[$char] = [];
                }
                $node = &$node[$char];
            }

            // Mark the end of the word
            $node['__end__'] = $word;
        }

        return $trie;
    }
}
