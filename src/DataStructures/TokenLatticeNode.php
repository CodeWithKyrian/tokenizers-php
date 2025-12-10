<?php

declare(strict_types=1);

namespace Codewithkyrian\Tokenizers\DataStructures;

class TokenLatticeNode
{
    /** @var null|TokenLatticeNode A reference to the previous node. */
    public ?TokenLatticeNode $prev = null;

    /** @var float The backtrace score. */
    public float $backtraceScore = 0.0;

    /**
     * Represents a node in a token lattice for a given sentence.
     *
     * @param null|int $tokenId the ID of the token associated with this node
     * @param int      $nodeId  the ID of this node
     * @param int      $pos     the starting position of the token in the sentence
     * @param int      $length  the length of the token
     * @param float    $score   the score associated with the token
     */
    public function __construct(
        public ?int $tokenId,
        public int $nodeId,
        public int $pos,
        public int $length,
        public float $score
    ) {}

    /**
     * Returns a clone of this node.
     *
     * @return TokenLatticeNode a clone of this node
     */
    public function clone(): self
    {
        $n = new self($this->tokenId, $this->nodeId, $this->pos, $this->length, $this->score);
        $n->prev = $this->prev;
        $n->backtraceScore = $this->backtraceScore;

        return $n;
    }
}
