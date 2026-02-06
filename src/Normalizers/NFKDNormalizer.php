<?php

declare(strict_types=1);

namespace Codewithkyrian\Tokenizers\Normalizers;

use Codewithkyrian\Tokenizers\Contracts\NormalizerInterface;

class NFKDNormalizer implements NormalizerInterface
{
    public function normalize(string $text): string
    {
        return normalizer_normalize($text, \Normalizer::NFKD);
    }

    public function getConfig(?string $key = null, mixed $default = null): mixed
    {
        if (null !== $key) {
            return 'type' === $key ? 'NFKD' : $default;
        }

        return ['type' => 'NFKD'];
    }
}
