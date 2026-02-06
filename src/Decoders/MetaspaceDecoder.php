<?php

declare(strict_types=1);

namespace Codewithkyrian\Tokenizers\Decoders;

class MetaspaceDecoder extends BaseDecoder
{
    public function __construct(
        protected string $replacement = ' ',
        protected bool $addPrefixSpace = true
    ) {}

    public function getConfig(?string $key = null, mixed $default = null): mixed
    {
        if (null !== $key) {
            return match ($key) {
                'type' => 'Metaspace',
                'replacement' => $this->replacement,
                'add_prefix_space' => $this->addPrefixSpace,
                default => $default,
            };
        }

        return [
            'type' => 'Metaspace',
            'replacement' => $this->replacement,
            'add_prefix_space' => $this->addPrefixSpace,
        ];
    }

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
