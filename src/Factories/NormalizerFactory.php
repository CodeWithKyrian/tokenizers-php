<?php

declare(strict_types=1);

namespace Codewithkyrian\Tokenizers\Factories;

use Codewithkyrian\Tokenizers\Contracts\NormalizerInterface;
use Codewithkyrian\Tokenizers\Normalizers\BertNormalizer;
use Codewithkyrian\Tokenizers\Normalizers\LowercaseNormalizer;
use Codewithkyrian\Tokenizers\Normalizers\NFCNormalizer;
use Codewithkyrian\Tokenizers\Normalizers\NFKCNormalizer;
use Codewithkyrian\Tokenizers\Normalizers\NFKDNormalizer;
use Codewithkyrian\Tokenizers\Normalizers\NormalizerSequence;
use Codewithkyrian\Tokenizers\Normalizers\PassThroughNormalizer;
use Codewithkyrian\Tokenizers\Normalizers\PrecompiledNormalizer;
use Codewithkyrian\Tokenizers\Normalizers\PrependNormalizer;
use Codewithkyrian\Tokenizers\Normalizers\ReplaceNormalizer;
use Codewithkyrian\Tokenizers\Normalizers\StripAccentsNormalizer;
use Codewithkyrian\Tokenizers\Normalizers\StripNormalizer;

class NormalizerFactory
{
    /**
     * @param array<string, mixed> $config the normalizer configuration
     */
    public static function create(array $config): NormalizerInterface
    {
        if (empty($config)) {
            return new PassThroughNormalizer();
        }

        $type = $config['type'] ?? null;

        return match ($type) {
            'BertNormalizer' => new BertNormalizer(
                cleanText: $config['clean_text'] ?? true,
                handleChineseChars: $config['handle_chinese_chars'] ?? true,
                stripAccents: $config['strip_accents'] ?? null,
                lowercase: $config['lowercase'] ?? true,
            ),
            'Lowercase' => new LowercaseNormalizer(),
            'Sequence' => new NormalizerSequence(
                array_map(static fn ($c) => self::create($c), $config['normalizers'] ?? [])
            ),
            'Strip' => new StripNormalizer(
                stripLeft: $config['strip_left'] ?? true,
                stripRight: $config['strip_right'] ?? true
            ),
            'Prepend' => new PrependNormalizer(
                prepend: $config['prepend'] ?? ''
            ),
            'Replace' => new ReplaceNormalizer(
                regex: $config['pattern']['Regex'] ?? null,
                subString: $config['pattern']['String'] ?? null,
                replacement: $config['content'] ?? ''
            ),
            'NFC' => new NFCNormalizer(),
            'NFKC' => new NFKCNormalizer(),
            'NFKD' => new NFKDNormalizer(),
            'Precompiled' => new PrecompiledNormalizer(
                precompiledCharsmap: $config['precompiled_charsmap']
            ),
            'StripAccents' => new StripAccentsNormalizer(),
            default => throw new \Exception("Unknown normalizer type: {$type}"),
        };
    }
}
