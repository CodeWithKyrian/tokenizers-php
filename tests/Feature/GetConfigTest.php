<?php

use Codewithkyrian\Tokenizers\Decoders\BPEDecoder;
use Codewithkyrian\Tokenizers\Models\BPEModel;
use Codewithkyrian\Tokenizers\Normalizers\LowercaseNormalizer;
use Codewithkyrian\Tokenizers\PostProcessors\BertPostProcessor;
use Codewithkyrian\Tokenizers\PreTokenizers\WhitespacePreTokenizer;
use Codewithkyrian\Tokenizers\Tokenizer;

it('can get config from tokenizer', function () {
    $vocab = ['a' => 0, 'b' => 1, '[UNK]' => 2];
    $merges = ['a b'];
    $expectedMerges = [['a', 'b']];
    $model = new BPEModel(
        vocab: $vocab,
        merges: $merges,
        unkToken: '[UNK]'
    );

    $normalizer = new LowercaseNormalizer();
    $preTokenizer = new WhitespacePreTokenizer();
    $postProcessor = new BertPostProcessor(sep: '[SEP]', cls: '[CLS]');
    $decoder = new BPEDecoder(suffix: '</w>');

    $tokenizer = new Tokenizer(
        model: $model,
        normalizer: $normalizer,
        preTokenizer: $preTokenizer,
        postProcessor: $postProcessor,
        decoder: $decoder
    );

    // Test specific key access
    expect($tokenizer->getConfig('model.vocab'))->toBe($vocab);
    expect($tokenizer->getConfig('model.merges'))->toBe($expectedMerges);
    expect($tokenizer->getConfig('model.unk_token'))->toBe('[UNK]');

    expect($tokenizer->getConfig('normalizer.type'))->toBe('Lowercase');

    expect($tokenizer->getConfig('pre_tokenizer.type'))->toBe('Whitespace');

    // BertPostProcessor returns [token, id] structure for compatibility
    expect($tokenizer->getConfig('post_processor.sep'))->toBe(['[SEP]', 0]);
    expect($tokenizer->getConfig('post_processor.cls'))->toBe(['[CLS]', 0]);

    expect($tokenizer->getConfig('decoder.suffix'))->toBe('</w>');

    // Test component config retrieval
    $modelConfig = $tokenizer->getConfig('model');
    expect($modelConfig['type'])->toBe('BPE');
    expect($modelConfig['vocab'])->toBe($vocab);

    // Test full config reconstruction
    $fullConfig = $tokenizer->getConfig();

    expect($fullConfig)->toBeArray();
    expect($fullConfig['model']['type'])->toBe('BPE');
    expect($fullConfig['normalizer']['type'])->toBe('Lowercase');
    expect($fullConfig['pre_tokenizer']['type'])->toBe('Whitespace');
    expect($fullConfig['post_processor']['type'])->toBe('BertProcessing');
    expect($fullConfig['decoder']['type'])->toBe('BPEDecoder');
});
