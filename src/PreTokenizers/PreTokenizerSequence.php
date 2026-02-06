<?php

declare(strict_types=1);

namespace Codewithkyrian\Tokenizers\PreTokenizers;

use Codewithkyrian\Tokenizers\Contracts\PreTokenizerInterface;

class PreTokenizerSequence implements PreTokenizerInterface
{
    /**
     * @param PreTokenizerInterface[] $preTokenizers
     */
    public function __construct(protected array $preTokenizers) {}

    public function preTokenize(array|string $text, array $options = []): array
    {
        return array_reduce(
            $this->preTokenizers,
            static fn ($text, PreTokenizerInterface $preTokenizer) => $preTokenizer->preTokenize($text, $options),
            \is_array($text) ? $text : [$text]
        );
    }

    public function getConfig(?string $key = null, mixed $default = null): mixed
    {
        if (null !== $key) {
            if ('pretokenizers' === $key) {
                return array_map(static fn (PreTokenizerInterface $pt) => $pt->getConfig(), $this->preTokenizers);
            }

            return 'type' === $key ? 'Sequence' : $default;
        }

        return [
            'type' => 'Sequence',
            'pretokenizers' => array_map(static fn (PreTokenizerInterface $pt) => $pt->getConfig(), $this->preTokenizers),
        ];
    }
}
