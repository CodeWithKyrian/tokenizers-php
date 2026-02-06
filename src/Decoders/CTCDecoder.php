<?php

declare(strict_types=1);

namespace Codewithkyrian\Tokenizers\Decoders;

use Codewithkyrian\Tokenizers\Utils\DecoderUtils;

class CTCDecoder extends BaseDecoder
{
    public function __construct(
        protected string $padToken = '<pad>',
        protected string $wordDelimiterToken = '|',
        protected bool $cleanup = true
    ) {}

    public function getConfig(?string $key = null, mixed $default = null): mixed
    {
        if (null !== $key) {
            return match ($key) {
                'type' => 'CTC',
                'pad_token' => $this->padToken,
                'word_delimiter_token' => $this->wordDelimiterToken,
                'cleanup' => $this->cleanup,
                default => $default,
            };
        }

        return [
            'type' => 'CTC',
            'pad_token' => $this->padToken,
            'word_delimiter_token' => $this->wordDelimiterToken,
            'cleanup' => $this->cleanup,
        ];
    }

    protected function processTokens(array $tokens): array
    {
        if (empty($tokens)) {
            return [];
        }

        $groupedTokens = [$tokens[0]];
        $count = \count($tokens);
        for ($i = 1; $i < $count; ++$i) {
            if ($tokens[$i] !== end($groupedTokens)) {
                $groupedTokens[] = $tokens[$i];
            }
        }

        $filteredTokens = array_filter($groupedTokens, fn ($token) => $token !== $this->padToken);

        $text = implode('', $filteredTokens);

        if ($this->cleanup) {
            $text = DecoderUtils::cleanUpTokenization($text);
            $text = str_replace($this->wordDelimiterToken, ' ', $text);
            $text = trim($text);
        }

        return [$text];
    }
}
