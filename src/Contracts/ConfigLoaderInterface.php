<?php

declare(strict_types=1);

namespace Codewithkyrian\Tokenizers\Contracts;

interface ConfigLoaderInterface
{
    /**
     * Load configuration from one or more sources.
     *
     * @param string ...$source One or more source identifiers (file paths, repo IDs, etc.)
     *
     * @return array<string, mixed> the merged configuration array
     */
    public function load(string ...$source): array;
}
