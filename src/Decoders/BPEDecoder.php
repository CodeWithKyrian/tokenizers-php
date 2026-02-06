<?php

declare(strict_types=1);

namespace Codewithkyrian\Tokenizers\Decoders;

class BPEDecoder extends BaseDecoder
{
    public function __construct(protected string $suffix = '') {}

    public function getConfig(?string $key = null, mixed $default = null): mixed
    {
        if (null !== $key) {
            return match ($key) {
                'type' => 'BPEDecoder',
                'suffix' => $this->suffix,
                default => $default,
            };
        }

        return [
            'type' => 'BPEDecoder',
            'suffix' => $this->suffix,
        ];
    }

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
