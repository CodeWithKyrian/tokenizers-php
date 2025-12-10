<?php

declare(strict_types=1);

namespace Codewithkyrian\Tokenizers\Utils;

class NormalizerUtils
{
    /**
     * Checks whether the given Unicode codepoint represents a CJK (Chinese, Japanese, or Korean) character.
     *
     * @param int $cp the Unicode codepoint to check
     *
     * @return bool true if the codepoint represents a CJK character, false otherwise
     */
    public static function isChineseChar(int $cp): bool
    {
        return
            ($cp >= 0x4E00 && $cp <= 0x9FFF)
            || ($cp >= 0x3400 && $cp <= 0x4DBF)
            || ($cp >= 0x20000 && $cp <= 0x2A6DF)
            || ($cp >= 0x2A700 && $cp <= 0x2B73F)
            || ($cp >= 0x2B740 && $cp <= 0x2B81F)
            || ($cp >= 0x2B820 && $cp <= 0x2CEAF)
            || ($cp >= 0xF900 && $cp <= 0xFAFF)
            || ($cp >= 0x2F800 && $cp <= 0x2FA1F);
    }

    /**
     * Checks whether the given character is a control character.
     *
     * @param string $char the character to check
     *
     * @return bool true if the character is a control character, false otherwise
     */
    public static function isControlChar(string $char): bool
    {
        return match ($char) {
            "\t", "\n", "\r" => false,
            default => 1 === preg_match('/^\p{Cc}|\p{Cf}|\p{Co}|\p{Cs}$/u', $char),
        };
    }

    /**
     * Removes accents (diacritical marks) from a string.
     *
     * @param string $text the text to remove accents from
     *
     * @return string the text with accents removed
     */
    public static function removeAccents(string $text): string
    {
        $normalized = normalizer_normalize($text, \Normalizer::NFD);

        return preg_replace('/\p{Mn}/u', '', $normalized);
    }

    /**
     * Removes excess spaces from text by trimming and collapsing multiple spaces into single spaces.
     *
     * @param string $text the text to process
     *
     * @return string the text with excess spaces removed
     */
    public static function removeSpace(string $text): string
    {
        return preg_replace('/\s+/', ' ', trim($text));
    }
}
