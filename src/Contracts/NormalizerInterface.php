<?php

declare(strict_types=1);

namespace Codewithkyrian\Tokenizers\Contracts;

interface NormalizerInterface
{
    public function normalize(string $text): string;

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
