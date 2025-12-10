<?php

declare(strict_types=1);

namespace Codewithkyrian\Tokenizers\Tests\Feature\Models;

use Codewithkyrian\Tokenizers\Tests\Datasets\Models\LlamaDataset;
use Codewithkyrian\Tokenizers\Tokenizer;

dataset('llama-tokenization', modelTokenizationDataset(LlamaDataset::class));

it('tokenizes text correctly', function (
    string $modelId,
    string $text,
    array $expectedTokens,
    array $expectedIds,
    string $expectedDecoded,
    ?string $textPair = null
) {
    $tokenizer = Tokenizer::fromHub($modelId);
    $encoding = $tokenizer->encode($text, $textPair);

    expect($encoding->ids)->toBe($expectedIds)
        ->and($encoding->tokens)->toBe($expectedTokens)
    ;

    $decoded = $tokenizer->decode($encoding->ids, skipSpecialTokens: false);
    expect($decoded)->toBe($expectedDecoded);
})->with('llama-tokenization');
