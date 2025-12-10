<?php

declare(strict_types=1);

namespace Codewithkyrian\Tokenizers\PostProcessors;

class RobertaPostProcessor extends BertPostProcessor
{
    public function __construct(
        string $sep,
        string $cls,
        protected bool $trimOffsets = true,
        protected bool $addPrefixSpace = true
    ) {
        parent::__construct($sep, $cls);
    }
}
