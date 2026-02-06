<?php

declare(strict_types=1);

namespace Codewithkyrian\Tokenizers\Normalizers;

use Codewithkyrian\Tokenizers\Contracts\NormalizerInterface;

/**
 * StripAccents normalizer removes all accents from the text.
 */
class StripAccentsNormalizer implements NormalizerInterface
{
    /**
     * Removes accents from the text.
     *
     * @param string $text the text to remove accents from
     *
     * @return string the text with accents removed
     */
    public function normalize(string $text): string
    {
        return preg_replace('/[\x{0300}-\x{036f}]/u', '', $text);
    }

    public function getConfig(?string $key = null, mixed $default = null): mixed
    {
        if (null !== $key) {
            return 'type' === $key ? 'StripAccents' : $default;
        }

        return ['type' => 'StripAccents'];
    }
}
