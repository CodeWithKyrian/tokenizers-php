<?php

declare(strict_types=1);

namespace Codewithkyrian\Tokenizers\Decoders;

class DecoderSequence extends BaseDecoder
{
    /**
     * @param BaseDecoder[] $decoders
     */
    public function __construct(protected array $decoders) {}

    protected function processTokens(array $tokens): array
    {
        return array_reduce(
            $this->decoders,
            static fn (array $tokens, BaseDecoder $decoder) => $decoder->processTokens($tokens),
            $tokens
        );
    }
}
