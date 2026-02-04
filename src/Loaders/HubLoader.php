<?php

declare(strict_types=1);

namespace Codewithkyrian\Tokenizers\Loaders;

use Codewithkyrian\HuggingFace\HuggingFace;
use Codewithkyrian\Tokenizers\Contracts\ConfigLoaderInterface;

/**
 * Loads tokenizer configuration from the Hugging Face Hub.
 */
class HubLoader implements ConfigLoaderInterface
{
    private const TOKENIZER_FILES = ['tokenizer.json', 'tokenizer_config.json'];

    public function __construct(
        protected ?string $cacheDir = null,
        protected string $revision = 'main',
        protected ?string $token = null
    ) {}

    public function load(string ...$source): array
    {
        if (0 === \count($source)) {
            throw new \InvalidArgumentException('A model ID must be provided.');
        }

        $modelId = $source[0];

        $factory = HuggingFace::factory();

        if (null !== $this->token) {
            $factory = $factory->withToken($this->token);
        }

        if (null !== $this->cacheDir) {
            $factory = $factory->withCacheDir($this->cacheDir);
        }

        $hf = $factory->make();

        $repo = $hf->hub()
            ->repo($modelId)
            ->revision($this->revision)
        ;

        $repo->snapshot(
            allowPatterns: self::TOKENIZER_FILES,
            force: false
        );

        $tokenizer = $repo->download('tokenizer.json')->json();

        $tokenizerConfig = [];
        if ($repo->fileExists('tokenizer_config.json')) {
            $tokenizerConfig = $repo->download('tokenizer_config.json')->json();
        }

        return array_merge($tokenizer, $tokenizerConfig);
    }
}
