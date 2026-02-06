<?php

declare(strict_types=1);

namespace Codewithkyrian\Tokenizers\Decoders;

class DecoderSequence extends BaseDecoder
{
    /**
     * @param BaseDecoder[] $decoders
     */
    public function __construct(protected array $decoders) {}

    public function getConfig(?string $key = null, mixed $default = null): mixed
    {
        if (null !== $key) {
            return match ($key) {
                'type' => 'Sequence',
                'decoders' => array_map(static fn (BaseDecoder $d) => $d->getConfig(), $this->decoders),
                default => $default,
            };
        }

        return [
            'type' => 'Sequence',
            'decoders' => array_map(static fn (BaseDecoder $d) => $d->getConfig(), $this->decoders),
        ];
    }

    protected function processTokens(array $tokens): array
    {
        return array_reduce(
            $this->decoders,
            static fn (array $tokens, BaseDecoder $decoder) => $decoder->processTokens($tokens),
            $tokens
        );
    }
}
