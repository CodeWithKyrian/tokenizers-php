<?php

declare(strict_types=1);

namespace Codewithkyrian\Tokenizers\PostProcessors;

use Codewithkyrian\Tokenizers\Contracts\PostProcessorInterface;

class TemplatePostProcessor implements PostProcessorInterface
{
    /**
     * @param array<array<string, mixed>> $single the single template
     * @param array<array<string, mixed>> $pair   the pair template
     */
    public function __construct(
        protected array $single,
        protected array $pair
    ) {}

    /**
     * @param string[]      $tokens           the tokens to process
     * @param null|string[] $pair             the pair of tokens to process
     * @param bool          $addSpecialTokens whether to add special tokens
     *
     * @return array{0: string[], 1: int[]} the processed tokens and type IDs
     */
    public function process(array $tokens, ?array $pair = null, bool $addSpecialTokens = true): array
    {
        $template = null === $pair ? $this->single : $this->pair;
        $processedTokens = [];
        $typeIds = [];

        foreach ($template as $item) {
            if (isset($item['SpecialToken'])) {
                if ($addSpecialTokens) {
                    $processedTokens[] = $item['SpecialToken']['id'];
                    $typeIds[] = $item['SpecialToken']['type_id'];
                }
            } elseif (isset($item['Sequence'])) {
                if ('A' === $item['Sequence']['id']) {
                    $processedTokens = array_merge($processedTokens, $tokens);
                    $typeIds = array_merge($typeIds, array_fill(0, \count($tokens), $item['Sequence']['type_id']));
                } elseif ('B' === $item['Sequence']['id']) {
                    $processedTokens = array_merge($processedTokens, $pair ?? []);
                    $typeIds = array_merge($typeIds, array_fill(0, \count($pair ?? []), $item['Sequence']['type_id']));
                }
            }
        }

        return [$processedTokens, $typeIds];
    }
}
