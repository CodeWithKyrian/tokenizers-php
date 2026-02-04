<?php

declare(strict_types=1);

require __DIR__.'/../vendor/autoload.php';

use Codewithkyrian\Tokenizers\Tokenizer;

/**
 * Minimal tokenization overview.
 *
 * - Loads a few popular models from the Hub
 * - Tokenizes example texts
 * - Prints token counts and a preview of tokens / ids
 *
 * Run with:
 *   php examples/tokenization_overview.php
 */

$models = [
    'BERT (uncased)' => 'google-bert/bert-base-uncased',
    'GPT-2'          => 'openai-community/gpt2',
    'Qwen3 Embedding'      => 'Qwen/Qwen3-Embedding-0.6B',
];

$samples = [
    'Short sentence' => 'Hello, how are you doing today?',
    'Code snippet'   => 'function sum(int $a, int $b): int { return $a + $b; }',
    'Mixed content'  => 'Paris is the capital of France. 42 🧠',
];

echo "=== Tokenizers PHP - Tokenization Overview ===\n\n";

foreach ($models as $label => $modelId) {
    echo "Model: {$label}\n";
    echo "Hub ID: {$modelId}\n";

    $tokenizer = Tokenizer::fromHub($modelId);

    foreach ($samples as $sampleLabel => $text) {
        $encoding = $tokenizer->encode($text);

        $ids = $encoding->ids;
        $tokens = $encoding->tokens;

        $count = \count($ids);
        $idsPreview = implode(', ', array_slice($ids, 0, 10));
        $tokensPreview = implode(' ', array_slice($tokens, 0, 10));

        echo "- {$sampleLabel}:\n";
        echo "  Text: {$text}\n";
        echo "  Token count: {$count}\n";
        echo "  IDs (first 10): {$idsPreview}".($count > 10 ? ' ...' : '')."\n";
        echo "  Tokens (first 10): {$tokensPreview}".($count > 10 ? ' ...' : '')."\n\n";
    }

    echo str_repeat('-', 60)."\n\n";
}

