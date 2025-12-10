<?php

declare(strict_types=1);

namespace Codewithkyrian\Tokenizers\Normalizers;

use Codewithkyrian\Tokenizers\Contracts\NormalizerInterface;

class NFCNormalizer implements NormalizerInterface
{
    public function normalize(string $text): string
    {
        return normalizer_normalize($text, \Normalizer::NFC);
    }
}
