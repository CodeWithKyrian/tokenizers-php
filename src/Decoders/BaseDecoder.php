<?php

declare(strict_types=1);

namespace Codewithkyrian\Tokenizers\Decoders;

use Codewithkyrian\Tokenizers\Contracts\DecoderInterface;

abstract class BaseDecoder implements DecoderInterface
{
    public function decode(array $tokens): string
    {
        $tokens = $this->processTokens($tokens);

        return implode('', $tokens);
    }

    /**
     * Processes tokens through the decoder's transformation logic.
     *
     * @param string[] $tokens the tokens to process
     *
     * @return string[] the processed tokens
     */
    abstract protected function processTokens(array $tokens): array;
}
