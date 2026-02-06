<?php

declare(strict_types=1);

namespace Codewithkyrian\Tokenizers\Normalizers;

use Codewithkyrian\Tokenizers\Contracts\NormalizerInterface;
use Codewithkyrian\Tokenizers\Utils\NormalizerUtils;

class BertNormalizer implements NormalizerInterface
{
    public function __construct(
        protected bool $cleanText = true,
        protected bool $handleChineseChars = true,
        protected ?bool $stripAccents = true,
        protected bool $lowercase = true
    ) {}

    public function normalize(string $text): string
    {
        if ($this->cleanText) {
            $text = $this->doCleanText($text);
        }

        if ($this->handleChineseChars) {
            $text = $this->tokenizeChineseChars($text);
        }

        if ($this->lowercase) {
            $text = mb_strtolower($text);

            if (false !== $this->stripAccents) {
                $text = NormalizerUtils::removeAccents($text);
            }
        } elseif ($this->stripAccents) {
            $text = NormalizerUtils::removeAccents($text);
        }

        return $text;
    }

    public function tokenizeChineseChars(string $text): string
    {
        $output = [];
        for ($i = 0; $i < mb_strlen($text); ++$i) {
            $char = mb_substr($text, $i, 1);
            $cp = mb_ord($char);
            if (NormalizerUtils::isChineseChar($cp)) {
                $output[] = ' ';
                $output[] = $char;
                $output[] = ' ';
            } else {
                $output[] = $char;
            }
        }

        return implode('', $output);
    }

    public function getConfig(?string $key = null, mixed $default = null): mixed
    {
        if (null !== $key) {
            return match ($key) {
                'type' => 'BertNormalizer',
                'clean_text' => $this->cleanText,
                'handle_chinese_chars' => $this->handleChineseChars,
                'strip_accents' => $this->stripAccents,
                'lowercase' => $this->lowercase,
                default => $default,
            };
        }

        return [
            'type' => 'BertNormalizer',
            'clean_text' => $this->cleanText,
            'handle_chinese_chars' => $this->handleChineseChars,
            'strip_accents' => $this->stripAccents,
            'lowercase' => $this->lowercase,
        ];
    }

    protected function doCleanText(string $text): string
    {
        $output = [];
        for ($i = 0; $i < mb_strlen($text); ++$i) {
            $char = mb_substr($text, $i, 1);
            $cp = mb_ord($char);
            if (0 === $cp || 0xFFFD === $cp || NormalizerUtils::isControlChar($char)) {
                continue;
            }
            if (preg_match('/^\s$/', $char)) { // is whitespace
                $output[] = ' ';
            } else {
                $output[] = $char;
            }
        }

        return implode('', $output);
    }
}
