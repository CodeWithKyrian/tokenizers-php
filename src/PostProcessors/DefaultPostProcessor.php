<?php

declare(strict_types=1);

namespace Codewithkyrian\Tokenizers\PostProcessors;

use Codewithkyrian\Tokenizers\Contracts\PostProcessorInterface;

/**
 * A default post-processor that merges tokens and creates type IDs.
 * Used as a default when no post-processor is specified.
 */
class DefaultPostProcessor implements PostProcessorInterface
{
    public function process(array $tokens, ?array $pair = null, bool $addSpecialTokens = true): array
    {
        if (null !== $pair) {
            $tokens = array_merge($tokens, $pair);
            $typeIds = array_merge(
                array_fill(0, \count($tokens) - \count($pair), 0),
                array_fill(0, \count($pair), 1)
            );
        } else {
            $typeIds = array_fill(0, \count($tokens), 0);
        }

        return [$tokens, $typeIds];
    }
}
