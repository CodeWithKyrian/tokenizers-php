<?php

declare(strict_types=1);

namespace Codewithkyrian\Tokenizers\Models;

use Codewithkyrian\Tokenizers\Contracts\ModelInterface;

class FallbackModel implements ModelInterface
{
    /**
     * @var array<int, string>
     */
    protected array $vocab = [];

    /**
     * @var array<string, int>
     */
    protected array $vocabReversed = [];
    protected ?string $unkToken;

    /**
     * @param array<int, string> $vocab    the vocabulary
     * @param null|string        $unkToken the unknown token
     */
    public function __construct(
        array $vocab = [],
        ?string $unkToken = null
    ) {
        $this->unkToken = $unkToken;

        // Populate vocab
        foreach ($vocab as $token => $id) {
            $this->vocab[$token] = $id;
            $this->vocabReversed[$id] = $token;
        }
    }

    /**
     * @param string[] $messages the messages to tokenize
     *
     * @return string[]
     */
    public function tokenize(array $messages): array
    {
        return $messages;
    }

    /**
     * @param string[] $tokens the tokens to encode
     *
     * @return int[]
     */
    public function encode(array $tokens): array
    {
        return array_map(function ($token) {
            return $this->vocabReversed[$token] ?? $this->vocabReversed[$this->unkToken] ?? 0;
        }, $tokens);
    }

    /**
     * @param int[] $ids the IDs to decode
     *
     * @return string[]
     */
    public function decode(array $ids): array
    {
        return array_map(fn ($id) => $this->vocab[$id] ?? $this->unkToken ?? '', $ids);
    }

    /**
     * @return array<int, string>
     */
    public function getVocab(): array
    {
        return $this->vocab;
    }

    public function getVocabSize(): int
    {
        return \count($this->vocab);
    }

    /**
     * @param string $token the token to add
     * @param int    $id    the ID of the token
     */
    public function addToken(string $token, int $id): void
    {
        $this->vocab[$id] = $token;
        $this->vocabReversed[$token] = $id;
    }

    public function getConfig(?string $key = null, mixed $default = null): mixed
    {
        if (null !== $key) {
            return match ($key) {
                'vocab' => $this->vocab,
                'unk_token' => $this->unkToken,
                default => $default,
            };
        }

        // 2. Full Config Reconstruction
        return [
            'vocab' => $this->vocab,
            'unk_token' => $this->unkToken,
        ];
    }
}
