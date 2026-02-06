<?php

declare(strict_types=1);

namespace Codewithkyrian\Tokenizers\Factories;

use Codewithkyrian\Tokenizers\Contracts\PreTokenizerInterface;
use Codewithkyrian\Tokenizers\PreTokenizers\BertPreTokenizer;
use Codewithkyrian\Tokenizers\PreTokenizers\ByteLevelPreTokenizer;
use Codewithkyrian\Tokenizers\PreTokenizers\DigitsPreTokenizer;
use Codewithkyrian\Tokenizers\PreTokenizers\FixedLengthPreTokenizer;
use Codewithkyrian\Tokenizers\PreTokenizers\MetaspacePreTokenizer;
use Codewithkyrian\Tokenizers\PreTokenizers\PreTokenizerSequence;
use Codewithkyrian\Tokenizers\PreTokenizers\PunctuationPreTokenizer;
use Codewithkyrian\Tokenizers\PreTokenizers\ReplacePreTokenizer;
use Codewithkyrian\Tokenizers\PreTokenizers\SplitPreTokenizer;
use Codewithkyrian\Tokenizers\PreTokenizers\WhitespacePreTokenizer;
use Codewithkyrian\Tokenizers\PreTokenizers\WhitespaceSplit;

class PreTokenizerFactory
{
    /**
     * @param array<string, mixed> $config the pre-tokenizer configuration
     */
    public static function create(array $config): PreTokenizerInterface
    {
        $type = $config['type'] ?? null;

        return match ($type) {
            'BertPreTokenizer' => new BertPreTokenizer(),
            'Whitespace' => new WhitespacePreTokenizer(),
            'WhitespaceSplit' => new WhitespaceSplit(),
            'ByteLevel' => new ByteLevelPreTokenizer(
                addPrefixSpace: $config['add_prefix_space'] ?? true,
                trimOffsets: $config['trim_offsets'] ?? true,
                useRegex: $config['use_regex'] ?? true
            ),
            'Digits' => new DigitsPreTokenizer(
                individualDigits: $config['individual_digits'] ?? false
            ),
            'FixedLength' => new FixedLengthPreTokenizer(
                length: $config['length']
            ),
            'Metaspace' => new MetaspacePreTokenizer(
                replacement: $config['replacement'] ?? ' ',
                addPrefixSpace: $config['add_prefix_space'] ?? true,
                strRep: $config['str_rep'] ?? null,
                prependScheme: $config['prepend_scheme'] ?? 'always'
            ),
            'Punctuation' => new PunctuationPreTokenizer(
                behavior: $config['behavior'] ?? 'isolated'
            ),
            'Replace' => new ReplacePreTokenizer(
                pattern: $config['pattern']['String'] ?? $config['pattern'] ?? null,
                content: $config['content'] ?? ''
            ),
            'Split' => new SplitPreTokenizer(
                pattern: $config['pattern'],
                invert: $config['invert'] ?? true
            ),
            'Sequence' => new PreTokenizerSequence(
                array_map(static fn ($c) => self::create($c), $config['pretokenizers'] ?? [])
            ),
            default => throw new \Exception("Unknown pre-tokenizer type: {$type}"),
        };
    }
}
