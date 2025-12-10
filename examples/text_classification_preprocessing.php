<?php

declare(strict_types=1);

/**
 * Text Classification Preprocessing.
 *
 * This example shows how to prepare text data for classification tasks using
 * BERT-style tokenization. Common use cases include:
 * - Sentiment analysis
 * - Spam detection
 * - Topic classification
 * - Content moderation
 *
 * We demonstrate preprocessing with type IDs for sentence pair tasks like
 * natural language inference (NLI) and question answering.
 */

require __DIR__.'/../vendor/autoload.php';

use Codewithkyrian\Tokenizers\Tokenizer;

// Sample data for sentiment analysis (e.g., product reviews)
$sentimentSamples = [
    [
        'text' => 'Absolutely love this product! The quality exceeded my expectations and shipping was incredibly fast. Will definitely buy again.',
        'label' => 'positive',
    ],
    [
        'text' => 'Decent product for the price. Does what it\'s supposed to do, nothing more nothing less. Packaging could be better.',
        'label' => 'neutral',
    ],
    [
        'text' => 'Complete waste of money. Arrived broken, customer service was unhelpful, and the return process took forever. Avoid!',
        'label' => 'negative',
    ],
    [
        'text' => 'The device worked fine for about two weeks, then suddenly stopped charging. Replacement had the same issue. Very frustrating experience.',
        'label' => 'negative',
    ],
];

// Sample data for Natural Language Inference (premise + hypothesis pairs)
$nliSamples = [
    [
        'premise' => 'A man is playing a guitar on stage in front of a large crowd.',
        'hypothesis' => 'A musician is performing at a concert.',
        'label' => 'entailment',
    ],
    [
        'premise' => 'A man is playing a guitar on stage in front of a large crowd.',
        'hypothesis' => 'A man is sleeping in his bedroom.',
        'label' => 'contradiction',
    ],
    [
        'premise' => 'A man is playing a guitar on stage in front of a large crowd.',
        'hypothesis' => 'The man is a professional musician.',
        'label' => 'neutral',
    ],
];

// Sample data for question answering context matching
$qaSamples = [
    [
        'question' => 'What is the capital of France?',
        'context' => 'France is a country in Western Europe. Its capital city is Paris, which is known for the Eiffel Tower and the Louvre Museum.',
    ],
    [
        'question' => 'When was the company founded?',
        'context' => 'TechCorp was founded in 2010 by Jane Smith and John Doe. The company started in a small garage in Silicon Valley and has since grown to over 5000 employees worldwide.',
    ],
];

echo "=== Text Classification Preprocessing Example ===\n\n";

// Load BERT tokenizer - the standard for many classification tasks
$tokenizer = Tokenizer::fromHub('bert-base-uncased');

echo "Tokenizer loaded: bert-base-uncased\n";
echo "Max sequence length for BERT: 512 tokens\n\n";

// ============================================
// SINGLE SEQUENCE: Sentiment Analysis
// ============================================

echo "--- Sentiment Analysis (Single Sequence) ---\n\n";

$maxLength = 128; // Typical for classification tasks

foreach ($sentimentSamples as $index => $sample) {
    $encoding = $tokenizer->encode($sample['text']);

    $tokenCount = count($encoding->ids);
    $needsPadding = $tokenCount < $maxLength;
    $needsTruncation = $tokenCount > $maxLength;

    echo 'Sample '.($index + 1)." [{$sample['label']}]:\n";
    echo '  Text: "'.mb_substr($sample['text'], 0, 60)."...\"\n";
    echo "  Token count: {$tokenCount}\n";

    // Show BERT's special token structure
    echo "  Structure: [CLS] ... text tokens ... [SEP]\n";
    echo '  First 5: '.implode(' ', array_slice($encoding->tokens, 0, 5))."\n";
    echo '  Last 3: '.implode(' ', array_slice($encoding->tokens, -3))."\n";

    if ($needsPadding) {
        $paddingNeeded = $maxLength - $tokenCount;
        echo "  Padding needed: {$paddingNeeded} [PAD] tokens\n";
    }
    if ($needsTruncation) {
        $truncateCount = $tokenCount - $maxLength;
        echo "  Truncation needed: remove {$truncateCount} tokens\n";
    }

    echo "\n";
}

// ============================================
// SENTENCE PAIRS: Natural Language Inference
// ============================================

echo "--- Natural Language Inference (Sentence Pairs) ---\n\n";

foreach ($nliSamples as $index => $sample) {
    // BERT uses textPair for sentence pair tasks
    $encoding = $tokenizer->encode(
        text: $sample['premise'],
        textPair: $sample['hypothesis'],
        addSpecialTokens: true
    );

    echo 'Sample '.($index + 1)." [{$sample['label']}]:\n";
    echo "  Premise: \"{$sample['premise']}\"\n";
    echo "  Hypothesis: \"{$sample['hypothesis']}\"\n";
    echo '  Token count: '.count($encoding->ids)."\n";

    // Show the structure with type IDs
    echo "  Structure: [CLS] premise [SEP] hypothesis [SEP]\n";

    // Type IDs distinguish between premise (0) and hypothesis (1)
    $segment0Count = count(array_filter($encoding->typeIds, fn ($t) => 0 === $t));
    $segment1Count = count(array_filter($encoding->typeIds, fn ($t) => 1 === $t));

    echo "  Segment A (premise) tokens: {$segment0Count}\n";
    echo "  Segment B (hypothesis) tokens: {$segment1Count}\n";
    echo '  Type IDs sample: ['.implode(', ', array_slice($encoding->typeIds, 0, 10))."...]\n\n";
}

// ============================================
// QUESTION ANSWERING PAIRS
// ============================================

echo "--- Question Answering (Question + Context) ---\n\n";

foreach ($qaSamples as $index => $sample) {
    $encoding = $tokenizer->encode(
        text: $sample['question'],
        textPair: $sample['context'],
        addSpecialTokens: true
    );

    echo 'Sample '.($index + 1).":\n";
    echo "  Question: \"{$sample['question']}\"\n";
    echo '  Context: "'.mb_substr($sample['context'], 0, 80)."...\"\n";
    echo '  Total tokens: '.count($encoding->ids)."\n";

    // Find where the context starts (after second segment begins)
    $contextStart = array_search(1, $encoding->typeIds);
    echo "  Question tokens: {$contextStart}\n";
    echo '  Context tokens: '.(count($encoding->ids) - $contextStart)."\n\n";
}

// ============================================
// BATCH PROCESSING HELPER
// ============================================

echo "--- Batch Preprocessing Helper ---\n\n";

/**
 * Preprocess a batch of texts for classification.
 * In production, you'd send these to your model.
 *
 * @return array{input_ids: array, attention_mask: array, token_type_ids: array}
 */
function preprocessBatch(Tokenizer $tokenizer, array $texts, int $maxLength = 128): array
{
    $batchInputIds = [];
    $batchAttentionMask = [];
    $batchTokenTypeIds = [];

    foreach ($texts as $text) {
        $encoding = $tokenizer->encode($text);

        $ids = $encoding->ids;
        $typeIds = $encoding->typeIds;

        // Truncate if needed
        if (count($ids) > $maxLength) {
            $ids = array_slice($ids, 0, $maxLength - 1);
            $ids[] = 102; // [SEP] token ID for BERT
            $typeIds = array_slice($typeIds, 0, $maxLength);
        }

        // Pad if needed
        $paddingLength = $maxLength - count($ids);
        $attentionMask = array_merge(
            array_fill(0, count($ids), 1),
            array_fill(0, $paddingLength, 0)
        );

        $ids = array_merge($ids, array_fill(0, $paddingLength, 0)); // [PAD] = 0
        $typeIds = array_merge($typeIds, array_fill(0, $paddingLength, 0));

        $batchInputIds[] = $ids;
        $batchAttentionMask[] = $attentionMask;
        $batchTokenTypeIds[] = $typeIds;
    }

    return [
        'input_ids' => $batchInputIds,
        'attention_mask' => $batchAttentionMask,
        'token_type_ids' => $batchTokenTypeIds,
    ];
}

// Process the sentiment samples as a batch
$texts = array_column($sentimentSamples, 'text');
$batch = preprocessBatch($tokenizer, $texts, 64);

echo 'Batch processed: '.count($texts)." samples\n";
echo "Each padded/truncated to: 64 tokens\n";
echo "Output shapes:\n";
echo '  input_ids: ['.count($batch['input_ids']).', '.count($batch['input_ids'][0])."]\n";
echo '  attention_mask: ['.count($batch['attention_mask']).', '.count($batch['attention_mask'][0])."]\n";
echo '  token_type_ids: ['.count($batch['token_type_ids']).', '.count($batch['token_type_ids'][0])."]\n";
echo "\nReady for model input!\n";
