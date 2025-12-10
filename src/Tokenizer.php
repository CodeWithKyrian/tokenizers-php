<?php

declare(strict_types=1);

namespace Codewithkyrian\Tokenizers;

use Codewithkyrian\Tokenizers\Contracts\DecoderInterface;
use Codewithkyrian\Tokenizers\Contracts\ModelInterface;
use Codewithkyrian\Tokenizers\Contracts\NormalizerInterface;
use Codewithkyrian\Tokenizers\Contracts\PostProcessorInterface;
use Codewithkyrian\Tokenizers\Contracts\PreTokenizerInterface;
use Codewithkyrian\Tokenizers\DataStructures\AddedToken;
use Codewithkyrian\Tokenizers\DataStructures\DictionarySplitter;
use Codewithkyrian\Tokenizers\Decoders\FuseDecoder;
use Codewithkyrian\Tokenizers\Factories\DecoderFactory;
use Codewithkyrian\Tokenizers\Factories\ModelFactory;
use Codewithkyrian\Tokenizers\Factories\NormalizerFactory;
use Codewithkyrian\Tokenizers\Factories\PostProcessorFactory;
use Codewithkyrian\Tokenizers\Factories\PreTokenizerFactory;
use Codewithkyrian\Tokenizers\Loaders\FileLoader;
use Codewithkyrian\Tokenizers\Loaders\HubLoader;
use Codewithkyrian\Tokenizers\Normalizers\PassThroughNormalizer;
use Codewithkyrian\Tokenizers\PostProcessors\DefaultPostProcessor;
use Codewithkyrian\Tokenizers\PreTokenizers\IdentityPreTokenizer;
use Codewithkyrian\Tokenizers\Utils\DecoderUtils;
use Codewithkyrian\Tokenizers\Utils\NormalizerUtils;

class Tokenizer
{
    /**
     * The model's maximum sequence length (convenience accessor for config).
     */
    public readonly ?int $modelMaxLength;
    protected DictionarySplitter $addedTokensSplitter;

    /**
     * @param ModelInterface            $model         The model to use
     * @param NormalizerInterface       $normalizer    The normalizer to use
     * @param PreTokenizerInterface     $preTokenizer  The pre-tokenizer to use
     * @param PostProcessorInterface    $postProcessor The post-processor to use
     * @param DecoderInterface          $decoder       The decoder to use
     * @param string[]                  $specialTokens The special tokens to use
     * @param array<string, AddedToken> $addedTokens   The added tokens keyed by content
     * @param array<string, mixed>      $config        Additional configuration options
     */
    public function __construct(
        protected ModelInterface $model,
        protected NormalizerInterface $normalizer,
        protected PreTokenizerInterface $preTokenizer,
        protected PostProcessorInterface $postProcessor,
        protected DecoderInterface $decoder,
        protected array $specialTokens = [],
        protected array $addedTokens = [],
        protected array $config = []
    ) {
        $this->addedTokensSplitter = new DictionarySplitter(array_keys($this->addedTokens));

        $maxLength = $this->config['model_max_length'] ?? null;
        $this->modelMaxLength = null !== $maxLength ? (int) $maxLength : null;
    }

    /**
     * Get configuration value(s).
     *
     * @param null|string $key     The configuration key (e.g., 'model_max_length', 'remove_space'). If null, returns all config.
     * @param mixed       $default The default value if the key doesn't exist (ignored when $key is null)
     *
     * @return mixed the configuration value, or full config array if $key is null
     */
    public function getConfig(?string $key = null, mixed $default = null): mixed
    {
        if (null === $key) {
            return $this->config;
        }

        return $this->config[$key] ?? $default;
    }

    /**
     * Load a tokenizer from a file, the Hugging Face Hub, or a configuration array.
     *
     * @param array<string, mixed>|string $source  the source to load the tokenizer from
     * @param mixed                       ...$args The arguments to load the tokenizer from.
     *
     * @return self The loaded tokenizer
     */
    public static function load(array|string $source, ...$args): self
    {
        if (\is_array($source)) {
            return self::fromConfig($source);
        }

        if (file_exists($source)) {
            return self::fromFile($source);
        }

        $cacheDir = $args['cacheDir'] ?? null;
        $revision = $args['revision'] ?? 'main';
        $token = $args['token'] ?? null;

        return self::fromHub($source, $cacheDir, $revision, $token);
    }

    /**
     * Load a tokenizer from a file.
     *
     * @param string ...$paths The paths to the files to load the tokenizer from.
     *
     * @return self The loaded tokenizer
     */
    public static function fromFile(string ...$paths): self
    {
        $loader = new FileLoader();
        $config = $loader->load(...$paths);

        return self::fromConfig($config);
    }

    /**
     * Load a tokenizer from the Hugging Face Hub.
     *
     * @param string      $modelId  the model ID to load the tokenizer from
     * @param null|string $cacheDir the cache directory to use
     * @param null|string $revision the revision to use
     * @param null|string $token    the token to use
     *
     * @return self The loaded tokenizer
     */
    public static function fromHub(string $modelId, ?string $cacheDir = null, ?string $revision = 'main', ?string $token = null): self
    {
        $loader = new HubLoader($cacheDir, $revision, $token);
        $config = $loader->load($modelId);

        return self::fromConfig($config);
    }

    /**
     * Load a tokenizer from a configuration array.
     *
     * @param array<string, mixed> $config the configuration to load the tokenizer from
     *
     * @return self The loaded tokenizer
     */
    public static function fromConfig(array $config): self
    {
        $model = ModelFactory::create($config['model'] ?? []);

        $addedTokens = [];
        $specialTokens = [];

        foreach ($config['added_tokens'] ?? [] as $addedToken) {
            $token = AddedToken::fromArray($addedToken);
            $addedTokens[$token->content] = $token;

            $model->addToken($token->content, $token->id);

            if ($token->special) {
                $specialTokens[] = $token->content;
            }
        }

        $normalizer = isset($config['normalizer'])
            ? NormalizerFactory::create($config['normalizer'])
            : new PassThroughNormalizer();
        $preTokenizer = isset($config['pre_tokenizer'])
            ? PreTokenizerFactory::create($config['pre_tokenizer'])
            : new IdentityPreTokenizer();
        $postProcessor = isset($config['post_processor'])
            ? PostProcessorFactory::create($config['post_processor'])
            : new DefaultPostProcessor();
        $decoder = isset($config['decoder'])
            ? DecoderFactory::create($config['decoder'], $addedTokens, $model->getEndOfWordSuffix())
            : new FuseDecoder(' ');

        $additionalSpecialTokens = $config['additional_special_tokens'] ?? [];
        $specialTokens = array_unique([...$specialTokens, ...$additionalSpecialTokens]);

        unset(
            $config['model'],
            $config['normalizer'],
            $config['pre_tokenizer'],
            $config['post_processor'],
            $config['decoder'],
            $config['added_tokens'],
            $config['additional_special_tokens']
        );

        return new self(
            $model,
            $normalizer,
            $preTokenizer,
            $postProcessor,
            $decoder,
            $specialTokens,
            $addedTokens,
            $config
        );
    }

    /**
     * Get a builder for the tokenizer.
     *
     * @return TokenizerBuilder The builder for the tokenizer
     */
    public static function builder(): TokenizerBuilder
    {
        return new TokenizerBuilder();
    }

    /**
     * Encode a text into a list of tokens.
     *
     * @param string      $text             the text to encode
     * @param null|string $textPair         the text pair to encode
     * @param bool        $addSpecialTokens whether to add special tokens
     *
     * @return Encoding The encoded text
     */
    public function encode(string $text, ?string $textPair = null, bool $addSpecialTokens = true): Encoding
    {
        $tokens = $this->tokenize($text);
        $tokensPair = $this->tokenize($textPair);

        [$tokens, $typeIds] = $this->postProcessor->process($tokens, $tokensPair, $addSpecialTokens);

        $ids = $this->model->encode($tokens);

        return new Encoding(ids: $ids, tokens: $tokens, typeIds: $typeIds);
    }

    /**
     * Decode a list of tokens into a text.
     *
     * @param int[]     $ids               the IDs to decode
     * @param bool      $skipSpecialTokens whether to skip special tokens
     * @param null|bool $cleanup           whether to clean up tokenization spaces
     *
     * @return string The decoded text
     */
    public function decode(array $ids, bool $skipSpecialTokens = true, ?bool $cleanup = null): string
    {
        $tokens = $this->model->decode($ids);

        if ($skipSpecialTokens) {
            $tokens = array_filter($tokens, fn ($token) => !\in_array($token, $this->specialTokens));
        }

        $decoded = $this->decoder->decode($tokens);

        if ($cleanup ?? $this->getConfig('clean_up_tokenization_spaces', true)) {
            $decoded = DecoderUtils::cleanUpTokenization($decoded);
        }

        return $decoded;
    }

    /**
     * Converts a text into a list of tokens.
     *
     * Splits added tokens out first, then processes each section separately.
     *
     * @param null|string $text the text to tokenize
     *
     * @return null|string[] The resulting tokens
     */
    protected function tokenize(?string $text): ?array
    {
        if (null === $text) {
            return null;
        }

        $sections = $this->addedTokensSplitter->split($text);

        foreach ($sections as $i => $section) {
            $addedToken = $this->addedTokens[$section] ?? null;
            if ($addedToken) {
                if ($addedToken->lStrip && $i > 0) {
                    $sections[$i - 1] = rtrim($sections[$i - 1]);
                }
                if ($addedToken->rStrip && $i < \count($sections) - 1) {
                    $sections[$i + 1] = ltrim($sections[$i + 1]);
                }
            }
        }

        $tokens = [];
        foreach ($sections as $sectionIndex => $section) {
            if (0 === mb_strlen($section)) {
                continue;
            }

            if (isset($this->addedTokens[$section])) {
                $tokens[] = $section;

                continue;
            }

            $processedText = $section;

            if ($this->getConfig('remove_space', false)) {
                $processedText = NormalizerUtils::removeSpace($processedText);
            }

            if ($this->getConfig('do_lowercase_and_remove_accent', false)) {
                $processedText = NormalizerUtils::removeAccents($processedText);
                $processedText = mb_strtolower($processedText);
            }

            $processedText = $this->normalizer->normalize($processedText);

            if (0 === mb_strlen($processedText)) {
                continue;
            }

            $preTokens = $this->preTokenizer->preTokenize($processedText, ['section_index' => $sectionIndex]);

            $sectionTokens = $this->model->tokenize($preTokens);

            $tokens = array_merge($tokens, $sectionTokens);
        }

        return $tokens;
    }
}
