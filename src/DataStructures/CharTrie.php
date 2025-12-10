<?php

declare(strict_types=1);

namespace Codewithkyrian\Tokenizers\DataStructures;

class CharTrie
{
    /** @var CharTrieNode The root node of the trie. */
    private CharTrieNode $root;

    /**
     * Creates a new CharTrie instance.
     */
    public function __construct()
    {
        $this->root = CharTrieNode::default();
    }

    /**
     * Adds one or more `texts` to the trie.
     *
     * @param string[] $texts the strings to add to the trie
     */
    public function extend(array $texts): void
    {
        array_map([$this, 'push'], $texts);
    }

    /**
     * Adds text to the trie.
     *
     * @param string $text the string to add to the trie
     */
    public function push(string $text): void
    {
        $node = $this->root;
        $length = mb_strlen($text);

        for ($i = 0; $i < $length; ++$i) {
            $ch = mb_substr($text, $i, 1);
            $node = $node->getChild($ch);
        }

        $node->isLeaf = true;
    }

    /**
     * Searches the trie for all strings with a common prefix of `text`.
     *
     * @param string $text the common prefix to search for
     *
     * @return \Generator yields each string in the trie that has `text` as a prefix
     */
    public function commonPrefixSearch(string $text): \Generator
    {
        $node = $this->root;
        $prefix = '';
        $length = mb_strlen($text);

        for ($i = 0; $i < $length && null != $node; ++$i) {
            $ch = mb_substr($text, $i, 1);
            $prefix .= $ch;
            $node = $node->getChild($ch);

            if ($node->isLeaf) {
                yield $prefix;
            }
        }
    }
}
