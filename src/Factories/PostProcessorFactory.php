<?php

declare(strict_types=1);

namespace Codewithkyrian\Tokenizers\Factories;

use Codewithkyrian\Tokenizers\Contracts\PostProcessorInterface;
use Codewithkyrian\Tokenizers\PostProcessors\BertPostProcessor;
use Codewithkyrian\Tokenizers\PostProcessors\ByteLevelPostProcessor;
use Codewithkyrian\Tokenizers\PostProcessors\PostProcessorSequence;
use Codewithkyrian\Tokenizers\PostProcessors\RobertaPostProcessor;
use Codewithkyrian\Tokenizers\PostProcessors\TemplatePostProcessor;

class PostProcessorFactory
{
    /**
     * @param array<string, mixed> $config the post-processor configuration
     */
    public static function create(array $config): ?PostProcessorInterface
    {
        if (empty($config)) {
            return null;
        }

        $type = $config['type'] ?? null;

        return match ($type) {
            'BertProcessing' => new BertPostProcessor(
                sep: ($config['sep'] ?? ['[SEP]', 102])[0],
                cls: ($config['cls'] ?? ['[CLS]', 101])[0]
            ),
            'RobertaProcessing' => new RobertaPostProcessor(
                sep: ($config['sep'] ?? ['</s>', 2])[0],
                cls: ($config['cls'] ?? ['<s>', 0])[0],
                trimOffsets: $config['trim_offsets'] ?? true,
                addPrefixSpace: $config['add_prefix_space'] ?? true
            ),
            'ByteLevel' => new ByteLevelPostProcessor(
                trimOffsets: $config['trim_offsets'] ?? true,
                useRegex: $config['use_regex'] ?? true,
                addPrefixSpace: $config['add_prefix_space'] ?? true
            ),
            'TemplateProcessing' => new TemplatePostProcessor(
                single: $config['single'],
                pair: $config['pair']
            ),
            'Sequence' => new PostProcessorSequence(
                array_map(fn ($c) => self::create($c), $config['processors'] ?? [])
            ),
            default => throw new \Exception("Unknown post-processor type: {$type}"),
        };
    }
}
