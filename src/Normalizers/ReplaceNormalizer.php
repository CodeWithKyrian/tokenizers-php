<?php

declare(strict_types=1);

namespace Codewithkyrian\Tokenizers\Normalizers;

use Codewithkyrian\Tokenizers\Contracts\NormalizerInterface;

class ReplaceNormalizer implements NormalizerInterface
{
    public function __construct(
        protected ?string $regex,
        protected ?string $subString,
        protected string $replacement = ''
    ) {}

    public function normalize(string $text): string
    {
        if (null !== $this->regex) {
            return preg_replace("/{$this->regex}/u", $this->replacement, $text);
        }

        if (null !== $this->subString) {
            return str_replace($this->subString, $this->replacement, $text);
        }

        return $text;
    }
}
