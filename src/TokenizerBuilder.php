<?php

declare(strict_types=1);

namespace Codewithkyrian\Tokenizers;

use Codewithkyrian\Tokenizers\Contracts\DecoderInterface;
use Codewithkyrian\Tokenizers\Contracts\ModelInterface;
use Codewithkyrian\Tokenizers\Contracts\NormalizerInterface;
use Codewithkyrian\Tokenizers\Contracts\PostProcessorInterface;
use Codewithkyrian\Tokenizers\Contracts\PreTokenizerInterface;
use Codewithkyrian\Tokenizers\DataStructures\AddedToken;
use Codewithkyrian\Tokenizers\Decoders\FuseDecoder;
use Codewithkyrian\Tokenizers\Normalizers\PassThroughNormalizer;
use Codewithkyrian\Tokenizers\PostProcessors\DefaultPostProcessor;
use Codewithkyrian\Tokenizers\PreTokenizers\IdentityPreTokenizer;

class TokenizerBuilder
{
    private ?ModelInterface $model = null;
    private ?NormalizerInterface $normalizer = null;
    private ?PreTokenizerInterface $preTokenizer = null;
    private ?PostProcessorInterface $postProcessor = null;
    private ?DecoderInterface $decoder = null;

    /**
     * @var array<string, AddedToken>
     */
    private array $addedTokens = [];

    /**
     * @var string[]
     */
    private array $specialTokens = [];

    /**
     * @var array<string, mixed>
     */
    private array $config = [];

    public function withModel(ModelInterface $model): self
    {
        $this->model = $model;

        return $this;
    }

    public function withNormalizer(NormalizerInterface $normalizer): self
    {
        $this->normalizer = $normalizer;

        return $this;
    }

    public function withPreTokenizer(PreTokenizerInterface $preTokenizer): self
    {
        $this->preTokenizer = $preTokenizer;

        return $this;
    }

    public function withPostProcessor(PostProcessorInterface $postProcessor): self
    {
        $this->postProcessor = $postProcessor;

        return $this;
    }

    public function withDecoder(DecoderInterface $decoder): self
    {
        $this->decoder = $decoder;

        return $this;
    }

    /**
     * @param AddedToken[]|array<string, AddedToken> $addedTokens the added tokens (keyed by content, or indexed array)
     */
    public function withAddedTokens(array $addedTokens): self
    {
        foreach ($addedTokens as $key => $token) {
            $this->addedTokens[\is_int($key) ? $token->content : $key] = $token;
        }

        return $this;
    }

    /**
     * @param string[] $specialTokens the special tokens to add to the tokenizer
     */
    public function withSpecialTokens(array $specialTokens): self
    {
        $this->specialTokens = $specialTokens;

        return $this;
    }

    /**
     * Set a configuration value.
     *
     * Common config keys:
     * - 'model_max_length' (int|null): Maximum sequence length
     * - 'remove_space' (bool): Remove leading/trailing spaces before normalization
     * - 'do_lowercase_and_remove_accent' (bool): Lowercase and strip accents
     * - 'clean_up_tokenization_spaces' (bool): Clean up spaces during decoding
     *
     * @param string $key   the configuration key
     * @param mixed  $value the configuration value
     */
    public function withConfig(string $key, mixed $value): self
    {
        $this->config[$key] = $value;

        return $this;
    }

    public function build(): Tokenizer
    {
        if (null === $this->model) {
            throw new \Exception('A model is required to build a Tokenizer.');
        }

        return new Tokenizer(
            $this->model,
            $this->normalizer ?? new PassThroughNormalizer(),
            $this->preTokenizer ?? new IdentityPreTokenizer(),
            $this->postProcessor ?? new DefaultPostProcessor(),
            $this->decoder ?? new FuseDecoder(' '),
            $this->specialTokens,
            $this->addedTokens,
            $this->config
        );
    }
}
