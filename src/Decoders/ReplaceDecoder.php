<?php

declare(strict_types=1);

namespace Codewithkyrian\Tokenizers\Decoders;

class ReplaceDecoder extends BaseDecoder
{
    public function __construct(
        protected ?string $regex,
        protected ?string $subString,
        protected string $replacement = ''
    ) {}

    protected function processTokens(array $tokens): array
    {
        return array_map(function ($token) {
            if (null !== $this->regex) {
                return preg_replace("/{$this->regex}/u", $this->replacement, (string) $token);
            }
            if (null !== $this->subString) {
                return str_replace($this->subString, $this->replacement, (string) $token);
            }

            return $token;
        }, $tokens);
    }
}
