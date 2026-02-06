<?php

declare(strict_types=1);

namespace Codewithkyrian\Tokenizers\PreTokenizers;

use Codewithkyrian\Tokenizers\Contracts\PreTokenizerInterface;

class MetaspacePreTokenizer implements PreTokenizerInterface
{
    public function __construct(
        protected string $replacement = ' ',
        protected bool $addPrefixSpace = true,
        protected ?string $strRep = null,
        protected string $prependScheme = 'always'
    ) {
        $this->strRep = $this->strRep ?? $this->replacement;
    }

    public function preTokenize(array|string $text, array $options = []): array
    {
        if (\is_array($text)) {
            $result = [];
            foreach ($text as $t) {
                $result = array_merge($result, $this->preTokenize($t, $options));
            }

            return $result;
        }

        $normalized = str_replace(' ', $this->strRep, $text);
        $sectionIndex = $options['section_index'] ?? null;

        if (
            ($this->addPrefixSpace && !str_starts_with($normalized, $this->replacement))
            && (
                'always' === $this->prependScheme
                || ('first' === $this->prependScheme && 0 === $sectionIndex)
            )
        ) {
            $normalized = $this->strRep.$normalized;
        }

        return [$normalized];
    }

    public function getConfig(?string $key = null, mixed $default = null): mixed
    {
        if (null !== $key) {
            return match ($key) {
                'type' => 'Metaspace',
                'replacement' => $this->replacement,
                'add_prefix_space' => $this->addPrefixSpace,
                'str_rep' => $this->strRep,
                'prepend_scheme' => $this->prependScheme,
                default => $default,
            };
        }

        return [
            'type' => 'Metaspace',
            'replacement' => $this->replacement,
            'add_prefix_space' => $this->addPrefixSpace,
            'str_rep' => $this->strRep,
            'prepend_scheme' => $this->prependScheme,
        ];
    }
}
