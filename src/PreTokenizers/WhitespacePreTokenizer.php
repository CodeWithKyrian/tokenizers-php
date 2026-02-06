<?php

declare(strict_types=1);

namespace Codewithkyrian\Tokenizers\PreTokenizers;

use Codewithkyrian\Tokenizers\Contracts\PreTokenizerInterface;

class WhitespacePreTokenizer implements PreTokenizerInterface
{
    public function preTokenize(array|string $text, array $options = []): array
    {
        if (\is_array($text)) {
            $result = [];
            foreach ($text as $t) {
                $result = array_merge($result, $this->preTokenize($t, $options));
            }

            return $result;
        }

        return preg_split('/\s+/u', $text, -1, \PREG_SPLIT_NO_EMPTY);
    }

    public function getConfig(?string $key = null, mixed $default = null): mixed
    {
        if (null === $key) {
            return ['type' => 'Whitespace'];
        }

        return 'type' === $key ? 'Whitespace' : $default;
    }
}
