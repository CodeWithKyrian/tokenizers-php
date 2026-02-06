<?php

declare(strict_types=1);

namespace Codewithkyrian\Tokenizers\PostProcessors;

use Codewithkyrian\Tokenizers\Contracts\PostProcessorInterface;

/**
 * A post-processor that applies multiple post-processors in sequence.
 */
class PostProcessorSequence implements PostProcessorInterface
{
    /**
     * List of post-processors to apply.
     *
     * @var PostProcessorInterface[]
     */
    protected array $processors;

    /**
     * Creates a new instance of PostProcessorSequence.
     *
     * @param PostProcessorInterface[] $processors the list of post-processors to apply
     */
    public function __construct(array $processors)
    {
        $this->processors = $processors;
    }

    /**
     * Post-process the given tokens.
     *
     * @param string[]      $tokens           the list of tokens for the first sequence
     * @param null|string[] $tokenPair        the input tokens for the second sequence in a pair
     * @param bool          $addSpecialTokens whether to add the special tokens associated with the corresponding model
     *
     * @return array{0: string[], 1: int[]} the post-processed tokens and token type IDs
     */
    public function process(array $tokens, ?array $tokenPair = null, bool $addSpecialTokens = true): array
    {
        $tokenTypeIds = null;

        foreach ($this->processors as $processor) {
            if ($processor instanceof ByteLevelPostProcessor) {
                [$tokens, $_] = $processor->process($tokens);

                if (null !== $tokenPair) {
                    [$tokenPair, $_] = $processor->process($tokenPair);
                }
            } else {
                [$tokens, $tokenTypeIds] = $processor->process($tokens, $tokenPair, $addSpecialTokens);
            }
        }

        return [$tokens, $tokenTypeIds ?? array_fill(0, \count($tokens), 0)];
    }

    public function getConfig(?string $key = null, mixed $default = null): mixed
    {
        if (null !== $key) {
            if ('processors' === $key) {
                return array_map(static fn (PostProcessorInterface $p) => $p->getConfig(), $this->processors);
            }

            return 'type' === $key ? 'Sequence' : $default;
        }

        return [
            'type' => 'Sequence',
            'processors' => array_map(static fn (PostProcessorInterface $p) => $p->getConfig(), $this->processors),
        ];
    }
}
