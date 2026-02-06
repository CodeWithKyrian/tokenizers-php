<?php

declare(strict_types=1);

use Codewithkyrian\Tokenizers\Contracts\DecoderInterface;
use Codewithkyrian\Tokenizers\Contracts\ModelInterface;
use Codewithkyrian\Tokenizers\Contracts\NormalizerInterface;
use Codewithkyrian\Tokenizers\Contracts\PostProcessorInterface;
use Codewithkyrian\Tokenizers\Contracts\PreTokenizerInterface;
use Codewithkyrian\Tokenizers\TokenizerBuilder;

function createMockModel(): ModelInterface
{
    return new class implements ModelInterface {
        /** @var array<int, string> */
        private array $vocab;

        /** @var array<string, int> */
        private array $reverse;

        public function __construct()
        {
            $this->vocab = [1 => 'HELLO', 2 => 'WORLD'];
            $this->reverse = array_flip($this->vocab);
        }

        public function tokenize(array $tokens): array
        {
            return $tokens;
        }

        public function encode(array $tokens): array
        {
            return array_map(fn(string $token) => $this->reverse[$token] ?? 0, $tokens);
        }

        public function decode(array $ids): array
        {
            return array_map(fn(int $id) => $this->vocab[$id] ?? '<unk>', $ids);
        }

        public function getVocab(): array
        {
            return $this->vocab;
        }

        public function getVocabSize(): int
        {
            return count($this->vocab);
        }

        public function addToken(string $token, int $id): void
        {
            $this->vocab[$token] = $id;
            $this->reverse[$id] = $token;
        }

        public function getConfig(?string $key = null, mixed $default = null): mixed
        {
            return [];
        }
    };
}

function createMockNormalizer(): NormalizerInterface
{
    return new class implements NormalizerInterface {
        public function normalize(string $text): string
        {
            return strtoupper($text);
        }

        public function getConfig(?string $key = null, mixed $default = null): mixed
        {
            return [];
        }
    };
}

function createMockPreTokenizer(): PreTokenizerInterface
{
    return new class implements PreTokenizerInterface {
        public function preTokenize(array|string $text, array $options = []): array
        {
            return is_array($text) ? $text : preg_split('/\s+/', trim($text));
        }

        public function getConfig(?string $key = null, mixed $default = null): mixed
        {
            return [];
        }
    };
}

function createMockPostProcessor(): PostProcessorInterface
{
    return new class implements PostProcessorInterface {
        public function process(array $tokens, ?array $pair = null, bool $addSpecialTokens = true): array
        {
            $typeIds = array_fill(0, count($tokens), 0);

            return [$tokens, $typeIds];
        }

        public function getConfig(?string $key = null, mixed $default = null): mixed
        {
            return [];
        }
    };
}

function createMockDecoder(): DecoderInterface
{
    return new class implements DecoderInterface {
        public function decode(array $tokens): string
        {
            return implode(' ', $tokens);
        }

        public function getConfig(?string $key = null, mixed $default = null): mixed
        {
            return [];
        }
    };
}

it('builds a tokenizer with custom components', function () {
    $tokenizer = (new TokenizerBuilder())
        ->withModel(createMockModel())
        ->withNormalizer(createMockNormalizer())
        ->withPreTokenizer(createMockPreTokenizer())
        ->withPostProcessor(createMockPostProcessor())
        ->withDecoder(createMockDecoder())
        ->withConfig('remove_space', true)
        ->withConfig('do_lowercase_and_remove_accent', true)
        ->withConfig('clean_up_tokenization_spaces', false)
        ->build()
    ;

    $encoding = $tokenizer->encode('hello world');

    expect($encoding->tokens)->toBe(['HELLO', 'WORLD'])
        ->and($encoding->ids)->toBe([1, 2])
    ;

    $decoded = $tokenizer->decode($encoding->ids, skipSpecialTokens: false);
    expect($decoded)->toBe('HELLO WORLD');
});

it('passes config values to the tokenizer correctly', function () {
    $tokenizer = (new TokenizerBuilder())
        ->withModel(createMockModel())
        ->withConfig('model_max_length', 512)
        ->withConfig('remove_space', true)
        ->withConfig('clean_up_tokenization_spaces', false)
        ->withConfig('custom_option', 'custom_value')
        ->build()
    ;

    expect($tokenizer->modelMaxLength)->toBe(512)
        ->and($tokenizer->getConfig('remove_space'))->toBeTrue()
        ->and($tokenizer->getConfig('clean_up_tokenization_spaces'))->toBeFalse()
        ->and($tokenizer->getConfig('custom_option'))->toBe('custom_value')
        ->and($tokenizer->getConfig('nonexistent', 'default'))->toBe('default')
    ;
});

it('returns all config when getConfig is called without key', function () {
    $tokenizer = (new TokenizerBuilder())
        ->withModel(createMockModel())
        ->withConfig('model_max_length', 1024)
        ->withConfig('remove_space', false)
        ->build()
    ;

    $allConfig = $tokenizer->getConfig();

    expect($allConfig)->toBeArray()
        ->and($allConfig['model_max_length'])->toBe(1024)
        ->and($allConfig['remove_space'])->toBeFalse()
    ;
});

it('throws exception when building without a model', function () {
    (new TokenizerBuilder())->build();
})->throws(Exception::class, 'A model is required to build a Tokenizer.');

it('uses default components when not specified', function () {
    $tokenizer = (new TokenizerBuilder())
        ->withModel(createMockModel())
        ->build()
    ;

    // Should not throw, defaults are used
    $encoding = $tokenizer->encode('HELLO WORLD');
    expect($encoding->ids)->toBeArray();
});

it('sets modelMaxLength from config', function () {
    $tokenizer = (new TokenizerBuilder())
        ->withModel(createMockModel())
        ->withConfig('model_max_length', 2048)
        ->build()
    ;

    expect($tokenizer->modelMaxLength)->toBe(2048);
});

it('has null modelMaxLength when not configured', function () {
    $tokenizer = (new TokenizerBuilder())
        ->withModel(createMockModel())
        ->build()
    ;

    expect($tokenizer->modelMaxLength)->toBeNull();
});
