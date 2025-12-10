<?php

declare(strict_types=1);

namespace Codewithkyrian\Tokenizers\DataStructures;

class DoubleArray
{
    /**
     * @param array<int, int> $array
     */
    public function __construct(protected array $array) {}

    /**
     * @return int[]
     */
    public function commonPrefixSearch(string $key): array
    {
        $node_pos = 0;
        $results = [];

        $unit = $this->array[$node_pos];
        $node_pos ^= $this->offset($unit);

        foreach (mb_str_split($key) as $c) {
            if (0 === \ord($c)) {
                break;
            }
            $node_pos ^= \ord($c);
            $unit = $this->array[$node_pos];
            if ($this->label($unit) !== mb_ord($c)) {
                return $results;
            }
            $node_pos ^= $this->offset($unit);
            if ($this->hasLeaf($unit)) {
                $results[] = $this->value($this->array[$node_pos]);
            }
        }

        return $results;
    }

    private function offset(int $unit): int
    {
        return $unit & ((1 << 22) - 1);
    }

    private function label(int $unit): int
    {
        return $unit >> 24;
    }

    private function hasLeaf(int $unit): int
    {
        return ($unit >> 23) & 1;
    }

    private function value(int $unit): int
    {
        return $unit & ((1 << 31) - 1);
    }
}
