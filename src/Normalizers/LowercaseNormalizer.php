<?php

declare(strict_types=1);

namespace Codewithkyrian\Tokenizers\Normalizers;

use Codewithkyrian\Tokenizers\Contracts\NormalizerInterface;

class LowercaseNormalizer implements NormalizerInterface
{
    public function normalize(string $text): string
    {
        return mb_strtolower($text);
    }

    public function getConfig(?string $key = null, mixed $default = null): mixed
    {
        if (null !== $key) {
            return 'type' === $key ? 'Lowercase' : $default;
        }

        return ['type' => 'Lowercase'];
    }
}
