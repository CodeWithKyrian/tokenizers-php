<?php

declare(strict_types=1);

namespace Codewithkyrian\Tokenizers\Tests\Datasets\Models;

class GptDataset
{
    /**
     * Returns the dataset for GPT models.
     *
     * @return array<string, array<string, array{text: string, tokens: string[], ids: int[], decoded: string}>>
     */
    public static function data(): array
    {
        return [
            'Xenova/gpt2' => [
                'Simple' => [
                    'text' => TestStrings::SIMPLE,
                    'tokens' => ['How', "\u{0120}are", "\u{0120}you", "\u{0120}doing", '?'],
                    'ids' => [2437, 389, 345, 1804, 30],
                    'decoded' => 'How are you doing?',
                ],
                'Simple with punctuation' => [
                    'text' => TestStrings::SIMPLE_WITH_PUNCTUATION,
                    'tokens' => ['You', "\u{0120}should", "'ve", "\u{0120}done", "\u{0120}this"],
                    'ids' => [1639, 815, 1053, 1760, 428],
                    'decoded' => "You should've done this",
                ],
                'Numbers' => [
                    'text' => TestStrings::NUMBERS,
                    'tokens' => ['01', '23', '45', '67', '89', "\u{0120}0", "\u{0120}1", "\u{0120}2", "\u{0120}3", "\u{0120}4", "\u{0120}5", "\u{0120}6", "\u{0120}7", "\u{0120}8", "\u{0120}9", "\u{0120}10", "\u{0120}100", "\u{0120}1000"],
                    'ids' => [486, 1954, 2231, 3134, 4531, 657, 352, 362, 513, 604, 642, 718, 767, 807, 860, 838, 1802, 8576],
                    'decoded' => '0123456789 0 1 2 3 4 5 6 7 8 9 10 100 1000',
                ],
                'Text with numbers' => [
                    'text' => TestStrings::TEXT_WITH_NUMBERS,
                    'tokens' => ['The', "\u{0120}company", "\u{0120}was", "\u{0120}founded", "\u{0120}in", "\u{0120}2016", '.'],
                    'ids' => [464, 1664, 373, 9393, 287, 1584, 13],
                    'decoded' => 'The company was founded in 2016.',
                ],
                'Punctuation' => [
                    'text' => TestStrings::PUNCTUATION,
                    'tokens' => ['A', "\u{010a}", "'ll", "\u{0120}!!", 'to', "?'", 'd', "''", 'd', "\u{0120}of", ',', "\u{0120}can", "'t", '.'],
                    'ids' => [32, 198, 1183, 37867, 1462, 8348, 67, 7061, 67, 286, 11, 460, 470, 13],
                    'decoded' => "A\n'll!!to?'d''d of, can't.",
                ],
                'Python code' => [
                    'text' => TestStrings::PYTHON_CODE,
                    'tokens' => ['def', "\u{0120}main", '():', "\u{010a}", "\u{0109}", 'pass'],
                    'ids' => [4299, 1388, 33529, 198, 197, 6603],
                    'decoded' => "def main():\n\tpass",
                ],
                'Javascript code' => [
                    'text' => TestStrings::JAVASCRIPT_CODE,
                    'tokens' => ['let', "\u{0120}a", "\u{0120}=", "\u{0120}obj", '.', 'to', 'String', '();', "\u{010a}", 'to', 'String', '();'],
                    'ids' => [1616, 257, 796, 26181, 13, 1462, 10100, 9783, 198, 1462, 10100, 9783],
                    'decoded' => "let a = obj.toString();\ntoString();",
                ],
                'Newlines' => [
                    'text' => TestStrings::NEWLINES,
                    'tokens' => ['This', "\u{010a}", "\u{010a}", 'is', "\u{010a}", 'a', "\u{010a}", 'test', '.'],
                    'ids' => [1212, 198, 198, 271, 198, 64, 198, 9288, 13],
                    'decoded' => "This\n\nis\na\ntest.",
                ],
                'Basic' => [
                    'text' => TestStrings::BASIC,
                    'tokens' => ['UN', 'want', "\u{00c3}\u{00a9}", 'd', ',', 'running'],
                    'ids' => [4944, 42949, 2634, 67, 11, 20270],
                    'decoded' => "UNwant\u{00e9}d,running",
                ],
                'Control tokens' => [
                    'text' => TestStrings::CONTROL_TOKENS,
                    'tokens' => ['1', "\u{0100}", '2', "\u{00ef}\u{00bf}\u{00bd}", '3'],
                    'ids' => [16, 188, 17, 4210, 18],
                    'decoded' => "1\u{0000}2\u{FFFD}3",
                ],
                'Hello world titlecase' => [
                    'text' => TestStrings::HELLO_WORLD_TITLECASE,
                    'tokens' => ['Hello', "\u{0120}World"],
                    'ids' => [15496, 2159],
                    'decoded' => 'Hello World',
                ],
                'Hello world lowercase' => [
                    'text' => TestStrings::HELLO_WORLD_LOWERCASE,
                    'tokens' => ['hello', "\u{0120}world"],
                    'ids' => [31373, 995],
                    'decoded' => 'hello world',
                ],
                'Chinese only' => [
                    'text' => TestStrings::CHINESE_ONLY,
                    'tokens' => ["\u{00e7}\u{0136}\u{0141}", "\u{00e6}", "\u{00b4}", "\u{00bb}", "\u{00e7}\u{013c}\u{0126}", "\u{00e7}\u{013e}", "\u{0141}", "\u{00e8}", "\u{00b0}", "\u{013d}", "\u{00e6}\u{013a}\u{00af}"],
                    'ids' => [37955, 162, 112, 119, 21410, 40367, 253, 164, 108, 249, 42468],
                    'decoded' => "\u{751f}\u{6d3b}\u{7684}\u{771f}\u{8c1b}\u{662f}",
                ],
                'Leading space' => [
                    'text' => TestStrings::LEADING_SPACE,
                    'tokens' => ["\u{0120}", "\u{0120}", "\u{0120}leading", "\u{0120}space"],
                    'ids' => [220, 220, 3756, 2272],
                    'decoded' => '   leading space',
                ],
                'Trailing space' => [
                    'text' => TestStrings::TRAILING_SPACE,
                    'tokens' => ['tra', 'iling', "\u{0120}space", "\u{0120}", "\u{0120}", "\u{0120}"],
                    'ids' => [9535, 4386, 2272, 220, 220, 220],
                    'decoded' => 'trailing space   ',
                ],
                'Double space' => [
                    'text' => TestStrings::DOUBLE_SPACE,
                    'tokens' => ['Hi', "\u{0120}", "\u{0120}Hello"],
                    'ids' => [17250, 220, 18435],
                    'decoded' => 'Hi  Hello',
                ],
                'Currency' => [
                    'text' => TestStrings::CURRENCY,
                    'tokens' => ['test', "\u{0120}$", '1', "\u{0120}R", '2', "\u{0120}#", '3', "\u{0120}\u{00e2}\u{0124}\u{00ac}", '4', "\u{0120}\u{00c2}\u{00a3}", '5', "\u{0120}\u{00c2}\u{00a5}", '6', "\u{0120}\u{00e2}", "\u{0124}", "\u{00a3}", '7', "\u{0120}\u{00e2}", "\u{0124}", "\u{00b9}", '8', "\u{0120}\u{00e2}", "\u{0124}", "\u{00b1}", '9', "\u{0120}test"],
                    'ids' => [9288, 720, 16, 371, 17, 1303, 18, 10432, 19, 4248, 20, 38221, 21, 2343, 224, 96, 22, 2343, 224, 117, 23, 2343, 224, 109, 24, 1332],
                    'decoded' => "test $1 R2 #3 \u{20ac}4 \u{00a3}5 \u{00a5}6 \u{20a3}7 \u{20b9}8 \u{20b1}9 test",
                ],
                'Currency with decimals' => [
                    'text' => TestStrings::CURRENCY_WITH_DECIMALS,
                    'tokens' => ['I', "\u{0120}bought", "\u{0120}an", "\u{0120}apple", "\u{0120}for", "\u{0120}$", '1', '.', '00', "\u{0120}at", "\u{0120}the", "\u{0120}store", '.'],
                    'ids' => [40, 5839, 281, 17180, 329, 720, 16, 13, 405, 379, 262, 3650, 13],
                    'decoded' => 'I bought an apple for $1.00 at the store.',
                ],
                'Ellipsis' => [
                    'text' => TestStrings::ELLIPSIS,
                    'tokens' => ['you', "\u{00e2}\u{0122}\u{00a6}", "\u{0120}", "\u{0120}"],
                    'ids' => [5832, 1399, 220, 220],
                    'decoded' => "you\u{2026}  ",
                ],
                'Text with escape characters' => [
                    'text' => TestStrings::TEXT_WITH_ESCAPE_CHARACTERS,
                    'tokens' => ['you', "\u{00e2}\u{0122}\u{00a6}", "\u{00c2}\u{0142}\u{00c2}\u{0142}"],
                    'ids' => [5832, 1399, 4603],
                    'decoded' => "you\u{2026}\u{00a0}\u{00a0}",
                ],
                'Text with escape characters 2' => [
                    'text' => TestStrings::TEXT_WITH_ESCAPE_CHARACTERS_2,
                    'tokens' => ['you', "\u{00e2}\u{0122}\u{00a6}", "\u{00c2}\u{0142}", "\u{00c2}\u{0142}", 'you', "\u{00e2}\u{0122}\u{00a6}", "\u{00c2}\u{0142}\u{00c2}\u{0142}"],
                    'ids' => [5832, 1399, 1849, 1849, 5832, 1399, 4603],
                    'decoded' => "you\u{2026}\u{00a0}\u{00a0}you\u{2026}\u{00a0}\u{00a0}",
                ],
                'Tilde normalization' => [
                    'text' => TestStrings::TILDE_NORMALIZATION,
                    'tokens' => ['we', 'ird', "\u{0120}\u{00ef}", "\u{00bd}", "\u{0140}", "\u{0120}edge", "\u{0120}\u{00ef}", "\u{00bd}", "\u{0140}", "\u{0120}case"],
                    'ids' => [732, 1447, 27332, 121, 252, 5743, 27332, 121, 252, 1339],
                    'decoded' => 'weird ～ edge ～ case',
                ],
                'Spiece underscore' => [
                    'text' => TestStrings::SPIECE_UNDERSCORE,
                    'tokens' => ["\u{00e2}\u{0138}", "\u{0123}", 'This', "\u{0120}\u{00e2}\u{0138}", "\u{0123}", 'is', "\u{0120}\u{00e2}\u{0138}", "\u{0123}", 'a', "\u{0120}\u{00e2}\u{0138}", "\u{0123}", 'test', "\u{0120}\u{00e2}\u{0138}", "\u{0123}", '.'],
                    'ids' => [5008, 223, 1212, 11019, 223, 271, 11019, 223, 64, 11019, 223, 9288, 11019, 223, 13],
                    'decoded' => '▁This ▁is ▁a ▁test ▁.',
                ],
                'Special with trailing whitespace' => [
                    'text' => TestStrings::SENTENCEPIECE_SPECIAL_WITH_TRAILING_WHITESPACE,
                    'tokens' => ['<', 's', '>', "\u{010a}"],
                    'ids' => [27, 82, 29, 198],
                    'decoded' => "<s>\n",
                ],
                'Special surrounded by whitespace' => [
                    'text' => TestStrings::SENTENCEPIECE_SPECIAL_SURROUNDED_BY_WHITESPACE,
                    'tokens' => ["\u{0120}</", 's', '>', "\u{0120}test", "\u{0120}</", 's', '>', "\u{0120}"],
                    'ids' => [7359, 82, 29, 1332, 7359, 82, 29, 220],
                    'decoded' => ' </s> test </s> ',
                ],
                'Special no whitespace' => [
                    'text' => TestStrings::SENTENCEPIECE_SPECIAL_NO_WHITESPACE,
                    'tokens' => ['</', 's', '>', 'test', '</', 's', '>'],
                    'ids' => [3556, 82, 29, 9288, 3556, 82, 29],
                    'decoded' => '</s>test</s>',
                ],
            ],
            'Xenova/gpt-4' => [
                'Punctuation' => [
                    'text' => TestStrings::PUNCTUATION,
                    'tokens' => ['A', "\u{010a}", "'ll", "\u{0120}!!", 'to', "?'", 'd', "''", 'd', "\u{0120}of", ',', "\u{0120}can", "'t", '.'],
                    'ids' => [32, 198, 3358, 11261, 998, 20837, 67, 4708, 67, 315, 11, 649, 956, 13],
                    'decoded' => "A\n'll !!to?'d''d of, can't.",
                ],
                'Javascript code' => [
                    'text' => TestStrings::JAVASCRIPT_CODE,
                    'tokens' => ['let', "\u{0120}a", "\u{0120}=", "\u{0120}obj", '.toString', "();\u{010a}", 'toString', '();'],
                    'ids' => [1169, 264, 284, 2909, 5180, 545, 6712, 2178],
                    'decoded' => "let a = obj.toString();\ntoString();",
                ],
                'Currency' => [
                    'text' => TestStrings::CURRENCY,
                    'tokens' => ['test', "\u{0120}$", '1', "\u{0120}R", '2', "\u{0120}#", '3', "\u{0120}\u{00e2}\u{0124}\u{00ac}", '4', "\u{0120}\u{00c2}\u{00a3}", '5', "\u{0120}\u{00c2}\u{00a5}", '6', "\u{0120}\u{00e2}", "\u{0124}", "\u{00a3}", '7', "\u{0120}\u{00e2}\u{0124}\u{00b9}", '8', "\u{0120}\u{00e2}", "\u{0124}", "\u{00b1}", '9', "\u{0120}test"],
                    'ids' => [1985, 400, 16, 432, 17, 674, 18, 13281, 19, 7083, 20, 72588, 21, 2928, 224, 96, 22, 90891, 23, 2928, 224, 109, 24, 1296],
                    'decoded' => "test $1 R2 #3 \u{20ac}4 \u{00a3}5 \u{00a5}6 \u{20a3}7 \u{20b9}8 \u{20b1}9 test",
                ],
                'Tilde normalization' => [
                    'text' => TestStrings::TILDE_NORMALIZATION,
                    'tokens' => ['we', 'ird', "\u{0120}", "\u{00ef}\u{00bd}\u{0140}", "\u{0120}edge", "\u{0120}", "\u{00ef}\u{00bd}\u{0140}", "\u{0120}case"],
                    'ids' => [906, 2668, 220, 21909, 6964, 220, 21909, 1162],
                    'decoded' => 'weird ～ edge ～ case',
                ],
            ],
            'Xenova/gpt-4o' => [
                'Numbers' => [
                    'text' => TestStrings::NUMBERS,
                    'tokens' => ['012', '345', '678', '9', "\u{0120}", '0', "\u{0120}", '1', "\u{0120}", '2', "\u{0120}", '3', "\u{0120}", '4', "\u{0120}", '5', "\u{0120}", '6', "\u{0120}", '7', "\u{0120}", '8', "\u{0120}", '9', "\u{0120}", '10', "\u{0120}", '100', "\u{0120}", '100', '0'],
                    'ids' => [19267, 22901, 30833, 24, 220, 15, 220, 16, 220, 17, 220, 18, 220, 19, 220, 20, 220, 21, 220, 22, 220, 23, 220, 24, 220, 702, 220, 1353, 220, 1353, 15],
                    'decoded' => '0123456789 0 1 2 3 4 5 6 7 8 9 10 100 1000',
                ],
                'Text with numbers' => [
                    'text' => TestStrings::TEXT_WITH_NUMBERS,
                    'tokens' => ['The', "\u{0120}company", "\u{0120}was", "\u{0120}founded", "\u{0120}in", "\u{0120}", '201', '6', '.'],
                    'ids' => [976, 3175, 673, 24303, 306, 220, 667, 21, 13],
                    'decoded' => 'The company was founded in 2016.',
                ],
                'Punctuation' => [
                    'text' => TestStrings::PUNCTUATION,
                    'tokens' => ['A', "\u{010a}", "'ll", "\u{0120}!!", 'to', "?'", 'd', "''", 'd', "\u{0120}of", ',', "\u{0120}can't", '.'],
                    'ids' => [32, 198, 6090, 17131, 935, 48511, 67, 5830, 67, 328, 11, 8535, 13],
                    'decoded' => "A\n'll !!to?'d''d of, can't.",
                ],
                'Python code' => [
                    'text' => TestStrings::PYTHON_CODE,
                    'tokens' => ['def', "\u{0120}main", "():\u{010a}", "\u{0109}pass"],
                    'ids' => [1314, 2758, 8595, 100653],
                    'decoded' => "def main():\n\tpass",
                ],
                'Javascript code' => [
                    'text' => TestStrings::JAVASCRIPT_CODE,
                    'tokens' => ['let', "\u{0120}a", "\u{0120}=", "\u{0120}obj", '.to', 'String', "();\u{010a}", 'to', 'String', '();'],
                    'ids' => [1347, 261, 314, 4099, 3552, 916, 740, 935, 916, 4177],
                    'decoded' => "let a = obj.toString();\ntoString();",
                ],
                'Newlines' => [
                    'text' => TestStrings::NEWLINES,
                    'tokens' => ['This', "\u{010a}\u{010a}", 'is', "\u{010a}", 'a', "\u{010a}", 'test', '.'],
                    'ids' => [2500, 279, 276, 198, 64, 198, 3190, 13],
                    'decoded' => "This\n\nis\na\ntest.",
                ],
                'Basic' => [
                    'text' => TestStrings::BASIC,
                    'tokens' => ['UN', 'want', "\u{00c3}\u{00a9}d", ',r', 'unning'],
                    'ids' => [2926, 72517, 6383, 33654, 11244],
                    'decoded' => "UNwant\u{00e9}d,running",
                ],
                'Chinese only' => [
                    'text' => TestStrings::CHINESE_ONLY,
                    'tokens' => ["\u{00e7}\u{0136}\u{0141}\u{00e6}\u{00b4}\u{00bb}", "\u{00e7}\u{013c}\u{0126}", "\u{00e7}\u{013e}\u{0141}", "\u{00e8}\u{00b0}", "\u{013d}", "\u{00e6}\u{013a}\u{00af}"],
                    'ids' => [32479, 1616, 7910, 7856, 249, 3221],
                    'decoded' => "\u{751f}\u{6d3b}\u{7684}\u{771f}\u{8c1b}\u{662f}",
                ],
                'Leading space' => [
                    'text' => TestStrings::LEADING_SPACE,
                    'tokens' => ["\u{0120}\u{0120}", "\u{0120}leading", "\u{0120}space"],
                    'ids' => [256, 8117, 4918],
                    'decoded' => '   leading space',
                ],
                'Trailing space' => [
                    'text' => TestStrings::TRAILING_SPACE,
                    'tokens' => ['tr', 'ailing', "\u{0120}space", "\u{0120}\u{0120}\u{0120}"],
                    'ids' => [371, 24408, 4918, 271],
                    'decoded' => 'trailing space   ',
                ],
                'Currency' => [
                    'text' => TestStrings::CURRENCY,
                    'tokens' => ['test', "\u{0120}$", '1', "\u{0120}R", '2', "\u{0120}#", '3', "\u{0120}\u{00e2}\u{0124}\u{00ac}", '4', "\u{0120}\u{00c2}\u{00a3}", '5', "\u{0120}\u{00c2}\u{00a5}", '6', "\u{0120}\u{00e2}\u{0124}", "\u{00a3}", '7', "\u{0120}\u{00e2}\u{0124}\u{00b9}", '8', "\u{0120}\u{00e2}\u{0124}", "\u{00b1}", '9', "\u{0120}test"],
                    'ids' => [3190, 548, 16, 460, 17, 1069, 18, 7950, 19, 8989, 20, 123814, 21, 59790, 96, 22, 73406, 23, 59790, 109, 24, 1746],
                    'decoded' => "test $1 R2 #3 \u{20ac}4 \u{00a3}5 \u{00a5}6 \u{20a3}7 \u{20b9}8 \u{20b1}9 test",
                ],
                'Ellipsis' => [
                    'text' => TestStrings::ELLIPSIS,
                    'tokens' => ['you', "\u{00e2}\u{0122}\u{00a6}", "\u{0120}\u{0120}"],
                    'ids' => [13320, 1131, 256],
                    'decoded' => "you\u{2026}  ",
                ],
                'Tilde normalization' => [
                    'text' => TestStrings::TILDE_NORMALIZATION,
                    'tokens' => ['we', 'ird', "\u{0120}\u{00ef}\u{00bd}\u{0140}", "\u{0120}edge", "\u{0120}\u{00ef}\u{00bd}\u{0140}", "\u{0120}case"],
                    'ids' => [854, 2716, 105665, 11165, 105665, 1890],
                    'decoded' => 'weird ～ edge ～ case',
                ],
                'Spiece underscore' => [
                    'text' => TestStrings::SPIECE_UNDERSCORE,
                    'tokens' => ["\u{00e2}\u{0138}", "\u{0123}", 'This', "\u{0120}\u{00e2}\u{0138}\u{0123}", 'is', "\u{0120}\u{00e2}\u{0138}\u{0123}", 'a', "\u{0120}\u{00e2}\u{0138}\u{0123}", 'test', "\u{0120}\u{00e2}\u{0138}\u{0123}", '.'],
                    'ids' => [6762, 223, 2500, 39960, 276, 39960, 64, 39960, 3190, 39960, 13],
                    'decoded' => '▁This ▁is ▁a ▁test ▁.',
                ],
                'Special with trailing whitespace' => [
                    'text' => TestStrings::SENTENCEPIECE_SPECIAL_WITH_TRAILING_WHITESPACE,
                    'tokens' => ['<s', ">\u{010a}"],
                    'ids' => [101950, 523],
                    'decoded' => "<s>\n",
                ],
            ],
            'Xenova/claude-tokenizer' => [
                'Javascript code' => [
                    'text' => TestStrings::JAVASCRIPT_CODE,
                    'tokens' => ['let', "\u{0120}a", "\u{0120}=", "\u{0120}obj", '.', 'toString', '();', "\u{010a}", 'toString', '();'],
                    'ids' => [1785, 269, 284, 2652, 18, 26492, 4370, 203, 26492, 4370],
                    'decoded' => "let a = obj.toString();\ntoString();",
                ],
                'Basic' => [
                    'text' => TestStrings::BASIC,
                    'tokens' => ['UN', 'want', "\u{00c3}\u{00a9}d", ',', 'running'],
                    'ids' => [2359, 17571, 37911, 16, 7889],
                    'decoded' => "UNwant\u{00e9}d,running",
                ],
                'Chinese only' => [
                    'text' => TestStrings::CHINESE_ONLY,
                    'tokens' => ["\u{00e7}\u{0136}\u{0141}", "\u{00e6}\u{00b4}\u{00bb}", "\u{00e7}\u{013c}\u{0126}", "\u{00e7}\u{013e}\u{0141}", "\u{00e8}\u{00b0}", "\u{013d}", "\u{00e6}\u{013a}\u{00af}"],
                    'ids' => [14706, 37675, 2471, 56904, 15959, 254, 5977],
                    'decoded' => "\u{751f}\u{6d3b}\u{7684}\u{771f}\u{8c1b}\u{662f}",
                ],
                'Trailing space' => [
                    'text' => TestStrings::TRAILING_SPACE,
                    'tokens' => ['trailing', "\u{0120}space", "\u{0120}\u{0120}\u{0120}"],
                    'ids' => [40110, 3384, 264],
                    'decoded' => 'trailing space   ',
                ],
                'Currency' => [
                    'text' => TestStrings::CURRENCY,
                    'tokens' => ['test', "\u{0120}$", '1', "\u{0120}R", '2', "\u{0120}#", '3', "\u{0120}\u{00e2}\u{0124}\u{00ac}", '4', "\u{0120}\u{00c2}\u{00a3}", '5', "\u{0120}\u{00c2}", "\u{00a5}", '6', "\u{0120}\u{00e2}", "\u{0124}", "\u{00a3}", '7', "\u{0120}\u{00e2}", "\u{0124}", "\u{00b9}", '8', "\u{0120}\u{00e2}", "\u{0124}", "\u{00b1}", '9', "\u{0120}test"],
                    'ids' => [765, 734, 21, 487, 22, 379, 23, 36714, 24, 13206, 25, 2455, 103, 26, 4937, 229, 101, 27, 4937, 229, 122, 28, 4937, 229, 114, 29, 722],
                    'decoded' => "test $1 R2 #3 \u{20ac}4 \u{00a3}5 \u{00a5}6 \u{20a3}7 \u{20b9}8 \u{20b1}9 test",
                ],
                'Ellipsis' => [
                    'text' => TestStrings::ELLIPSIS,
                    'tokens' => ['you', '...', "\u{0120}\u{0120}"],
                    'ids' => [6773, 1174, 261],
                    'decoded' => 'you...  ',
                ],
                'Text with escape characters' => [
                    'text' => TestStrings::TEXT_WITH_ESCAPE_CHARACTERS,
                    'tokens' => ['you', '...', "\u{0120}\u{0120}"],
                    'ids' => [6773, 1174, 261],
                    'decoded' => 'you...  ',
                ],
                'Text with escape characters 2' => [
                    'text' => TestStrings::TEXT_WITH_ESCAPE_CHARACTERS_2,
                    'tokens' => ['you', '...', "\u{0120}", "\u{0120}you", '...', "\u{0120}\u{0120}"],
                    'ids' => [6773, 1174, 225, 583, 1174, 261],
                    'decoded' => 'you...  you...  ',
                ],
                'Tilde normalization' => [
                    'text' => TestStrings::TILDE_NORMALIZATION,
                    'tokens' => ['we', 'ird', "\u{0120}~", "\u{0120}edge", "\u{0120}~", "\u{0120}case"],
                    'ids' => [798, 2650, 6217, 4915, 6217, 1544],
                    'decoded' => 'weird ~ edge ~ case',
                ],
            ],
            'bigcode/santacoder' => [
                'Numbers' => [
                    'text' => TestStrings::NUMBERS,
                    'tokens' => ['0', '1', '2', '3', '4', '5', '6', '7', '8', '9', 'Ġ', '0', 'Ġ', '1', 'Ġ', '2', 'Ġ', '3', 'Ġ', '4', 'Ġ', '5', 'Ġ', '6', 'Ġ', '7', 'Ġ', '8', 'Ġ', '9', 'Ġ', '1', '0', 'Ġ', '1', '0', '0', 'Ġ', '1', '0', '0', '0'],
                    'ids' => [15, 16, 17, 18, 19, 20, 21, 22, 23, 24, 207, 15, 207, 16, 207, 17, 207, 18, 207, 19, 207, 20, 207, 21, 207, 22, 207, 23, 207, 24, 207, 16, 15, 207, 16, 15, 15, 207, 16, 15, 15, 15],
                    'decoded' => '0123456789 0 1 2 3 4 5 6 7 8 9 10 100 1000',
                ],
                'Text with numbers' => [
                    'text' => TestStrings::TEXT_WITH_NUMBERS,
                    'tokens' => ['The', "\u{0120}company", "\u{0120}was", "\u{0120}fo", 'unded', "\u{0120}in", "\u{0120}", '2', '0', '1', '6', '.'],
                    'ids' => [2111, 10107, 2501, 17436, 7584, 319, 207, 17, 15, 16, 21, 13],
                    'decoded' => 'The company was founded in 2016.',
                ],
                'Chinese only' => [
                    'text' => TestStrings::CHINESE_ONLY,
                    'tokens' => ["\u{00e7}\u{0136}\u{0141}", "\u{00e6}\u{00b4}\u{00bb}", "\u{00e7}\u{013c}\u{0126}", "\u{00e7}\u{013e}\u{0141}", "\u{00e8}\u{00b0}", "\u{013d}", "\u{00e6}\u{013a}\u{00af}"],
                    'ids' => [8715, 24543, 1825, 34717, 37452, 236, 4343],
                    'decoded' => "\u{751f}\u{6d3b}\u{7684}\u{771f}\u{8c1b}\u{662f}",
                ],
                'Currency with decimals' => [
                    'text' => TestStrings::CURRENCY_WITH_DECIMALS,
                    'tokens' => ['I', "\u{0120}bo", 'ught', "\u{0120}an", "\u{0120}apple", "\u{0120}for", "\u{0120}$", '1', '.', '0', '0', "\u{0120}at", "\u{0120}the", "\u{0120}store", '.'],
                    'ids' => [40, 12307, 10310, 743, 29806, 408, 763, 16, 13, 15, 15, 869, 331, 2823, 13],
                    'decoded' => 'I bought an apple for $1.00 at the store.',
                ],
                'Tilde normalization' => [
                    'text' => TestStrings::TILDE_NORMALIZATION,
                    'tokens' => ['we', 'ird', "\u{0120}", "\u{00ef}\u{00bd}", "\u{0140}", "\u{0120}edge", "\u{0120}", "\u{00ef}\u{00bd}", "\u{0140}", "\u{0120}case"],
                    'ids' => [1850, 4427, 207, 29217, 239, 4959, 207, 29217, 239, 1210],
                    'decoded' => 'weird ～ edge ～ case',
                ],
                'Spiece underscore' => [
                    'text' => TestStrings::SPIECE_UNDERSCORE,
                    'tokens' => ["\u{00e2}\u{0138}", "\u{0123}", 'This', "\u{0120}", "\u{00e2}\u{0138}", "\u{0123}", 'is', "\u{0120}", "\u{00e2}\u{0138}", "\u{0123}", 'a', "\u{0120}", "\u{00e2}\u{0138}", "\u{0123}", 'test', "\u{0120}", "\u{00e2}\u{0138}", "\u{0123}", '.'],
                    'ids' => [3718, 210, 3456, 207, 3718, 210, 280, 207, 3718, 210, 64, 207, 3718, 210, 706, 207, 3718, 210, 13],
                    'decoded' => '▁This ▁is ▁a ▁test ▁.',
                ],
            ],
            'Xenova/CodeGPT-tokenizer' => [
                'Chinese only' => [
                    'text' => TestStrings::CHINESE_ONLY,
                    'tokens' => ["\u{00e7}\u{0136}\u{0141}", "\u{00e6}", "\u{00b4}", "\u{00bb}", "\u{00e7}\u{013c}\u{0126}", "\u{00e7}\u{013e}", "\u{0141}", "\u{00e8}\u{00b0}", "\u{013d}", "\u{00e6}\u{013a}\u{00af}"],
                    'ids' => [25506, 165, 115, 122, 5137, 43415, 256, 20679, 252, 13283],
                    'decoded' => "\u{751f}\u{6d3b}\u{7684}\u{771f}\u{8c1b}\u{662f}",
                ],
                'Trailing space' => [
                    'text' => TestStrings::TRAILING_SPACE,
                    'tokens' => ['trailing', "\u{0120}space", "\u{0120}", "\u{0120}", "\u{0120}"],
                    'ids' => [15584, 3497, 223, 223, 223],
                    'decoded' => 'trailing space   ',
                ],
                'Text with escape characters' => [
                    'text' => TestStrings::TEXT_WITH_ESCAPE_CHARACTERS,
                    'tokens' => ['you', "\u{00e2}\u{0122}\u{00a6}", "\u{00c2}", "\u{0142}", "\u{00c2}", "\u{0142}"],
                    'ids' => [13953, 29502, 129, 257, 129, 257],
                    'decoded' => "you\u{2026}\u{00a0}\u{00a0}",
                ],
                'Text with escape characters 2' => [
                    'text' => TestStrings::TEXT_WITH_ESCAPE_CHARACTERS_2,
                    'tokens' => ['you', "\u{00e2}\u{0122}\u{00a6}", "\u{00c2}", "\u{0142}", "\u{00c2}", "\u{0142}", 'you', "\u{00e2}\u{0122}\u{00a6}", "\u{00c2}", "\u{0142}", "\u{00c2}", "\u{0142}"],
                    'ids' => [13953, 29502, 129, 257, 129, 257, 13953, 29502, 129, 257, 129, 257],
                    'decoded' => "you\u{2026}\u{00a0}\u{00a0}you\u{2026}\u{00a0}\u{00a0}",
                ],
            ],
        ];
    }
}
