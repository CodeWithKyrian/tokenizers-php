<?php

declare(strict_types=1);

namespace Codewithkyrian\Tokenizers\PreTokenizers;

use Codewithkyrian\Tokenizers\Contracts\PreTokenizerInterface;

class ReplacePreTokenizer implements PreTokenizerInterface
{
    public function __construct(
        protected ?string $pattern,
        protected string $content
    ) {}

    public function preTokenize(array|string $text, array $options = []): array
    {
        if (\is_array($text)) {
            $result = [];
            foreach ($text as $t) {
                $result = array_merge($result, $this->preTokenize($t, $options));
            }

            return $result;
        }

        if (null === $this->pattern) {
            return [$text];
        }

        return [str_replace($this->pattern, $this->content, $text)];
    }

    public function getConfig(?string $key = null, mixed $default = null): mixed
    {
        if (null !== $key) {
            return match ($key) {
                'type' => 'Replace',
                'pattern' => ['String' => $this->pattern],
                'content' => $this->content,
                default => $default,
            };
        }

        return [
            'type' => 'Replace',
            'pattern' => ['String' => $this->pattern],
            'content' => $this->content,
        ];
    }
}
