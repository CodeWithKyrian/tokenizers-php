<?php

declare(strict_types=1);

namespace Codewithkyrian\Tokenizers\Decoders;

class StripDecoder extends BaseDecoder
{
    public function __construct(
        protected string $content,
        protected int $start,
        protected int $stop
    ) {}

    protected function processTokens(array $tokens): array
    {
        return array_map(function ($token) {
            $startCut = 0;
            $len = mb_strlen($token);

            for ($i = 0; $i < $this->start; ++$i) {
                if ($i >= $len) {
                    break;
                }
                $char = mb_substr($token, $i, 1);
                if ($char === $this->content) {
                    $startCut = $i + 1;
                } else {
                    break;
                }
            }

            $stopCut = $len;
            for ($i = 0; $i < $this->stop; ++$i) {
                if ($i >= $len) {
                    break;
                }
                $index = $len - $i - 1;
                $char = mb_substr($token, $index, 1);
                if ($char === $this->content) {
                    $stopCut = $index;
                } else {
                    break;
                }
            }

            if ($startCut >= $stopCut) {
                return '';
            }

            return mb_substr($token, $startCut, $stopCut - $startCut);
        }, $tokens);
    }
}
