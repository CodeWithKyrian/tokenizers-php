<?php

declare(strict_types=1);

namespace Codewithkyrian\Tokenizers\Normalizers;

use Codewithkyrian\Tokenizers\Contracts\NormalizerInterface;
use Codewithkyrian\Tokenizers\DataStructures\DoubleArray;

class PrecompiledNormalizer implements NormalizerInterface
{
    private string $normalized;
    private DoubleArray $trie;

    public function __construct(private string $precompiledCharsmap)
    {
        $this->parse(base64_decode($precompiledCharsmap));
    }

    public function normalize(string $text): string
    {
        $transformations = [];
        $modified = false;
        $graphemes = mb_str_split($text);

        foreach ($graphemes as $grapheme) {
            if (mb_strlen($grapheme) < 6) {
                $norm = $this->transform($grapheme);
                if (null !== $norm) {
                    $modified = true;
                    $this->replace($transformations, $grapheme, $norm);

                    continue;
                }
            }
            $chars = mb_str_split($grapheme);
            foreach ($chars as $char) {
                $norm = $this->transform($char);
                if (null !== $norm) {
                    $modified = true;
                    $this->replace($transformations, $char, $norm);
                } else {
                    $transformations[] = [$char, 0];
                }
            }
        }

        if ($modified) {
            $text = $this->applyTransformations($text, $transformations);
        }

        // Remove control characters
        $text = preg_replace('/[\x{0001}-\x{0008}\x{000B}\x{000E}-\x{001F}\x{007F}\x{008F}\x{009F}]/u', '', $text);

        // Replace certain characters with a space
        $text = preg_replace('/[\x{0009}\x{000A}\x{000C}\x{000D}\x{1680}\x{200B}\x{200C}\x{200E}\x{200F}\x{2028}\x{2029}\x{2581}\x{FEFF}\x{FFFD}]/u', ' ', $text);

        // Special case handling for Fullwidth Tilde character
        if (false !== mb_strpos($text, "\u{FF5E}")) {
            $parts = explode("\u{FF5E}", $text);
            $normalizedParts = array_map(fn ($part) => $this->normalizeNFKC($part), $parts);
            $text = implode("\u{FF5E}", $normalizedParts);
        } else {
            $text = $this->normalizeNFKC($text);
        }

        return $text;
    }

    public function getConfig(?string $key = null, mixed $default = null): mixed
    {
        if (null !== $key) {
            return match ($key) {
                'type' => 'Precompiled',
                'precompiled_charsmap' => $this->precompiledCharsmap,
                default => $default,
            };
        }

        return [
            'type' => 'Precompiled',
            'precompiled_charsmap' => $this->precompiledCharsmap,
        ];
    }

    private function parse(string $precompiled_charsmap): void
    {
        $trie_size = unpack('V', substr($precompiled_charsmap, 0, 4))[1];
        $trie_char_size = $trie_size / 4;
        $trie_blob = [];
        $offset = 4;
        for ($i = 0; $i < $trie_char_size; ++$i) {
            $trie_blob[] = unpack('V', substr($precompiled_charsmap, $offset, 4))[1];
            $offset += 4;
        }
        $this->normalized = substr($precompiled_charsmap, $offset);
        $this->trie = new DoubleArray($trie_blob);
    }

    private function normalizeNFKC(string $text): string
    {
        // Perform NFKC normalization using PHP's intl extension
        if (class_exists('Normalizer')) {
            return \Normalizer::normalize($text, \Normalizer::FORM_KC);
        }

        return $text; // Fallback if intl extension is not available
    }

    private function transform(string $chunk): ?string
    {
        $results = $this->trie->commonPrefixSearch($chunk);
        if (empty($results)) {
            return null;
        }
        $index = $results[0];
        $index2 = $index;
        while ($index2 < mb_strlen($this->normalized)) {
            if (0 === \ord($this->normalized[$index2])) {
                break;
            }
            ++$index2;
        }

        return mb_substr($this->normalized, $index, $index2 - $index);
    }

    /**
     * @param array<array{0?: string, 1: int}> $transformations the transformations to apply
     * @param string                           $old_part        the old part to replace
     * @param string                           $new_part        the new part to replace with
     */
    private function replace(array &$transformations, string $old_part, string $new_part): void
    {
        $old_count = mb_strlen($old_part);
        $new_count = mb_strlen($new_part);
        $diff = $new_count - $old_count;

        foreach (mb_str_split($new_part) as $char) {
            $transformations[] = [$char, 0];
        }

        if ($diff > 0) {
            for ($i = 0; $i < $diff; ++$i) {
                $transformations[\count($transformations) - 1 - $i][1] = 1;
            }
        } elseif ($diff < 0) {
            $transformations[\count($transformations) - 1][1] += $diff;
        }
    }

    /**
     * @param string                          $original        the original text
     * @param array<array{0: string, 1: int}> $transformations the transformations to apply
     *
     * @return string the transformed text
     */
    private function applyTransformations(string $original, array $transformations): string
    {
        $result = '';
        $offset = 0;
        foreach ($transformations as [$char, $change]) {
            $result .= $char;
            $offset += $change;
        }

        return $result;
    }
}
