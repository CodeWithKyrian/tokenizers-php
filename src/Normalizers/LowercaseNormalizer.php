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
}
