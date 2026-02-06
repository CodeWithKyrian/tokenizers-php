<?php

declare(strict_types=1);

namespace Codewithkyrian\Tokenizers\PostProcessors;

use Codewithkyrian\Tokenizers\Contracts\PostProcessorInterface;

class BertPostProcessor implements PostProcessorInterface
{
    public function __construct(
        protected string $sep,
        protected string $cls
    ) {}

    public function process(array $tokens, ?array $pair = null, bool $addSpecialTokens = true): array
    {
        if (!$addSpecialTokens) {
            $tokenTypeIds = array_fill(0, \count($tokens) + ($pair ? \count($pair) : 0), 0);

            return $pair ? [array_merge($tokens, $pair), $tokenTypeIds] : [$tokens, $tokenTypeIds];
        }

        // Single Sequence: [CLS] A [SEP]
        $processedTokens = array_merge([$this->cls], $tokens, [$this->sep]);
        $tokenTypeIds = array_fill(0, \count($processedTokens), 0);

        if ($pair) {
            // Pair Sequence: [CLS] A [SEP] B [SEP]
            $processedTokens = array_merge($processedTokens, $pair, [$this->sep]);
            $tokenTypeIds = array_merge($tokenTypeIds, array_fill(0, \count($pair) + 1, 1));
        }

        return [$processedTokens, $tokenTypeIds];
    }

    public function getConfig(?string $key = null, mixed $default = null): mixed
    {
        if (null !== $key) {
            return match ($key) {
                'type' => 'BertProcessing',
                'sep' => [$this->sep, 0], // Best effort reconstruction
                'cls' => [$this->cls, 0],
                default => $default,
            };
        }

        return [
            'type' => 'BertProcessing',
            'sep' => [$this->sep, 0],
            'cls' => [$this->cls, 0],
        ];
    }
}
