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

    public function getConfig(?string $key = null, mixed $default = null): mixed
    {
        if (null !== $key) {
            return match ($key) {
                'type' => 'Prepend',
                'prepend' => $this->prepend,
                default => $default,
            };
        }

        return [
            'type' => 'Prepend',
            'prepend' => $this->prepend,
        ];
    }
}
