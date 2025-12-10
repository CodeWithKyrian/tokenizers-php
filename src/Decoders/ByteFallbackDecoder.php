<?php

declare(strict_types=1);

namespace Codewithkyrian\Tokenizers\Decoders;

class ByteFallbackDecoder extends BaseDecoder
{
    protected function processTokens(array $tokens): array
    {
        $newTokens = [];
        $previousByteTokens = [];

        foreach ($tokens as $token) {
            $token = (string) $token;
            $bytes = null;

            if (6 === \strlen($token) && str_starts_with($token, '<0x') && str_ends_with($token, '>')) {
                $byte = hexdec(substr($token, 3, 2));
                if (!is_nan($byte)) {
                    $bytes = $byte;
                }
            }

            if (null !== $bytes) {
                $previousByteTokens[] = $bytes;
            } else {
                if (!empty($previousByteTokens)) {
                    $newTokens[] = pack('C*', ...$previousByteTokens);
                    $previousByteTokens = [];
                }
                $newTokens[] = $token;
            }
        }

        if (!empty($previousByteTokens)) {
            $newTokens[] = pack('C*', ...$previousByteTokens);
        }

        return $newTokens;
    }
}
