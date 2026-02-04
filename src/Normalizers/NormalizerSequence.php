<?php

declare(strict_types=1);

namespace Codewithkyrian\Tokenizers\Normalizers;

use Codewithkyrian\Tokenizers\Contracts\NormalizerInterface;

class NormalizerSequence implements NormalizerInterface
{
    /**
     * @param NormalizerInterface[] $normalizers
     */
    public function __construct(protected array $normalizers) {}

    public function normalize(string $text): string
    {
        return array_reduce(
            $this->normalizers,
            static fn (string $text, NormalizerInterface $normalizer) => $normalizer->normalize($text),
            $text
        );
    }
}
