<?php

declare(strict_types=1);

namespace Codewithkyrian\Tokenizers\Normalizers;

use Codewithkyrian\Tokenizers\Contracts\NormalizerInterface;

class PrependNormalizer implements NormalizerInterface
{
    public function __construct(protected string $prepend) {}

    public function normalize(string $text): string
    {
        return $this->prepend.$text;
    }
}
