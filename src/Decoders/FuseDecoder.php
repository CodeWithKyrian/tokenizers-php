<?php

declare(strict_types=1);

namespace Codewithkyrian\Tokenizers\Decoders;

/**
 * A decoder that fuses tokens together with an optional separator.
 * Defaults to empty string (no separator) for backward compatibility.
 */
class FuseDecoder extends BaseDecoder
{
    public function __construct(
        protected string $separator = ''
    ) {}

    public function getConfig(?string $key = null, mixed $default = null): mixed
    {
        if (null !== $key) {
            return match ($key) {
                'type' => 'Fuse',
                'separator' => $this->separator,
                default => $default,
            };
        }

        return [
            'type' => 'Fuse',
            'separator' => $this->separator,
        ];
    }

    protected function processTokens(array $tokens): array
    {
        return [implode($this->separator, $tokens)];
    }
}
