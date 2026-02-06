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

    public function getConfig(?string $key = null, mixed $default = null): mixed
    {
        if (null !== $key) {
            return match ($key) {
                'type' => 'RobertaProcessing',
                'sep' => [$this->sep, 0],
                'cls' => [$this->cls, 0],
                'trim_offsets' => $this->trimOffsets,
                'add_prefix_space' => $this->addPrefixSpace,
                default => $default,
            };
        }

        return [
            'type' => 'RobertaProcessing',
            'sep' => [$this->sep, 0],
            'cls' => [$this->cls, 0],
            'trim_offsets' => $this->trimOffsets,
            'add_prefix_space' => $this->addPrefixSpace,
        ];
    }
}
