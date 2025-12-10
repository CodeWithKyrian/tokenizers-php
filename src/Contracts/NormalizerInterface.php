<?php

declare(strict_types=1);

namespace Codewithkyrian\Tokenizers\Contracts;

interface NormalizerInterface
{
    public function normalize(string $text): string;
}
