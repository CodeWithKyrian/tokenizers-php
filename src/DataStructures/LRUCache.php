<?php

declare(strict_types=1);

namespace Codewithkyrian\Tokenizers\DataStructures;

/**
 * A simple Least Recently Used (LRU) cache implementation in PHP.
 * This cache stores key-value pairs and evicts the least recently used item
 * when the capacity is exceeded.
 *
 * @template TValue
 */
class LRUCache
{
    /**
     * @var array<string, TValue>
     */
    private array $cache = [];

    private int $capacity;

    /**
     * Creates an LRUCache instance.
     *
     * @param int $capacity the maximum number of items the cache can hold
     */
    public function __construct(int $capacity)
    {
        if ($capacity <= 0) {
            throw new \InvalidArgumentException('Cache capacity must be greater than 0');
        }

        $this->capacity = $capacity;
    }

    /**
     * Retrieves the value associated with the given key and marks the key as recently used.
     *
     * @param string $key the key to retrieve
     *
     * @return null|TValue the value associated with the key, or null if the key does not exist
     */
    public function get(string $key): mixed
    {
        if (!isset($this->cache[$key])) {
            return null;
        }

        // Move to end (most recently used) by removing and re-adding
        $value = $this->cache[$key];
        unset($this->cache[$key]);
        $this->cache[$key] = $value;

        return $value;
    }

    /**
     * Inserts or updates the key-value pair in the cache.
     * If the key already exists, it is updated and marked as recently used.
     * If the cache exceeds its capacity, the least recently used item is evicted.
     *
     * @param string $key   the key to add or update
     * @param TValue $value the value to associate with the key
     */
    public function put(string $key, mixed $value): void
    {
        if (isset($this->cache[$key])) {
            // Update existing key and move to end
            unset($this->cache[$key]);
        } elseif (\count($this->cache) >= $this->capacity) {
            // Remove least recently used (first item)
            array_shift($this->cache);
        }

        // Add/update at end (most recently used)
        $this->cache[$key] = $value;
    }

    /**
     * Checks if a key exists in the cache.
     *
     * @param string $key the key to check
     *
     * @return bool true if the key exists, false otherwise
     */
    public function has(string $key): bool
    {
        return isset($this->cache[$key]);
    }

    /**
     * Clears the cache.
     */
    public function clear(): void
    {
        $this->cache = [];
    }

    /**
     * Gets the current number of items in the cache.
     *
     * @return int the number of items in the cache
     */
    public function size(): int
    {
        return \count($this->cache);
    }
}
