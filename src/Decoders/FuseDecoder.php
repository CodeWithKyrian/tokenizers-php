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

    protected function processTokens(array $tokens): array
    {
        return [implode($this->separator, $tokens)];
    }
}
