<?php

declare(strict_types=1);

namespace Codewithkyrian\Tokenizers\Tests\Feature\Models;

use Codewithkyrian\Tokenizers\Tests\Datasets\Models\BertDataset;
use Codewithkyrian\Tokenizers\Tokenizer;

dataset('bert-tokenization', modelTokenizationDataset(BertDataset::class, true));

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
})->with('bert-tokenization');
