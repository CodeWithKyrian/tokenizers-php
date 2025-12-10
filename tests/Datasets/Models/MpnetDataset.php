<?php

declare(strict_types=1);

namespace Codewithkyrian\Tokenizers\Tests\Datasets\Models;

class MpnetDataset
{
    /**
     * Returns the dataset for MPNet models.
     *
     * @return array<string, array<string, array{text: string, tokens: string[], ids: int[], decoded: string}>>
     */
    public static function data(): array
    {
        return [
            'Xenova/all-mpnet-base-v2' => [
                'Simple' => [
                    'text' => TestStrings::SIMPLE,
                    'tokens' => ['<s>', 'how', 'are', 'you', 'doing', '?', '</s>'],
                    'ids' => [0, 2133, 2028, 2021, 2729, 1033, 2],
                    'decoded' => '<s> how are you doing? </s>',
                ],
                'Simple with punctuation' => [
                    'text' => TestStrings::SIMPLE_WITH_PUNCTUATION,
                    'tokens' => ['<s>', 'you', 'should', "'", 've', 'done', 'this', '</s>'],
                    'ids' => [0, 2021, 2327, 1009, 2314, 2593, 2027, 2],
                    'decoded' => "<s> you should've done this </s>",
                ],
                'Numbers' => [
                    'text' => TestStrings::NUMBERS,
                    'tokens' => ['<s>', '01', '##23', '##45', '##6', '##7', '##8', '##9', '0', '1', '2', '3', '4', '5', '6', '7', '8', '9', '10', '100', '1000', '</s>'],
                    'ids' => [0, 5894, 21930, 19965, 2579, 2585, 2624, 2687, 1018, 1019, 1020, 1021, 1022, 1023, 1024, 1025, 1026, 1027, 2188, 2535, 6698, 2],
                    'decoded' => '<s> 0123456789 0 1 2 3 4 5 6 7 8 9 10 100 1000 </s>',
                ],
                'Text with numbers' => [
                    'text' => TestStrings::TEXT_WITH_NUMBERS,
                    'tokens' => ['<s>', 'the', 'company', 'was', 'founded', 'in', '2016', '.', '</s>'],
                    'ids' => [0, 2000, 2198, 2005, 2635, 2003, 2359, 1016, 2],
                    'decoded' => '<s> the company was founded in 2016. </s>',
                ],
                'Punctuation' => [
                    'text' => TestStrings::PUNCTUATION,
                    'tokens' => ['<s>', 'a', "'", 'll', '!', '!', 'to', '?', "'", 'd', "'", "'", 'd', 'of', ',', 'can', "'", 't', '.', '</s>'],
                    'ids' => [0, 1041, 1009, 2226, 1003, 1003, 2004, 1033, 1009, 1044, 1009, 1009, 1044, 2001, 1014, 2068, 1009, 1060, 1016, 2],
                    'decoded' => "<s> a'll!! to?'d'' d of, can't. </s>",
                ],
                'Python code' => [
                    'text' => TestStrings::PYTHON_CODE,
                    'tokens' => ['<s>', 'def', 'main', '(', ')', ':', 'pass', '</s>'],
                    'ids' => [0, 13370, 2368, 1010, 1011, 1028, 3417, 2],
                    'decoded' => '<s> def main ( ) : pass </s>',
                ],
                'Javascript code' => [
                    'text' => TestStrings::JAVASCRIPT_CODE,
                    'tokens' => ['<s>', 'let', 'a', '=', 'ob', '##j', '.', 'to', '##st', '##ring', '(', ')', ';', 'to', '##st', '##ring', '(', ')', ';', '</s>'],
                    'ids' => [0, 2296, 1041, 1031, 27889, 3505, 1016, 2004, 3371, 4896, 1010, 1011, 1029, 2004, 3371, 4896, 1010, 1011, 1029, 2],
                    'decoded' => '<s> let a = obj. tostring ( ) ; tostring ( ) ; </s>',
                ],
                'Newlines' => [
                    'text' => TestStrings::NEWLINES,
                    'tokens' => ['<s>', 'this', 'is', 'a', 'test', '.', '</s>'],
                    'ids' => [0, 2027, 2007, 1041, 3235, 1016, 2],
                    'decoded' => '<s> this is a test. </s>',
                ],
                'Basic' => [
                    'text' => TestStrings::BASIC,
                    'tokens' => ['<s>', 'unwanted', ',', 'running', '</s>'],
                    'ids' => [0, 18166, 1014, 2774, 2],
                    'decoded' => '<s> unwanted, running </s>',
                ],
                'Control tokens' => [
                    'text' => TestStrings::CONTROL_TOKENS,
                    'tokens' => ['<s>', '123', '</s>'],
                    'ids' => [0, 13142, 2],
                    'decoded' => '<s> 123 </s>',
                ],
                'Hello world titlecase' => [
                    'text' => TestStrings::HELLO_WORLD_TITLECASE,
                    'tokens' => ['<s>', 'hello', 'world', '</s>'],
                    'ids' => [0, 7596, 2092, 2],
                    'decoded' => '<s> hello world </s>',
                ],
                'Hello world lowercase' => [
                    'text' => TestStrings::HELLO_WORLD_LOWERCASE,
                    'tokens' => ['<s>', 'hello', 'world', '</s>'],
                    'ids' => [0, 7596, 2092, 2],
                    'decoded' => '<s> hello world </s>',
                ],
                'Chinese only' => [
                    'text' => TestStrings::CHINESE_ONLY,
                    'tokens' => ['<s>', '生', '[UNK]', '的', '真', '[UNK]', '[UNK]', '</s>'],
                    'ids' => [0, 1914, 104, 1920, 1925, 104, 104, 2],
                    'decoded' => '<s> 生 [UNK] 的 真 [UNK] [UNK] </s>',
                ],
                'Leading space' => [
                    'text' => TestStrings::LEADING_SPACE,
                    'tokens' => ['<s>', 'leading', 'space', '</s>'],
                    'ids' => [0, 2881, 2690, 2],
                    'decoded' => '<s> leading space </s>',
                ],
                'Trailing space' => [
                    'text' => TestStrings::TRAILING_SPACE,
                    'tokens' => ['<s>', 'trailing', 'space', '</s>'],
                    'ids' => [0, 12546, 2690, 2],
                    'decoded' => '<s> trailing space </s>',
                ],
                'Double space' => [
                    'text' => TestStrings::DOUBLE_SPACE,
                    'tokens' => ['<s>', 'hi', 'hello', '</s>'],
                    'ids' => [0, 7636, 7596, 2],
                    'decoded' => '<s> hi hello </s>',
                ],
                'Currency' => [
                    'text' => TestStrings::CURRENCY,
                    'tokens' => ['<s>', 'test', '$', '1', 'r', '##2', '#', '3', '€', '##4', '£5', '¥', '##6', '[UNK]', '₹', '##8', '₱', '##9', 'test', '</s>'],
                    'ids' => [0, 3235, 1006, 1019, 1058, 2479, 1005, 1021, 1578, 2553, 27817, 1075, 2579, 104, 1580, 2624, 1579, 2687, 3235, 2],
                    'decoded' => '<s> test $ 1 r2 # 3 €4 £5 ¥6 [UNK] ₹8 ₱9 test </s>',
                ],
                'Currency with decimals' => [
                    'text' => TestStrings::CURRENCY_WITH_DECIMALS,
                    'tokens' => ['<s>', 'i', 'bought', 'an', 'apple', 'for', '$', '1', '.', '00', 'at', 'the', 'store', '.', '</s>'],
                    'ids' => [0, 1049, 4153, 2023, 6211, 2009, 1006, 1019, 1016, 4006, 2016, 2000, 3577, 1016, 2],
                    'decoded' => '<s> i bought an apple for $ 1. 00 at the store. </s>',
                ],
                'Ellipsis' => [
                    'text' => TestStrings::ELLIPSIS,
                    'tokens' => ['<s>', 'you', '…', '</s>'],
                    'ids' => [0, 2021, 1533, 2],
                    'decoded' => '<s> you … </s>',
                ],
                'Text with escape characters' => [
                    'text' => TestStrings::TEXT_WITH_ESCAPE_CHARACTERS,
                    'tokens' => ['<s>', 'you', '…', '</s>'],
                    'ids' => [0, 2021, 1533, 2],
                    'decoded' => '<s> you … </s>',
                ],
                'Text with escape characters 2' => [
                    'text' => TestStrings::TEXT_WITH_ESCAPE_CHARACTERS_2,
                    'tokens' => ['<s>', 'you', '…', 'you', '…', '</s>'],
                    'ids' => [0, 2021, 1533, 2021, 1533, 2],
                    'decoded' => '<s> you … you … </s>',
                ],
                'Tilde normalization' => [
                    'text' => TestStrings::TILDE_NORMALIZATION,
                    'tokens' => ['<s>', 'weird', '～', 'edge', '～', 'case', '</s>'],
                    'ids' => [0, 6885, 1999, 3345, 1999, 2557, 2],
                    'decoded' => '<s> weird ～ edge ～ case </s>',
                ],
                'Spiece underscore' => [
                    'text' => TestStrings::SPIECE_UNDERSCORE,
                    'tokens' => ['<s>', '[UNK]', '[UNK]', '[UNK]', '[UNK]', '[UNK]', '.', '</s>'],
                    'ids' => [0, 104, 104, 104, 104, 104, 1016, 2],
                    'decoded' => '<s> [UNK] [UNK] [UNK] [UNK] [UNK]. </s>',
                ],
                'Popular emojis' => [
                    'text' => TestStrings::POPULAR_EMOJIS,
                    'tokens' => ['<s>', ...array_fill(0, 39, '[UNK]'), '</s>'],
                    'ids' => [0, ...array_fill(0, 39, 104), 2],
                    'decoded' => '<s> '.trim(str_repeat('[UNK] ', 39)).' </s>',
                ],
                'Multibyte emojis' => [
                    'text' => TestStrings::MULTIBYTE_EMOJIS,
                    'tokens' => ['<s>', '[UNK]', '[UNK]', '[UNK]', '[UNK]', '[UNK]', '[UNK]', '[UNK]', '[UNK]', '[UNK]', '[UNK]', '[UNK]', '[UNK]', '[UNK]', '</s>'],
                    'ids' => [0, 104, 104, 104, 104, 104, 104, 104, 104, 104, 104, 104, 104, 104, 2],
                    'decoded' => '<s> '.trim(str_repeat('[UNK] ', 13)).' </s>',
                ],
            ],
        ];
    }
}
