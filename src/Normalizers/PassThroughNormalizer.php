<?php

declare(strict_types=1);

namespace Codewithkyrian\Tokenizers\Normalizers;

use Codewithkyrian\Tokenizers\Contracts\NormalizerInterface;

/**
 * A pass-through normalizer that returns the text unchanged.
 * Used as a default when no normalizer is specified.
 */
class PassThroughNormalizer implements NormalizerInterface
{
    public function normalize(string $text): string
    {
        return $text;
    }

    public function getConfig(?string $key = null, mixed $default = null): mixed
    {
        return null === $key ? [] : $default;
    }
}
