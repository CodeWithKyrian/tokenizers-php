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

    public function getConfig(?string $key = null, mixed $default = null): mixed
    {
        if (null !== $key) {
            if ('normalizers' === $key) {
                return array_map(static fn (NormalizerInterface $n) => $n->getConfig(), $this->normalizers);
            }

            return 'type' === $key ? 'Sequence' : $default;
        }

        return [
            'type' => 'Sequence',
            'normalizers' => array_map(static fn (NormalizerInterface $n) => $n->getConfig(), $this->normalizers),
        ];
    }
}
