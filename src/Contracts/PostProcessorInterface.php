<?php

declare(strict_types=1);

namespace Codewithkyrian\Tokenizers\Contracts;

interface PostProcessorInterface
{
    /**
     * Post-process the encoded tokens.
     *
     * @param string[]      $tokens
     * @param null|string[] $pair
     *
     * @return array{0: string[], 1: int[]} the processed tokens and type IDs
     */
    public function process(array $tokens, ?array $pair = null, bool $addSpecialTokens = true): array;

    /**
     * Get configuration value(s).
     *
     * @param null|string $key     The configuration key. If null, returns all config.
     * @param mixed       $default The default value if the key doesn't exist
     *
     * @return mixed the configuration value, or full config array if $key is null
     */
    public function getConfig(?string $key = null, mixed $default = null): mixed;
}
