<?php

declare(strict_types=1);

/**
 * Semantic Search & Embedding Preparation.
 *
 * This example shows how to prepare text for semantic search or vector embedding
 * pipelines. Common use cases include:
 * - Building searchable document indexes
 * - Generating embeddings for similarity matching
 * - Preparing queries and documents for retrieval-augmented generation (RAG)
 *
 * We use the all-MiniLM model which is popular for sentence embeddings.
 */

require __DIR__.'/../vendor/autoload.php';

use Codewithkyrian\Tokenizers\Tokenizer;

$documents = [
    [
        'id' => 'doc_001',
        'title' => 'Introduction to Machine Learning',
        'content' => 'Machine learning is a subset of artificial intelligence that enables systems to learn and improve from experience without being explicitly programmed. It focuses on developing algorithms that can access data and use it to learn for themselves.',
    ],
    [
        'id' => 'doc_002',
        'title' => 'Neural Networks Explained',
        'content' => 'Neural networks are computing systems inspired by biological neural networks in the human brain. They consist of interconnected nodes organized in layers that process information using connectionist approaches to computation.',
    ],
    [
        'id' => 'doc_003',
        'title' => 'Natural Language Processing',
        'content' => 'NLP combines computational linguistics with statistical, machine learning, and deep learning models. It enables computers to process and analyze large amounts of natural language data, from text classification to machine translation.',
    ],
    [
        'id' => 'doc_004',
        'title' => 'Computer Vision Applications',
        'content' => 'Computer vision trains machines to interpret and understand visual information from the world. Applications range from facial recognition and autonomous vehicles to medical image analysis and industrial quality control.',
    ],
];

$searchQueries = [
    'How do computers learn from data?',
    'What are the layers in AI systems?',
    'Processing human language with AI',
];

echo "=== Semantic Search Tokenization Example ===\n\n";

$tokenizer = Tokenizer::fromHub('sentence-transformers/all-MiniLM-L6-v2');

echo "Tokenizer loaded: sentence-transformers/all-MiniLM-L6-v2\n\n";

echo "--- Processing Documents ---\n\n";

$maxTokenLength = 256;

foreach ($documents as $doc) {
    $text = $doc['title'].'. '.$doc['content'];
    $encoding = $tokenizer->encode($text);

    $tokenCount = count($encoding->ids);
    $truncated = $tokenCount > $maxTokenLength;

    echo "Document: {$doc['id']}\n";
    echo "  Title: {$doc['title']}\n";
    echo "  Token count: {$tokenCount}".($truncated ? ' (would need truncation)' : '')."\n";
    echo '  First 10 tokens: '.implode(', ', array_slice($encoding->tokens, 0, 10))."...\n";
    echo '  First 10 IDs: ['.implode(', ', array_slice($encoding->ids, 0, 10))."...]\n\n";
}

echo "--- Processing Search Queries ---\n\n";

foreach ($searchQueries as $index => $query) {
    $encoding = $tokenizer->encode($query);

    echo 'Query '.($index + 1).": \"{$query}\"\n";
    echo '  Tokens: '.implode(', ', $encoding->tokens)."\n";
    echo '  IDs: ['.implode(', ', $encoding->ids)."]\n";
    echo '  Token count: '.count($encoding->ids)."\n\n";
}

echo "--- Round-trip Verification ---\n\n";

$testText = 'Machine learning enables pattern recognition in data.';
$encoding = $tokenizer->encode($testText);
$decoded = $tokenizer->decode($encoding->ids);

echo "Original: {$testText}\n";
echo 'Encoded: ['.implode(', ', $encoding->ids)."]\n";
echo "Decoded: {$decoded}\n";
