<?php

declare(strict_types=1);

namespace Codewithkyrian\Tokenizers\Decoders;

class MetaspaceDecoder extends BaseDecoder
{
    public function __construct(
        protected string $replacement = ' ',
        protected bool $addPrefixSpace = true
    ) {}

    protected function processTokens(array $tokens): array
    {
        $result = [];

        foreach ($tokens as $i => $token) {
            $normalized = str_replace($this->replacement, ' ', $token);

            if ($this->addPrefixSpace && 0 == $i && str_starts_with($normalized, ' ')) {
                $normalized = substr($normalized, 1);
            }

            $result[] = $normalized;
        }

        return $result;
    }
}
