<?php

declare(strict_types=1);

namespace Codewithkyrian\Tokenizers\Decoders;

class BPEDecoder extends BaseDecoder
{
    public function __construct(protected string $suffix = '') {}

    protected function processTokens(array $tokens): array
    {
        $decoded = [];
        $count = \count($tokens);

        foreach ($tokens as $i => $token) {
            $replacement = ($i === $count - 1) ? '' : ' ';
            $decoded[] = str_replace($this->suffix, $replacement, (string) $token);
        }

        return $decoded;
    }
}
