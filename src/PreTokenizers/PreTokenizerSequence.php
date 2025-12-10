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
            fn ($text, PreTokenizerInterface $preTokenizer) => $preTokenizer->preTokenize($text, $options),
            \is_array($text) ? $text : [$text]
        );
    }
}
