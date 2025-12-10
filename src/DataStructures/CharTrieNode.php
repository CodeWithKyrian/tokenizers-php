<?php

declare(strict_types=1);

namespace Codewithkyrian\Tokenizers\DataStructures;

class CharTrieNode
{
    /**
     * Create a new CharTrieNode.
     *
     * @param bool           $isLeaf   whether the node is a leaf node or not
     * @param CharTrieNode[] $children a map containing the node's children, where the key is a character and the value is a `CharTrieNode`
     */
    public function __construct(public bool $isLeaf, public array $children) {}

    /**
     * Returns a new `CharTrieNode` instance with default values.
     *
     * @return CharTrieNode a new `CharTrieNode` instance with `isLeaf` set to `false` and an empty `children` map
     */
    public static function default(): self
    {
        return new self(false, []);
    }

    public function getChild(string $ch): self
    {
        $this->children[$ch] ??= self::default();

        return $this->children[$ch];
    }
}
