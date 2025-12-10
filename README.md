<p align="center">
    <h1 align="center">Tokenizers PHP</h1>
    <p align="center">
        <a href="https://github.com/codewithkyrian/tokenizers-php/actions"><img alt="GitHub Workflow Status (main)" src="https://img.shields.io/github/actions/workflow/status/codewithkyrian/tokenizers-php/tests.yml?branch=main&label=tests&style=flat-square"></a>
        <a href="https://packagist.org/packages/codewithkyrian/tokenizers"><img alt="Total Downloads" src="https://img.shields.io/packagist/dt/codewithkyrian/tokenizers?style=flat-square"></a>
        <a href="https://packagist.org/packages/codewithkyrian/tokenizers"><img alt="Latest Version" src="https://img.shields.io/packagist/v/codewithkyrian/tokenizers?style=flat-square"></a>
        <a href="https://packagist.org/packages/codewithkyrian/tokenizers"><img alt="License" src="https://img.shields.io/github/license/codewithkyrian/tokenizers-php?style=flat-square"></a>
    </p>
</p>

------

**Tokenizers PHP** is a lightweight, dependency-free PHP library for tokenizing text using the same tokenizers powering models on the Hugging Face Hub. Whether you're building LLM applications, search systems, or text processing pipelines, this library provides fast, accurate tokenization that matches the original model implementations.

## Highlights

- **Pure PHP** — No FFI, no external binaries, no compiled extensions. Works everywhere PHP runs.
- **Zero Hard Dependencies** — Core tokenization has no required dependencies. Optional HTTP client needed only for Hub downloads.
- **Hub Compatible** — Load tokenizers directly from Hugging Face Hub or from local files.
- **Fully Tested** — Validated against BERT, GPT-2, Llama, Gemma, Qwen, RoBERTa, ALBERT, and more.
- **Modern PHP** — Built for PHP 8.1+ with strict types, readonly properties, and clean interfaces.

## Installation

Install via Composer:

```bash
composer require codewithkyrian/tokenizers
```

### HTTP Client (Optional)

If you plan to load tokenizers from the Hugging Face Hub, you'll need an HTTP client implementing PSR-18. We recommend Guzzle:

```bash
composer require guzzlehttp/guzzle
```

> **Note:** The library uses [PHP-HTTP Discovery](https://github.com/php-http/discovery) to automatically find and use any PSR-18 compatible HTTP client installed in your project. If you're only loading tokenizers from local files, no HTTP client is needed.

## Quick Start

```php
use Codewithkyrian\Tokenizers\Tokenizer;

// Load a tokenizer from Hugging Face Hub
$tokenizer = Tokenizer::fromHub('bert-base-uncased');

// Encode text to token IDs
$encoding = $tokenizer->encode('Hello, how are you?');

echo implode(', ', $encoding->ids);     // 101, 7592, 1010, 2129, 2024, 2017, 1029, 102
echo implode(', ', $encoding->tokens);  // [CLS], hello, ,, how, are, you, ?, [SEP]

// Decode token IDs back to text
$text = $tokenizer->decode($encoding->ids);
echo $text; // "[CLS] hello, how are you? [SEP]"
```

## Loading Tokenizers

Tokenizers PHP provides multiple ways to load tokenizers depending on your use case.

### From Hugging Face Hub

Load any tokenizer from the Hugging Face Hub by providing the model ID:

```php
use Codewithkyrian\Tokenizers\Tokenizer;

// Load a popular model
$tokenizer = Tokenizer::fromHub('bert-base-uncased');

// Load a model from an organization
$tokenizer = Tokenizer::fromHub('meta-llama/Llama-3.1-8B-Instruct');

// With options
$tokenizer = Tokenizer::fromHub(
    modelId: 'openai/gpt-oss-20b',
    cacheDir: '/path/to/cache',      // Custom cache directory
    revision: 'main',                 // Branch, tag, or commit hash
    token: 'hf_...'                   // Auth token for private models
);
```

#### Parameters

| Parameter | Type | Default | Description |
|-----------|------|---------|-------------|
| `modelId` | `string` | — | The model identifier on Hugging Face Hub (e.g., `bert-base-uncased` or `org/model-name`) |
| `cacheDir` | `?string` | `null` | Custom directory for caching downloaded files. Defaults to system cache directory |
| `revision` | `?string` | `'main'` | Specific version to load—can be a branch name, tag, or commit hash |
| `token` | `?string` | `null` | Hugging Face authentication token for accessing private or gated models |

#### Cache Directory Resolution

When `cacheDir` is not specified, the library automatically resolves the cache location:

1. **Environment Variable** — `TOKENIZERS_CACHE` if set
2. **macOS** — `~/Library/Caches/huggingface/tokenizers`
3. **Linux** — `$XDG_CACHE_HOME/huggingface/tokenizers` or `~/.cache/huggingface/tokenizers`
4. **Windows** — `%LOCALAPPDATA%\huggingface\tokenizers`

### From Local Files

Load tokenizers from local JSON files:

```php
use Codewithkyrian\Tokenizers\Tokenizer;

// Single file (tokenizer.json with all config merged)
$tokenizer = Tokenizer::fromFile('/path/to/tokenizer.json');

// Multiple files (configs are merged, later files override earlier ones)
$tokenizer = Tokenizer::fromFile(
    '/path/to/tokenizer.json',
    '/path/to/tokenizer_config.json'
);
```

This is useful when you've downloaded model files manually or are working in an offline environment.

### From Configuration Array

Build a tokenizer from a raw configuration array:

```php
use Codewithkyrian\Tokenizers\Tokenizer;

$config = json_decode(file_get_contents('tokenizer.json'), true);
$tokenizer = Tokenizer::fromConfig($config);
```

### Universal Loader

The `load()` method provides a convenient unified interface:

```php
use Codewithkyrian\Tokenizers\Tokenizer;

// Automatically detects the source type
$tokenizer = Tokenizer::load('bert-base-uncased');           // From Hub
$tokenizer = Tokenizer::load('/path/to/tokenizer.json');     // From file
$tokenizer = Tokenizer::load($configArray);                  // From array
```

### Accessing Configuration

The tokenizer stores its configuration and provides access via `getConfig()`:

```php
$tokenizer = Tokenizer::fromHub('bert-base-uncased');

// Get a specific config value
$maxLength = $tokenizer->getConfig('model_max_length');           // 512
$cleanup = $tokenizer->getConfig('clean_up_tokenization_spaces'); // true
$custom = $tokenizer->getConfig('unknown_key', 'default');        // 'default'

// Convenience property for model_max_length
echo $tokenizer->modelMaxLength; // 512

// Get all configuration (pass null or no arguments)
$allConfig = $tokenizer->getConfig();
```

Common configuration keys:
- `model_max_length` — Maximum sequence length
- `remove_space` — Whether to remove leading/trailing spaces
- `do_lowercase_and_remove_accent` — Whether to lowercase and strip accents
- `clean_up_tokenization_spaces` — Whether to clean up spaces during decoding

> **Note:** `model_max_length` is the tokenizer's configured max length, not necessarily the model's actual context window. For most models, these are the same. However, some tokenizers (like Llama 3) set this to an extremely large value. When building applications, you may want to use known context window limits for specific models rather than relying solely on this value.

## Encoding Text

The `encode()` method tokenizes text and returns an `Encoding` object containing the token IDs, tokens, and type IDs.

```php
$encoding = $tokenizer->encode('The quick brown fox jumps over the lazy dog.');
```

### The Encoding Object

```php
$encoding->ids;      // int[] - Token IDs: [101, 1996, 4248, 2829, 4419, ...]
$encoding->tokens;   // string[] - Tokens: ['[CLS]', 'the', 'quick', 'brown', ...]
$encoding->typeIds;  // int[] - Segment IDs for sentence pairs: [0, 0, 0, ...]
```

### Encoding Options

```php
$encoding = $tokenizer->encode(
    text: 'First sentence.',
    textPair: 'Second sentence.',   // Optional second text for pair encoding
    addSpecialTokens: true          // Whether to add [CLS], [SEP], etc. (default: true)
);
```

#### Parameters

| Parameter | Type | Default | Description |
|-----------|------|---------|-------------|
| `text` | `string` | — | The primary text to tokenize |
| `textPair` | `?string` | `null` | Optional second text for sequence pair tasks (e.g., question-answering) |
| `addSpecialTokens` | `bool` | `true` | Whether to add model-specific special tokens (like `[CLS]`, `[SEP]`) |

### Sentence Pairs

For tasks involving two text sequences (like question-answering or natural language inference), pass both texts:

```php
$encoding = $tokenizer->encode(
    text: 'What is the capital of France?',
    textPair: 'Paris is the capital of France.'
);

// tokens: ['[CLS]', 'what', 'is', 'the', 'capital', 'of', 'france', '?', '[SEP]', 
//          'paris', 'is', 'the', 'capital', 'of', 'france', '.', '[SEP]']
// typeIds: [0, 0, 0, 0, 0, 0, 0, 0, 0, 1, 1, 1, 1, 1, 1, 1, 1]
```

The `typeIds` distinguish between the first sequence (0) and the second sequence (1), which many models use during attention computation.

## Decoding Tokens

Convert token IDs back to human-readable text:

```php
$text = $tokenizer->decode([101, 7592, 1010, 2129, 2024, 2017, 1029, 102]);
// "hello, how are you?"
```

### Decoding Options

```php
$text = $tokenizer->decode(
    ids: $encoding->ids,
    skipSpecialTokens: true,    // Remove [CLS], [SEP], etc. (default: true)
    cleanup: null               // Override cleanup behavior (default: use model config)
);
```

#### Parameters

| Parameter | Type | Default | Description |
|-----------|------|---------|-------------|
| `ids` | `int[]` | — | Array of token IDs to decode |
| `skipSpecialTokens` | `bool` | `true` | Whether to exclude special tokens from the output |
| `cleanup` | `?bool` | `null` | Whether to clean up tokenization artifacts (extra spaces). Uses model's config when `null` |

### Cleanup Behavior

The `cleanup` parameter controls whether tokenization artifacts are cleaned:

```php
// With cleanup (default when model config says so)
$tokenizer->decode($ids, cleanup: true);   // "hello, how are you?"

// Without cleanup
$tokenizer->decode($ids, cleanup: false);  // "hello , how are you ?"
```

When `cleanup` is `null`, the library respects the `clean_up_tokenization_spaces` setting from the model's configuration.

## Custom Tokenizers with the Builder

For advanced use cases, build tokenizers from scratch using the fluent builder API:

```php
use Codewithkyrian\Tokenizers\Tokenizer;
use Codewithkyrian\Tokenizers\Models\WordPieceModel;
use Codewithkyrian\Tokenizers\Normalizers\LowercaseNormalizer;
use Codewithkyrian\Tokenizers\PreTokenizers\WhitespacePreTokenizer;
use Codewithkyrian\Tokenizers\PostProcessors\BertPostProcessor;
use Codewithkyrian\Tokenizers\Decoders\WordPieceDecoder;

$vocab = ['[UNK]' => 0, '[CLS]' => 1, '[SEP]' => 2, 'hello' => 3, 'world' => 4, ...];

$tokenizer = Tokenizer::builder()
    ->withModel(new WordPieceModel($vocab, '[UNK]'))
    ->withNormalizer(new LowercaseNormalizer())
    ->withPreTokenizer(new WhitespacePreTokenizer())
    ->withPostProcessor(new BertPostProcessor('[CLS]', '[SEP]'))
    ->withDecoder(new WordPieceDecoder())
    ->withSpecialTokens(['[UNK]', '[CLS]', '[SEP]', '[PAD]', '[MASK]'])
    ->withConfig('model_max_length', 512)
    ->withConfig('clean_up_tokenization_spaces', true)
    ->build();
```

### Builder Methods

| Method | Description |
|--------|-------------|
| `withModel(ModelInterface $model)` | **Required.** Set the tokenization model (BPE, WordPiece, Unigram) |
| `withNormalizer(NormalizerInterface $normalizer)` | Set text normalizer. Defaults to `PassThroughNormalizer` |
| `withPreTokenizer(PreTokenizerInterface $preTokenizer)` | Set pre-tokenizer. Defaults to `IdentityPreTokenizer` |
| `withPostProcessor(PostProcessorInterface $postProcessor)` | Set post-processor. Defaults to `DefaultPostProcessor` |
| `withDecoder(DecoderInterface $decoder)` | Set decoder. Defaults to `FuseDecoder` |
| `withAddedTokens(array $tokens)` | Add extra tokens to the vocabulary |
| `withSpecialTokens(array $tokens)` | Define special tokens (skipped during decode by default) |
| `withConfig(string $key, mixed $value)` | Set a configuration value (see common keys below) |
| `build()` | Build and return the `Tokenizer` instance |

Common config keys for `withConfig()`:
- `'model_max_length'` — Maximum sequence length
- `'remove_space'` — Remove leading/trailing spaces before normalization
- `'do_lowercase_and_remove_accent'` — Lowercase and strip accents
- `'clean_up_tokenization_spaces'` — Clean up spaces during decoding

## The Tokenization Pipeline

Understanding the tokenization pipeline helps when debugging or customizing behavior. Each input text passes through these stages:

```
┌─────────────────────────────────────────────────────────────────────┐
│                        Input Text                                   │
│                "Hello, how are you doing?"                          │
└──────────────────────────┬──────────────────────────────────────────┘
                           │
                           ▼
┌─────────────────────────────────────────────────────────────────────┐
│                     1. Normalization                                │
│    • Unicode normalization (NFC, NFKC, NFD, NFKD)                   │
│    • Lowercase transformation                                       │
│    • Accent stripping                                               │
│    • Control character removal                                      │
│                                                                     │
│                → "hello, how are you doing?"                        │
└──────────────────────────┬──────────────────────────────────────────┘
                           │
                           ▼
┌─────────────────────────────────────────────────────────────────────┐
│                    2. Pre-tokenization                              │
│    • Split on whitespace and/or punctuation                         │
│    • Identify word boundaries                                       │
│                                                                     │
│                → ["hello", ",", "how", "are", "you", "doing", "?"]  │
└──────────────────────────┬──────────────────────────────────────────┘
                           │
                           ▼
┌─────────────────────────────────────────────────────────────────────┐
│                    3. Model Tokenization                            │
│    • BPE: Byte-Pair Encoding merges                                 │
│    • WordPiece: Greedy longest-match-first                          │
│    • Unigram: Probabilistic subword selection                       │
│                                                                     │
│                → ["hello", ",", "how", "are", "you", "do", "##ing", │
│                   "?"]                                              │
└──────────────────────────┬──────────────────────────────────────────┘
                           │
                           ▼
┌─────────────────────────────────────────────────────────────────────┐
│                    4. Post-processing                               │
│    • Add special tokens ([CLS], [SEP], <s>, </s>, etc.)             │
│    • Generate token type IDs for sentence pairs                     │
│                                                                     │
│                → ["[CLS]", "hello", ",", "how", "are", "you", "do", │
│                   "##ing", "?", "[SEP]"]                            │
└──────────────────────────┬──────────────────────────────────────────┘
                           │
                           ▼
┌─────────────────────────────────────────────────────────────────────┐
│                      5. ID Mapping                                  │
│    • Convert tokens to numerical IDs using vocabulary               │
│                                                                     │
│                → [101, 7592, 1010, 2129, 2024, 2017, 2079, 2075,    │
│                   1029, 102]                                        │
└─────────────────────────────────────────────────────────────────────┘
```

## Components Reference

### Normalizers

Normalizers clean and standardize input text before tokenization.

| Normalizer | Description |
|------------|-------------|
| `BertNormalizer` | BERT-style: clean text, handle Chinese chars, lowercase, strip accents |
| `LowercaseNormalizer` | Convert all characters to lowercase |
| `NFCNormalizer` | Unicode NFC normalization |
| `NFKCNormalizer` | Unicode NFKC normalization |
| `NFKDNormalizer` | Unicode NFKD normalization |
| `StripNormalizer` | Strip leading/trailing whitespace |
| `StripAccentsNormalizer` | Remove accent marks from characters |
| `ReplaceNormalizer` | Replace patterns or strings |
| `PrependNormalizer` | Prepend a string to the input |
| `PrecompiledNormalizer` | Use precompiled normalization rules (for SentencePiece models) |
| `NormalizerSequence` | Chain multiple normalizers together |
| `PassThroughNormalizer` | No-op, passes text through unchanged |

### Pre-tokenizers

Pre-tokenizers split text into smaller chunks before subword tokenization.

| Pre-tokenizer | Description |
|---------------|-------------|
| `BertPreTokenizer` | Split on whitespace and punctuation (BERT-style) |
| `ByteLevelPreTokenizer` | Convert to byte-level representation (GPT-2 style) |
| `WhitespacePreTokenizer` | Split on whitespace characters |
| `WhitespaceSplit` | Split only on whitespace, keep punctuation attached |
| `MetaspacePreTokenizer` | Replace spaces with ▁ (SentencePiece style) |
| `PunctuationPreTokenizer` | Split on punctuation characters |
| `DigitsPreTokenizer` | Isolate digit sequences |
| `SplitPreTokenizer` | Split using custom regex patterns |
| `PreTokenizerSequence` | Chain multiple pre-tokenizers together |
| `IdentityPreTokenizer` | No-op, returns text unchanged |

### Models

Models perform the core subword tokenization algorithm.

| Model | Description |
|-------|-------------|
| `BPEModel` | Byte-Pair Encoding - iteratively merges most frequent pairs |
| `WordPieceModel` | Greedy longest-match-first subword tokenization (BERT) |
| `UnigramModel` | Probabilistic subword selection (SentencePiece) |
| `FallbackModel` | Simple vocabulary lookup with unknown token fallback |

### Post-processors

Post-processors add special tokens and structure to the tokenized output.

| Post-processor | Description |
|----------------|-------------|
| `BertPostProcessor` | Add `[CLS]` and `[SEP]` tokens |
| `RobertaPostProcessor` | Add `<s>` and `</s>` tokens with spacing |
| `TemplatePostProcessor` | Flexible template-based token insertion |
| `ByteLevelPostProcessor` | Handle byte-level special tokens |
| `PostProcessorSequence` | Chain multiple post-processors |
| `DefaultPostProcessor` | Minimal processing, no tokens added |

### Decoders

Decoders convert tokens back to readable text.

| Decoder | Description |
|---------|-------------|
| `ByteLevelDecoder` | Decode byte-level tokens back to UTF-8 |
| `WordPieceDecoder` | Handle `##` continuation prefixes |
| `MetaspaceDecoder` | Convert `▁` back to spaces |
| `BPEDecoder` | Handle BPE-specific suffixes and spaces |
| `CTCDecoder` | Decode CTC (Connectionist Temporal Classification) output |
| `FuseDecoder` | Simply join tokens with optional separator |
| `ReplaceDecoder` | Replace specific patterns during decode |
| `StripDecoder` | Strip specific characters |
| `ByteFallbackDecoder` | Handle byte fallback tokens (e.g., `<0x00>`) |
| `DecoderSequence` | Chain multiple decoders together |

## Extending the Library

All components implement simple interfaces that you can extend:

```php
use Codewithkyrian\Tokenizers\Contracts\NormalizerInterface;

class CustomNormalizer implements NormalizerInterface
{
    public function normalize(string $text): string
    {
        // Your custom normalization logic
        return $modifiedText;
    }
}
```

Available interfaces:

- `NormalizerInterface` — Text normalization
- `PreTokenizerInterface` — Pre-tokenization splitting
- `ModelInterface` — Core tokenization algorithm
- `PostProcessorInterface` — Post-processing and special tokens
- `DecoderInterface` — Token-to-text conversion

## Contributing

Contributions are welcome! Please feel free to submit a Pull Request. For major changes, please open an issue first to discuss what you would like to change.

```bash
# Clone the repository
git clone https://github.com/codewithkyrian/tokenizers-php.git
cd tokenizers-php

# Install dependencies
composer install

# Run tests
vendor/bin/pest
```

## License

This project is licensed under the MIT License - see the [LICENSE](LICENSE) file for details.

## Credits

- [Kyrian Obikwelu](https://github.com/CodeWithKyrian) — Creator and maintainer
- [Hugging Face](https://huggingface.co) — Tokenizers specification and model hosting
- All [contributors](https://github.com/codewithkyrian/tokenizers-php/contributors)

---

<p align="center">
    Made with ❤️ for the PHP community
</p>

