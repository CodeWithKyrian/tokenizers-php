<?php

declare(strict_types=1);

namespace Codewithkyrian\Tokenizers\Factories;

use Codewithkyrian\Tokenizers\Contracts\ModelInterface;
use Codewithkyrian\Tokenizers\Models\BPEModel;
use Codewithkyrian\Tokenizers\Models\FallbackModel;
use Codewithkyrian\Tokenizers\Models\UnigramModel;
use Codewithkyrian\Tokenizers\Models\WordPieceModel;

class ModelFactory
{
    /**
     * @param array<string, mixed> $config the model configuration
     */
    public static function create(array $config): ModelInterface
    {
        $type = $config['type'] ?? null;

        if (null === $type) {
            if (isset($config['merges'])) {
                $type = 'BPE';
            } elseif (isset($config['vocab']) && \is_array($config['vocab'][0] ?? null)) {
                $type = 'Unigram';
            }
        }

        return match ($type) {
            'BPE' => new BPEModel(
                vocab: $config['vocab'],
                merges: $config['merges'] ?? [],
                unkToken: $config['unk_token'] ?? null,
                endOfWordSuffix: $config['end_of_word_suffix'] ?? null,
                continuingSubwordSuffix: $config['continuing_subword_suffix'] ?? null,
                byteFallback: $config['byte_fallback'] ?? false,
                ignoreMerges: $config['ignore_merges'] ?? false
            ),
            'WordPiece' => new WordPieceModel(
                vocab: $config['vocab'],
                unkToken: $config['unk_token'] ?? '[UNK]',
                maxInputCharsPerWord: $config['max_input_chars_per_word'] ?? 100,
                continuingSubwordPrefix: $config['continuing_subword_prefix'] ?? '##'
            ),
            'Unigram' => new UnigramModel(
                vocab: $config['vocab'],
                unkId: $config['unk_id'] ?? null,
                eosToken: $config['eos_token'] ?? '</s>'
            ),
            null => new FallbackModel(
                vocab: $config['vocab'] ?? [],
                unkToken: $config['unk_token'] ?? null
            ),
            default => throw new \Exception("Unknown model type: {$type}"),
        };
    }
}
