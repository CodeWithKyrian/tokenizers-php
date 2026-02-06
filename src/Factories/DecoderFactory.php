<?php

declare(strict_types=1);

namespace Codewithkyrian\Tokenizers\Factories;

use Codewithkyrian\Tokenizers\Contracts\DecoderInterface;
use Codewithkyrian\Tokenizers\DataStructures\AddedToken;
use Codewithkyrian\Tokenizers\Decoders\BaseDecoder;
use Codewithkyrian\Tokenizers\Decoders\BPEDecoder;
use Codewithkyrian\Tokenizers\Decoders\ByteFallbackDecoder;
use Codewithkyrian\Tokenizers\Decoders\ByteLevelDecoder;
use Codewithkyrian\Tokenizers\Decoders\CTCDecoder;
use Codewithkyrian\Tokenizers\Decoders\DecoderSequence;
use Codewithkyrian\Tokenizers\Decoders\FuseDecoder;
use Codewithkyrian\Tokenizers\Decoders\MetaspaceDecoder;
use Codewithkyrian\Tokenizers\Decoders\ReplaceDecoder;
use Codewithkyrian\Tokenizers\Decoders\StripDecoder;
use Codewithkyrian\Tokenizers\Decoders\WordPieceDecoder;

class DecoderFactory
{
    /**
     * @param array<string, mixed>      $config          the decoder configuration
     * @param array<string, AddedToken> $addedTokens     Optional. Only needed for ByteLevelDecoder.
     * @param null|string               $endOfWordSuffix Optional. Only needed for ByteLevelDecoder.
     */
    public static function create(array $config, array $addedTokens = [], ?string $endOfWordSuffix = null): DecoderInterface
    {
        if (empty($config)) {
            return new FuseDecoder(' ');
        }

        $type = $config['type'] ?? null;

        return match ($type) {
            'WordPiece' => new WordPieceDecoder(
                prefix: $config['prefix'] ?? '##',
                cleanup: $config['cleanup'] ?? true
            ),
            'Metaspace' => new MetaspaceDecoder(
                replacement: $config['replacement'] ?? ' ',
                addPrefixSpace: $config['add_prefix_space'] ?? true
            ),
            'Replace' => new ReplaceDecoder(
                regex: $config['pattern']['Regex'] ?? null,
                subString: $config['pattern']['String'] ?? null,
                replacement: $config['content'] ?? ''
            ),
            'BPEDecoder' => new BPEDecoder(
                suffix: $config['suffix'] ?? ''
            ),
            'ByteLevel' => new ByteLevelDecoder($addedTokens, $endOfWordSuffix),
            'ByteFallback' => new ByteFallbackDecoder(),
            'CTC' => new CTCDecoder(
                padToken: $config['pad_token'] ?? '<pad>',
                wordDelimiterToken: $config['word_delimiter_token'] ?? '|',
                cleanup: $config['cleanup'] ?? true
            ),
            'Fuse' => new FuseDecoder(),
            'Strip' => new StripDecoder(
                content: $config['content'],
                start: $config['start'],
                stop: $config['stop']
            ),
            'Sequence' => self::createSequence($config['decoders'] ?? []),
            default => throw new \Exception("Unknown decoder type: {$type}"),
        };
    }

    /**
     * @param array<array<string, mixed>> $configs
     */
    private static function createSequence(array $configs): DecoderSequence
    {
        $decoders = [];

        foreach ($configs as $config) {
            $decoder = self::create($config);

            if ($decoder instanceof BaseDecoder) {
                $decoders[] = $decoder;
            }
        }

        return new DecoderSequence($decoders);
    }
}
