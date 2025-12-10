<?php

declare(strict_types=1);

namespace Codewithkyrian\Tokenizers\Utils;

class RegexUtils
{
    /**
     * Helper method to construct a pattern from a config object.
     *
     * @param array<string, string>|string $pattern the pattern object
     * @param bool                         $invert  whether to invert the pattern
     *
     * @return null|string the compiled pattern or null if invalid
     */
    public static function createPattern(array|string $pattern, bool $invert = true): ?string
    {
        if (\is_string($pattern)) {
            return preg_quote($pattern, '/');
        }

        if (isset($pattern['Regex'])) {
            // Remove unnecessary escape sequences
            return str_replace(['\#', '\&', '\~'], ['#', '&', '~'], $pattern['Regex']);
        }
        if (isset($pattern['String'])) {
            $escaped = preg_quote($pattern['String'], '/');

            return $invert ? $escaped : "({$escaped})";
        }

        return null;
    }
}
