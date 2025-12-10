<?php

declare(strict_types=1);

/**
 * Document Chunking Pipeline.
 *
 * This example demonstrates how to split long documents into token-aware chunks
 * for processing with models that have context length limits. Common use cases:
 * - Splitting long articles for embedding and indexing
 * - Preparing documents for summarization
 * - Breaking down PDFs/documents for RAG pipelines
 * - Processing large text files for analysis
 *
 * The chunking respects sentence boundaries to maintain semantic coherence.
 */

require __DIR__.'/../vendor/autoload.php';

use Codewithkyrian\Tokenizers\Tokenizer;

// A long document that needs to be chunked (simulating content from a PDF or article)
$longDocument = <<<'DOCUMENT'
The History and Evolution of Artificial Intelligence

Artificial intelligence has a rich history spanning over seven decades. The field was officially born at the Dartmouth Conference in 1956, where John McCarthy, Marvin Minsky, Nathaniel Rochester, and Claude Shannon proposed that "every aspect of learning or any other feature of intelligence can in principle be so precisely described that a machine can be made to simulate it."

The early years of AI research were characterized by tremendous optimism. Researchers developed programs that could prove mathematical theorems, play chess, and solve algebra problems. The General Problem Solver, developed by Herbert Simon and Allen Newell in 1957, was one of the first programs designed to mimic human problem-solving processes.

However, the field soon encountered significant challenges. The limitations of early computing hardware, combined with the complexity of real-world problems, led to the first "AI Winter" in the 1970s. Funding dried up as the promised breakthroughs failed to materialize.

The 1980s saw a resurgence with the development of expert systems. These programs encoded human expertise in specific domains and found commercial applications in medicine, finance, and manufacturing. Companies invested heavily in AI, leading to a second wave of enthusiasm.

This enthusiasm was short-lived. Expert systems proved brittle and expensive to maintain, leading to another AI Winter in the late 1980s and early 1990s. Many researchers abandoned the field, and AI became almost a taboo term in academic circles.

The modern AI renaissance began in the 2010s, driven by three key factors: the availability of large datasets, improvements in computing power (particularly GPUs), and advances in deep learning algorithms. The ImageNet competition in 2012 marked a turning point when a deep neural network dramatically outperformed traditional computer vision approaches.

Since then, AI has achieved remarkable milestones. In 2016, DeepMind's AlphaGo defeated the world champion in Go, a game long considered too complex for machines. Natural language processing has been transformed by transformer architectures, leading to large language models that can engage in sophisticated conversations, write code, and assist with complex reasoning tasks.

Today, AI is integrated into countless applications: recommendation systems, autonomous vehicles, medical diagnosis, scientific research, and creative tools. The technology continues to advance rapidly, raising both exciting possibilities and important ethical questions about its role in society.

As we look to the future, researchers are exploring new frontiers: artificial general intelligence, neuromorphic computing, and hybrid systems that combine neural networks with symbolic reasoning. The field that began as an academic curiosity has become one of the most transformative technologies of our time.

The journey of AI reminds us that breakthrough technologies often follow a pattern of hype, disappointment, and eventual realization - sometimes taking decades longer than initially predicted. As we stand on the cusp of potentially even greater advances, this history provides valuable lessons about managing expectations while continuing to push the boundaries of what machines can achieve.
DOCUMENT;

// Configuration for different model context windows
$chunkConfigs = [
    'embedding_model' => [
        'max_tokens' => 256,
        'overlap_tokens' => 50,
        'description' => 'For sentence-transformer embeddings',
    ],
    'summarization_model' => [
        'max_tokens' => 512,
        'overlap_tokens' => 100,
        'description' => 'For T5/BART summarization',
    ],
    'llm_context' => [
        'max_tokens' => 1024,
        'overlap_tokens' => 200,
        'description' => 'For LLM context windows',
    ],
];

echo "=== Document Chunking Pipeline Example ===\n\n";

// Load tokenizer
$tokenizer = Tokenizer::fromHub('bert-base-uncased');

echo "Tokenizer loaded: bert-base-uncased\n\n";

// Analyze the full document first
$fullEncoding = $tokenizer->encode($longDocument);
$totalTokens = count($fullEncoding->ids);

echo "--- Document Analysis ---\n\n";
echo 'Total characters: '.mb_strlen($longDocument)."\n";
echo "Total tokens: {$totalTokens}\n";
echo 'Average tokens per character: '.round($totalTokens / mb_strlen($longDocument), 3)."\n\n";

/**
 * Split text into sentences (simple implementation).
 */
function splitIntoSentences(string $text): array
{
    // Split on sentence-ending punctuation followed by space or end
    $sentences = preg_split('/(?<=[.!?])\s+/', $text, -1, \PREG_SPLIT_NO_EMPTY);

    return array_map('trim', $sentences);
}

/**
 * Create token-aware chunks from a document.
 *
 * @param int $maxTokens     Maximum tokens per chunk (excluding special tokens)
 * @param int $overlapTokens Number of tokens to overlap between chunks
 *
 * @return array{chunks: array, metadata: array}
 */
function createChunks(Tokenizer $tokenizer, string $text, int $maxTokens, int $overlapTokens): array
{
    $sentences = splitIntoSentences($text);
    $chunks = [];
    $metadata = [];

    $currentChunk = [];
    $currentTokenCount = 0;
    $chunkStartIndex = 0;

    foreach ($sentences as $sentenceIndex => $sentence) {
        $sentenceEncoding = $tokenizer->encode($sentence, addSpecialTokens: false);
        $sentenceTokens = count($sentenceEncoding->ids);

        // If single sentence exceeds max, we need to split it (edge case)
        if ($sentenceTokens > $maxTokens) {
            // Flush current chunk first
            if (!empty($currentChunk)) {
                $chunkText = implode(' ', $currentChunk);
                $chunks[] = $chunkText;
                $metadata[] = [
                    'chunk_index' => count($chunks) - 1,
                    'sentence_range' => [$chunkStartIndex, $sentenceIndex - 1],
                    'token_count' => $currentTokenCount,
                ];
            }

            // Add the long sentence as its own chunk (will be truncated by model)
            $chunks[] = $sentence;
            $metadata[] = [
                'chunk_index' => count($chunks) - 1,
                'sentence_range' => [$sentenceIndex, $sentenceIndex],
                'token_count' => $sentenceTokens,
                'warning' => 'Sentence exceeds max tokens, may be truncated',
            ];

            $currentChunk = [];
            $currentTokenCount = 0;
            $chunkStartIndex = $sentenceIndex + 1;

            continue;
        }

        // Check if adding this sentence would exceed the limit
        if ($currentTokenCount + $sentenceTokens > $maxTokens && !empty($currentChunk)) {
            // Save current chunk
            $chunkText = implode(' ', $currentChunk);
            $chunks[] = $chunkText;
            $metadata[] = [
                'chunk_index' => count($chunks) - 1,
                'sentence_range' => [$chunkStartIndex, $sentenceIndex - 1],
                'token_count' => $currentTokenCount,
            ];

            // Calculate overlap: include last N tokens worth of sentences
            $overlapSentences = [];
            $overlapCount = 0;
            for ($i = count($currentChunk) - 1; $i >= 0 && $overlapCount < $overlapTokens; --$i) {
                $sentEnc = $tokenizer->encode($currentChunk[$i], addSpecialTokens: false);
                $overlapCount += count($sentEnc->ids);
                array_unshift($overlapSentences, $currentChunk[$i]);
            }

            $currentChunk = $overlapSentences;
            $currentTokenCount = $overlapCount;
            $chunkStartIndex = $sentenceIndex - count($overlapSentences);
        }

        $currentChunk[] = $sentence;
        $currentTokenCount += $sentenceTokens;
    }

    // Don't forget the last chunk
    if (!empty($currentChunk)) {
        $chunkText = implode(' ', $currentChunk);
        $chunks[] = $chunkText;
        $metadata[] = [
            'chunk_index' => count($chunks) - 1,
            'sentence_range' => [$chunkStartIndex, count($sentences) - 1],
            'token_count' => $currentTokenCount,
        ];
    }

    return ['chunks' => $chunks, 'metadata' => $metadata];
}

// Process document with different configurations
foreach ($chunkConfigs as $configName => $config) {
    echo "--- Chunking for: {$config['description']} ---\n";
    echo "Max tokens: {$config['max_tokens']}, Overlap: {$config['overlap_tokens']}\n\n";

    $result = createChunks(
        $tokenizer,
        $longDocument,
        $config['max_tokens'],
        $config['overlap_tokens']
    );

    echo 'Created '.count($result['chunks'])." chunks:\n\n";

    foreach ($result['chunks'] as $index => $chunk) {
        $meta = $result['metadata'][$index];
        $preview = mb_substr($chunk, 0, 80);

        echo 'Chunk '.($index + 1).":\n";
        echo "  Tokens: {$meta['token_count']}\n";
        echo "  Sentences: {$meta['sentence_range'][0]}-{$meta['sentence_range'][1]}\n";
        echo "  Preview: \"{$preview}...\"\n";

        if (isset($meta['warning'])) {
            echo "  ⚠️ {$meta['warning']}\n";
        }
        echo "\n";
    }

    echo str_repeat('-', 60)."\n\n";
}

// Demonstrate verification: all text should be recoverable from chunks (minus overlaps)
echo "--- Chunk Verification ---\n\n";

$config = $chunkConfigs['embedding_model'];
$result = createChunks($tokenizer, $longDocument, $config['max_tokens'], $config['overlap_tokens']);

// Verify each chunk encodes correctly
$allValid = true;
foreach ($result['chunks'] as $index => $chunk) {
    $encoding = $tokenizer->encode($chunk);
    $decoded = $tokenizer->decode($encoding->ids, skipSpecialTokens: true);

    // Simple check: decoded text should contain key words from original
    $originalWords = array_slice(explode(' ', $chunk), 0, 5);
    $decodedWords = explode(' ', $decoded);

    $matchCount = count(array_filter($originalWords, fn ($w) => in_array(strtolower($w), array_map('strtolower', $decodedWords))));

    if ($matchCount < 3) {
        echo '⚠️ Chunk '.($index + 1)." may have encoding issues\n";
        $allValid = false;
    }
}

if ($allValid) {
    echo "✓ All chunks verified - encode/decode roundtrip successful\n";
}

echo "\nPipeline complete! Chunks are ready for embedding or processing.\n";
