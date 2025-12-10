<?php

declare(strict_types=1);

namespace Codewithkyrian\Tokenizers\Tests\Datasets\Models;

class AlbertDataset
{
    /**
     * Returns the dataset for Albert models.
     *
     * @return array<string, array<string, array{text: string, tokens: string[], ids: int[], decoded: string}>>
     */
    public static function data(): array
    {
        return [
            'albert/albert-base-v2' => [
                'Simple' => [
                    'text' => TestStrings::SIMPLE,
                    'tokens' => ['[CLS]', "\u{2581}how", "\u{2581}are", "\u{2581}you", "\u{2581}doing", '?', '[SEP]'],
                    'ids' => [2, 184, 50, 42, 845, 60, 3],
                    'decoded' => '[CLS] how are you doing?[SEP]',
                ],
                'Simple with punctuation' => [
                    'text' => TestStrings::SIMPLE_WITH_PUNCTUATION,
                    'tokens' => ['[CLS]', "\u{2581}you", "\u{2581}should", "'", 've', "\u{2581}done", "\u{2581}this", '[SEP]'],
                    'ids' => [2, 42, 378, 22, 195, 677, 48, 3],
                    'decoded' => "[CLS] you should've done this[SEP]",
                ],
                'Numbers' => [
                    'text' => TestStrings::NUMBERS,
                    'tokens' => ['[CLS]', "\u{2581}0", '12', '345', '67', '89', "\u{2581}0", "\u{2581}1", "\u{2581}2", "\u{2581}3", "\u{2581}4", "\u{2581}5", "\u{2581}6", "\u{2581}7", "\u{2581}8", "\u{2581}9", "\u{2581}10", "\u{2581}100", "\u{2581}1000", '[SEP]'],
                    'ids' => [2, 713, 918, 21997, 4167, 3877, 713, 137, 172, 203, 268, 331, 400, 453, 469, 561, 332, 808, 6150, 3],
                    'decoded' => '[CLS] 0123456789 0 1 2 3 4 5 6 7 8 9 10 100 1000[SEP]',
                ],
                'Text with numbers' => [
                    'text' => TestStrings::TEXT_WITH_NUMBERS,
                    'tokens' => ['[CLS]', "\u{2581}the", "\u{2581}company", "\u{2581}was", "\u{2581}founded", "\u{2581}in", "\u{2581}2016", '.', '[SEP]'],
                    'ids' => [2, 14, 237, 23, 785, 19, 690, 9, 3],
                    'decoded' => '[CLS] the company was founded in 2016.[SEP]',
                ],
                'Hello world titlecase' => [
                    'text' => TestStrings::HELLO_WORLD_TITLECASE,
                    'tokens' => ['[CLS]', "\u{2581}hello", "\u{2581}world", '[SEP]'],
                    'ids' => [2, 10975, 126, 3],
                    'decoded' => '[CLS] hello world[SEP]',
                ],
                'Hello world lowercase' => [
                    'text' => TestStrings::HELLO_WORLD_LOWERCASE,
                    'tokens' => ['[CLS]', "\u{2581}hello", "\u{2581}world", '[SEP]'],
                    'ids' => [2, 10975, 126, 3],
                    'decoded' => '[CLS] hello world[SEP]',
                ],
                'Chinese only' => [
                    'text' => TestStrings::CHINESE_ONLY,
                    'tokens' => ['[CLS]', "\u{2581}", "\u{751f}\u{6d3b}\u{7684}\u{771f}\u{8c1b}\u{662f}", '[SEP]'],
                    'ids' => [2, 13, 1, 3],
                    'decoded' => '[CLS] <unk>[SEP]',
                ],
                'Leading space' => [
                    'text' => TestStrings::LEADING_SPACE,
                    'tokens' => ['[CLS]', "\u{2581}leading", "\u{2581}space", '[SEP]'],
                    'ids' => [2, 1005, 726, 3],
                    'decoded' => '[CLS] leading space[SEP]',
                ],
                'Trailing space' => [
                    'text' => TestStrings::TRAILING_SPACE,
                    'tokens' => ['[CLS]', "\u{2581}trailing", "\u{2581}space", '[SEP]'],
                    'ids' => [2, 14323, 726, 3],
                    'decoded' => '[CLS] trailing space[SEP]',
                ],
                'Double space' => [
                    'text' => TestStrings::DOUBLE_SPACE,
                    'tokens' => ['[CLS]', "\u{2581}hi", "\u{2581}hello", '[SEP]'],
                    'ids' => [2, 4148, 10975, 3],
                    'decoded' => '[CLS] hi hello[SEP]',
                ],
                'Chinese latin mixed' => [
                    'text' => TestStrings::CHINESE_LATIN_MIXED,
                    'tokens' => ['[CLS]', "\u{2581}", 'ah', "\u{535a}\u{63a8}", 'zz', '[SEP]'],
                    'ids' => [2, 13, 1307, 1, 5092, 3],
                    'decoded' => '[CLS] ah<unk>zz[SEP]',
                ],
                'Simple with accents' => [
                    'text' => TestStrings::SIMPLE_WITH_ACCENTS,
                    'tokens' => ['[CLS]', "\u{2581}hello", '[SEP]'],
                    'ids' => [2, 10975, 3],
                    'decoded' => '[CLS] hello[SEP]',
                ],
                'Mixed case without accents' => [
                    'text' => TestStrings::MIXED_CASE_WITHOUT_ACCENTS,
                    'tokens' => ['[CLS]', "\u{2581}hello", '!', 'how', "\u{2581}are", "\u{2581}you", '?', '[SEP]'],
                    'ids' => [2, 10975, 187, 1544, 50, 42, 60, 3],
                    'decoded' => '[CLS] hello!how are you?[SEP]',
                ],
                'Mixed case with accents' => [
                    'text' => TestStrings::MIXED_CASE_WITH_ACCENTS,
                    'tokens' => ['[CLS]', "\u{2581}hall", 'o', '!', 'how', "\u{2581}are", "\u{2581}you", '?', '[SEP]'],
                    'ids' => [2, 554, 111, 187, 1544, 50, 42, 60, 3],
                    'decoded' => '[CLS] hallo!how are you?[SEP]',
                ],
            ],
        ];
    }
}
