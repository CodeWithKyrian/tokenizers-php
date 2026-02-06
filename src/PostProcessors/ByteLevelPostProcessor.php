<?php

declare(strict_types=1);

namespace Codewithkyrian\Tokenizers\PostProcessors;

use Codewithkyrian\Tokenizers\Contracts\PostProcessorInterface;

/**
 * A PostProcessor that returns the given tokens as is.
 */
class ByteLevelPostProcessor implements PostProcessorInterface
{
    public function __construct(
        protected bool $trimOffsets = true,
        protected bool $useRegex = true,
        protected bool $addPrefixSpace = true
    ) {}

    /**
     * Post process the given tokens.
     *
     * @param string[]      $tokens           the input tokens
     * @param null|string[] $tokenPair        the input tokens for the second sequence in a pair
     * @param bool          $addSpecialTokens whether to add the special tokens associated with the corresponding model
     *
     * @return array{0: string[], 1: int[]} the post-processed tokens and token type IDs
     */
    public function process(array $tokens, ?array $tokenPair = null, bool $addSpecialTokens = true): array
    {
        if (null !== $tokenPair) {
            $tokens = array_merge($tokens, $tokenPair);
        }

        return [$tokens, array_fill(0, \count($tokens), 0)];
    }

    public function getConfig(?string $key = null, mixed $default = null): mixed
    {
        if (null !== $key) {
            return match ($key) {
                'type' => 'ByteLevel',
                'trim_offsets' => $this->trimOffsets,
                'use_regex' => $this->useRegex,
                'add_prefix_space' => $this->addPrefixSpace,
                default => $default,
            };
        }

        return [
            'type' => 'ByteLevel',
            'trim_offsets' => $this->trimOffsets,
            'use_regex' => $this->useRegex,
            'add_prefix_space' => $this->addPrefixSpace,
        ];
    }
}
