<?php

declare(strict_types=1);

namespace Codewithkyrian\Tokenizers\Loaders;

use Codewithkyrian\Tokenizers\Contracts\ConfigLoaderInterface;

class FileLoader implements ConfigLoaderInterface
{
    public function load(string ...$source): array
    {
        if (0 === \count($source)) {
            throw new \Exception('At least one file path must be provided.');
        }

        $merged = [];

        foreach ($source as $path) {
            if (!file_exists($path)) {
                throw new \Exception("File not found: {$path}");
            }

            $content = file_get_contents($path);

            if (false === $content) {
                throw new \Exception("Failed to read file: {$path}");
            }

            $config = json_decode($content, true);

            if (\JSON_ERROR_NONE !== json_last_error()) {
                throw new \Exception("Invalid JSON in file {$path}: ".json_last_error_msg());
            }

            $merged = array_merge($merged, $config);
        }

        return $merged;
    }
}
