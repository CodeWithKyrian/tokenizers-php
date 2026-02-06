<?php

declare(strict_types=1);

namespace Codewithkyrian\Tokenizers\Decoders;

use Codewithkyrian\Tokenizers\Utils\DecoderUtils;

class WordPieceDecoder extends BaseDecoder
{
    public function __construct(
        protected string $prefix = '##',
        protected bool $cleanup = true
    ) {}

    public function getConfig(?string $key = null, mixed $default = null): mixed
    {
        if (null !== $key) {
            return match ($key) {
                'type' => 'WordPiece',
                'prefix' => $this->prefix,
                'cleanup' => $this->cleanup,
                default => $default,
            };
        }

        return [
            'type' => 'WordPiece',
            'prefix' => $this->prefix,
            'cleanup' => $this->cleanup,
        ];
    }

    protected function processTokens(array $tokens): array
    {
        $decodedTokens = [];
        foreach ($tokens as $i => $token) {
            if (0 !== $i) {
                $token = str_starts_with((string) $token, $this->prefix)
                    ? substr((string) $token, \strlen($this->prefix))
                    : " {$token}";
            }

            if ($this->cleanup) {
                $token = DecoderUtils::cleanUpTokenization($token);
            }

            $decodedTokens[] = $token;
        }

        return $decodedTokens;
    }
}
