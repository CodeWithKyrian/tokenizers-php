<?php

declare(strict_types=1);

namespace Codewithkyrian\Tokenizers\Models;

use Codewithkyrian\Tokenizers\Contracts\ModelInterface;

/**
 * A minimal vocabulary-mapping model with no subword algorithm.
 *
 * Used for tokenizers where tokens map 1:1 to characters or bytes
 * without BPE, WordPiece, or Unigram segmentation — typically CTC
 * models such as Wav2Vec2.
 *
 * `tokenize()` is an identity transform; `encode()` and `decode()`
 * are simple dictionary lookups.
 */
class FallbackModel implements ModelInterface
{
    /**
     * Maps token strings to integer IDs.
     *
     * @var array<string, int>
     */
    protected array $tokenToId = [];

    /**
     * Maps integer IDs back to token strings.
     *
     * @var array<int, string>
     */
    protected array $idToToken = [];

    /**
     * The unknown-token string, used as a fallback when a token
     * or ID cannot be found in the vocabulary.
     */
    protected ?string $unkToken;

    /**
     * @param array<string, int> $vocab    Token → ID mapping (e.g. `['e' => 5, …]`)
     * @param null|string        $unkToken Fallback string for unknown tokens / IDs
     */
    public function __construct(array $vocab = [], ?string $unkToken = null)
    {
        $this->tokenToId = $vocab;
        $this->idToToken = array_flip($this->tokenToId);
        $this->unkToken = $unkToken;
    }

    /**
     * Identity transform — returns tokens unchanged.
     *
     * @param string[] $messages Input token strings
     *
     * @return string[] Same token strings, unchanged
     */
    public function tokenize(array $messages): array
    {
        return $messages;
    }

    /**
     * Convert token strings to their integer IDs.
     *
     * Unknown tokens resolve to the unk-token's ID if available,
     * otherwise to 0.
     *
     * @param string[] $tokens Token strings to encode
     *
     * @return int[] Integer token IDs
     */
    public function encode(array $tokens): array
    {
        return array_map(
            fn (string $token): int => $this->tokenToId[$token]
                    ?? $this->tokenToId[$this->unkToken]
                    ?? 0,
            $tokens,
        );
    }

    /**
     * Convert integer IDs back to their token strings.
     *
     * Unknown IDs resolve to the unk-token string if available,
     * otherwise to an empty string.
     *
     * @param int[] $ids Integer token IDs to decode
     *
     * @return string[] Token strings
     */
    public function decode(array $ids): array
    {
        return array_map(
            fn (int $id): string => $this->idToToken[$id]
                    ?? $this->unkToken
                    ?? '',
            $ids,
        );
    }

    /**
     * Return the full token → ID vocabulary.
     *
     * @return array<int, string>
     */
    public function getVocab(): array
    {
        return $this->idToToken;
    }

    /**
     * Return the number of tokens in the vocabulary.
     */
    public function getVocabSize(): int
    {
        return \count($this->idToToken);
    }

    /**
     * Add a token or override an existing one.
     *
     * @param string $token The token string
     * @param int    $id    The integer ID to assign
     */
    public function addToken(string $token, int $id): void
    {
        $this->tokenToId[$token] = $id;
        $this->idToToken[$id] = $token;
    }

    /**
     * Return configuration, a single config key, or a default value.
     *
     * @return ($key is null ? array<string, mixed> : mixed)
     */
    public function getConfig(?string $key = null, mixed $default = null): mixed
    {
        if (null !== $key) {
            return match ($key) {
                'vocab' => $this->tokenToId,
                'unk_token' => $this->unkToken,
                default => $default,
            };
        }

        return [
            'vocab' => $this->tokenToId,
            'unk_token' => $this->unkToken,
        ];
    }
}
