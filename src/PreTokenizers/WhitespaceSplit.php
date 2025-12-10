<?php

declare(strict_types=1);

namespace Codewithkyrian\Tokenizers\PreTokenizers;

use Codewithkyrian\Tokenizers\Contracts\PreTokenizerInterface;

class WhitespaceSplit implements PreTokenizerInterface
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

        return preg_split('/[\s\x{FFFD}]+/u', $text, flags: \PREG_SPLIT_NO_EMPTY);
    }
}
