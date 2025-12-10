<?php

declare(strict_types=1);

/**
 * Context Window Fit Analysis.
 *
 * This example demonstrates how to analyze whether a conversation fits within
 * different LLM context windows. Each model family has its own:
 * - Tokenizer (vocabulary and encoding rules)
 * - Chat template format (how messages are structured)
 * - Context window limits (available via $tokenizer->modelMaxLength)
 *
 * NOTE: Chat templates are typically Jinja templates stored in the tokenizer config.
 * You can install `codewithkyrian/jinja-php` to parse and render them dynamically:
 *
 *     composer require codewithkyrian/jinja-php
 *
 * Here we manually implement each model's chat template format.
 */

require __DIR__.'/../vendor/autoload.php';

use Codewithkyrian\Tokenizers\Tokenizer;

/**
 * Chat template implementations for different model families.
 * Each model uses a different format for structuring conversations.
 */

/**
 * ChatML format (Qwen, Yi, GPT-4o, etc.)
 * Template: <|im_start|>role\ncontent<|im_end|>.
 */
function applyChatMLTemplate(array $messages, bool $addGenerationPrompt = true): string
{
    $formatted = '';

    foreach ($messages as $message) {
        $formatted .= "<|im_start|>{$message['role']}\n{$message['content']}<|im_end|>\n";
    }

    if ($addGenerationPrompt) {
        $formatted .= "<|im_start|>assistant\n";
    }

    return $formatted;
}

/**
 * Llama 3 format
 * Template: <|start_header_id|>role<|end_header_id|>\n\ncontent<|eot_id|>.
 */
function applyLlama3Template(array $messages, bool $addGenerationPrompt = true): string
{
    $formatted = '<|begin_of_text|>';

    foreach ($messages as $message) {
        $formatted .= "<|start_header_id|>{$message['role']}<|end_header_id|>\n\n";
        $formatted .= "{$message['content']}<|eot_id|>";
    }

    if ($addGenerationPrompt) {
        $formatted .= "<|start_header_id|>assistant<|end_header_id|>\n\n";
    }

    return $formatted;
}

/**
 * Claude format (Anthropic)
 * Template: \n\nHuman: content\n\nAssistant: content.
 */
function applyClaudeTemplate(array $messages, bool $addGenerationPrompt = true): string
{
    $formatted = '';

    foreach ($messages as $message) {
        $role = match ($message['role']) {
            'system' => 'Human', // Claude handles system via system parameter, but we include it here
            'user' => 'Human',
            'assistant' => 'Assistant',
            default => $message['role'],
        };

        // System messages are typically prepended to the first human message
        if ('system' === $message['role']) {
            $formatted .= "{$message['content']}\n\n";

            continue;
        }

        $formatted .= "\n\n{$role}: {$message['content']}";
    }

    if ($addGenerationPrompt) {
        $formatted .= "\n\nAssistant:";
    }

    return trim($formatted);
}

$models = [
    'Qwen2-1.5B-Instruct' => [
        'hub_id' => 'Qwen/Qwen2-1.5B-Instruct',
        'template_fn' => 'applyChatMLTemplate',
    ],
    'Llama-3' => [
        'hub_id' => 'Xenova/llama3-tokenizer',
        'template_fn' => 'applyLlama3Template',
        'context_window' => 8192,
    ],
    'GPT-4o' => [
        'hub_id' => 'Xenova/gpt-4o',
        'template_fn' => 'applyChatMLTemplate',
    ],
    'Claude-Sonnet-4' => [
        'hub_id' => 'Xenova/claude-tokenizer',
        'template_fn' => 'applyClaudeTemplate',
    ],
    'Grok-1' => [
        'hub_id' => 'Xenova/grok-1-tokenizer',
        'template_fn' => 'applyChatMLTemplate',
    ],
    'DeepSeek-V3.2' => [
        'hub_id' => 'deepseek-ai/DeepSeek-V3.2',
        'template_fn' => 'applyChatMLTemplate',
    ],
];

$conversation = [
    [
        'role' => 'system',
        'content' => 'You are a helpful customer support assistant for TechCorp. Be concise, professional, and always offer to escalate complex issues to a human agent.',
    ],
    [
        'role' => 'user',
        'content' => 'Hi, I purchased a laptop last week and the screen keeps flickering. I\'ve tried restarting it multiple times but the issue persists.',
    ],
    [
        'role' => 'assistant',
        'content' => 'I\'m sorry to hear about the screen flickering issue with your new laptop. This could be caused by a few things - a driver issue, loose display cable, or a hardware defect. Let me help you troubleshoot. First, could you tell me the laptop model and whether you\'ve updated the graphics drivers recently?',
    ],
    [
        'role' => 'user',
        'content' => 'It\'s the TechCorp ProBook 15. I haven\'t updated any drivers since I got it. The flickering happens randomly, sometimes every few minutes, sometimes it doesn\'t happen for hours.',
    ],
    [
        'role' => 'assistant',
        'content' => 'Thank you for those details. The intermittent nature suggests it might be a driver or software issue rather than hardware. Let\'s try updating your graphics drivers first. Go to Settings > Windows Update > Check for updates, and also check for optional driver updates. If that doesn\'t resolve it within 24 hours, we can arrange a diagnostic or replacement under your warranty.',
    ],
    [
        'role' => 'user',
        'content' => 'Okay, I\'ll try that. If it doesn\'t work, how do I arrange the diagnostic? And will I lose my data?',
    ],
];

echo "=== Context Window Fit Analysis ===\n\n";
echo "Analyzing the same conversation across different LLM tokenizers.\n";
echo 'Messages: '.count($conversation)."\n\n";

$results = [];

foreach ($models as $modelName => $config) {
    echo "Loading {$modelName}...\n";

    $tokenizer = Tokenizer::fromHub($config['hub_id']);
    $templateFn = $config['template_fn'];
    $formattedPrompt = $templateFn($conversation);
    $encoding = $tokenizer->encode($formattedPrompt);
    $tokenCount = count($encoding->ids);
    $contextWindow = $config['context_window'] ?? $tokenizer->modelMaxLength;

    $results[$modelName] = [
        'tokens' => $tokenCount,
        'context_window' => $contextWindow,
        'percent_used' => $contextWindow ? round(($tokenCount / $contextWindow) * 100, 2) : null,
        'remaining' => $contextWindow ? $contextWindow - $tokenCount : null,
        'fits' => $contextWindow ? $tokenCount <= $contextWindow : null,
    ];
}

echo "\n".str_repeat('=', 85)."\n";
echo "RESULTS\n";
echo str_repeat('=', 85)."\n\n";

// Header
printf(
    "%-20s │ %10s │ %15s │ %8s │ %15s │ %s\n",
    'Model',
    'Tokens',
    'Context Window',
    'Used %',
    'Remaining',
    'Status'
);
echo str_repeat('─', 85)."\n";

foreach ($results as $modelName => $data) {
    $contextStr = null !== $data['context_window']
        ? number_format($data['context_window'])
        : 'N/A';

    $percentStr = null !== $data['percent_used']
        ? $data['percent_used'].'%'
        : 'N/A';

    $remainingStr = null !== $data['remaining']
        ? number_format($data['remaining'])
        : 'N/A';

    $status = match (true) {
        null === $data['fits'] => '? Unknown',
        $data['fits'] => '✓ Fits',
        default => '✗ Exceeds',
    };

    printf(
        "%-20s │ %10s │ %15s │ %8s │ %15s │ %s\n",
        $modelName,
        number_format($data['tokens']),
        $contextStr,
        $percentStr,
        $remainingStr,
        $status
    );
}

echo str_repeat('─', 85)."\n\n";
