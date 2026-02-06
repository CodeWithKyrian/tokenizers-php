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

    public function getConfig(?string $key = null, mixed $default = null): mixed
    {
        if (null !== $key) {
            return match ($key) {
                'type' => 'Replace',
                'pattern' => $this->regex ? ['Regex' => $this->regex] : ['String' => $this->subString],
                'content' => $this->replacement,
                default => $default,
            };
        }

        return [
            'type' => 'Replace',
            'pattern' => $this->regex ? ['Regex' => $this->regex] : ['String' => $this->subString],
            'content' => $this->replacement,
        ];
    }

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
