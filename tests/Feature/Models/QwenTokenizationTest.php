<?php

declare(strict_types=1);

namespace Codewithkyrian\Tokenizers\Tests\Feature\Models;

use Codewithkyrian\Tokenizers\Tests\Datasets\Models\QwenDataset;
use Codewithkyrian\Tokenizers\Tokenizer;

dataset('qwen-tokenization', modelTokenizationDataset(QwenDataset::class));

test('tokenizes text correctly', function (
    string $modelId,
    string $text,
    array $expectedTokens,
    array $expectedIds,
    string $expectedDecoded
) {
    $tokenizer = Tokenizer::fromHub($modelId);
    $encoding = $tokenizer->encode($text);

    expect($encoding->ids)->toBe($expectedIds)
        ->and($encoding->tokens)->toBe($expectedTokens)
    ;

    $decoded = $tokenizer->decode($encoding->ids, skipSpecialTokens: false);
    expect($decoded)->toBe($expectedDecoded);
})->with('qwen-tokenization');
