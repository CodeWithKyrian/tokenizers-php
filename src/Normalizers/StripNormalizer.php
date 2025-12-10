<?php

declare(strict_types=1);

namespace Codewithkyrian\Tokenizers\Normalizers;

use Codewithkyrian\Tokenizers\Contracts\NormalizerInterface;

class StripNormalizer implements NormalizerInterface
{
    public function __construct(
        protected bool $stripLeft = true,
        protected bool $stripRight = true
    ) {}

    public function normalize(string $text): string
    {
        if ($this->stripLeft && $this->stripRight) {
            return trim($text);
        }
        if ($this->stripLeft) {
            $text = ltrim($text);
        }
        if ($this->stripRight) {
            $text = rtrim($text);
        }

        return $text;
    }
}
