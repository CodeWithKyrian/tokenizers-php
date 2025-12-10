<?php

declare(strict_types=1);

namespace Codewithkyrian\Tokenizers\Tests\Datasets\Models;

class BertDataset
{
    /**
     * Dataset for BERT-based models.
     *
     * @return array<string, array<string, array{text: string, tokens: string[], ids: int[], decoded: string, text_pair?: string}>>
     */
    public static function data(): array
    {
        return [
            'Xenova/bert-base-uncased' => [
                'Simple' => [
                    'text' => TestStrings::SIMPLE,
                    'tokens' => ['[CLS]', 'how', 'are', 'you', 'doing', '?', '[SEP]'],
                    'ids' => [101, 2129, 2024, 2017, 2725, 1029, 102],
                    'decoded' => '[CLS] how are you doing? [SEP]',
                ],
                'Simple with punctuation' => [
                    'text' => TestStrings::SIMPLE_WITH_PUNCTUATION,
                    'tokens' => ['[CLS]', 'you', 'should', "'", 've', 'done', 'this', '[SEP]'],
                    'ids' => [101, 2017, 2323, 1005, 2310, 2589, 2023, 102],
                    'decoded' => "[CLS] you should've done this [SEP]",
                ],
                'Text with numbers' => [
                    'text' => TestStrings::TEXT_WITH_NUMBERS,
                    'tokens' => ['[CLS]', 'the', 'company', 'was', 'founded', 'in', '2016', '.', '[SEP]'],
                    'ids' => [101, 1996, 2194, 2001, 2631, 1999, 2355, 1012, 102],
                    'decoded' => '[CLS] the company was founded in 2016. [SEP]',
                ],
                'Punctuation' => [
                    'text' => TestStrings::PUNCTUATION,
                    'tokens' => ['[CLS]', 'a', "'", 'll', '!', '!', 'to', '?', "'", 'd', "'", "'", 'd', 'of', ',', 'can', "'", 't', '.', '[SEP]'],
                    'ids' => [101, 1037, 1005, 2222, 999, 999, 2000, 1029, 1005, 1040, 1005, 1005, 1040, 1997, 1010, 2064, 1005, 1056, 1012, 102],
                    'decoded' => "[CLS] a'll!! to?'d'' d of, can't. [SEP]",
                ],
                'Python code' => [
                    'text' => TestStrings::PYTHON_CODE,
                    'tokens' => ['[CLS]', 'def', 'main', '(', ')', ':', 'pass', '[SEP]'],
                    'ids' => [101, 13366, 2364, 1006, 1007, 1024, 3413, 102],
                    'decoded' => '[CLS] def main ( ) : pass [SEP]',
                ],
                'Javascript code' => [
                    'text' => TestStrings::JAVASCRIPT_CODE,
                    'tokens' => ['[CLS]', 'let', 'a', '=', 'ob', '##j', '.', 'to', '##st', '##ring', '(', ')', ';', 'to', '##st', '##ring', '(', ')', ';', '[SEP]'],
                    'ids' => [101, 2292, 1037, 1027, 27885, 3501, 1012, 2000, 3367, 4892, 1006, 1007, 1025, 2000, 3367, 4892, 1006, 1007, 1025, 102],
                    'decoded' => '[CLS] let a = obj. tostring ( ) ; tostring ( ) ; [SEP]',
                ],
                'Newlines' => [
                    'text' => TestStrings::NEWLINES,
                    'tokens' => ['[CLS]', 'this', 'is', 'a', 'test', '.', '[SEP]'],
                    'ids' => [101, 2023, 2003, 1037, 3231, 1012, 102],
                    'decoded' => '[CLS] this is a test. [SEP]',
                ],
                'Basic' => [
                    'text' => TestStrings::BASIC,
                    'tokens' => ['[CLS]', 'unwanted', ',', 'running', '[SEP]'],
                    'ids' => [101, 18162, 1010, 2770, 102],
                    'decoded' => '[CLS] unwanted, running [SEP]',
                ],
                'Control tokens' => [
                    'text' => TestStrings::CONTROL_TOKENS,
                    'tokens' => ['[CLS]', '123', '[SEP]'],
                    'ids' => [101, 13138, 102],
                    'decoded' => '[CLS] 123 [SEP]',
                ],
                'Hello world titlecase' => [
                    'text' => TestStrings::HELLO_WORLD_TITLECASE,
                    'tokens' => ['[CLS]', 'hello', 'world', '[SEP]'],
                    'ids' => [101, 7592, 2088, 102],
                    'decoded' => '[CLS] hello world [SEP]',
                ],
                'Hello world lowercase' => [
                    'text' => TestStrings::HELLO_WORLD_LOWERCASE,
                    'tokens' => ['[CLS]', 'hello', 'world', '[SEP]'],
                    'ids' => [101, 7592, 2088, 102],
                    'decoded' => '[CLS] hello world [SEP]',
                ],
                'Chinese only' => [
                    'text' => TestStrings::CHINESE_ONLY,
                    'tokens' => ['[CLS]', '生', '[UNK]', '的', '真', '[UNK]', '[UNK]', '[SEP]'],
                    'ids' => [101, 1910, 100, 1916, 1921, 100, 100, 102],
                    'decoded' => '[CLS] 生 [UNK] 的 真 [UNK] [UNK] [SEP]',
                ],
                'Leading space' => [
                    'text' => TestStrings::LEADING_SPACE,
                    'tokens' => ['[CLS]', 'leading', 'space', '[SEP]'],
                    'ids' => [101, 2877, 2686, 102],
                    'decoded' => '[CLS] leading space [SEP]',
                ],
                'Trailing space' => [
                    'text' => TestStrings::TRAILING_SPACE,
                    'tokens' => ['[CLS]', 'trailing', 'space', '[SEP]'],
                    'ids' => [101, 12542, 2686, 102],
                    'decoded' => '[CLS] trailing space [SEP]',
                ],
                'Double space' => [
                    'text' => TestStrings::DOUBLE_SPACE,
                    'tokens' => ['[CLS]', 'hi', 'hello', '[SEP]'],
                    'ids' => [101, 7632, 7592, 102],
                    'decoded' => '[CLS] hi hello [SEP]',
                ],
                'Currency' => [
                    'text' => TestStrings::CURRENCY,
                    'tokens' => ['[CLS]', 'test', '$', '1', 'r', '##2', '#', '3', '€', '##4', '£5', '¥', '##6', '[UNK]', '₹', '##8', '₱', '##9', 'test', '[SEP]'],
                    'ids' => [101, 3231, 1002, 1015, 1054, 2475, 1001, 1017, 1574, 2549, 27813, 1071, 2575, 100, 1576, 2620, 1575, 2683, 3231, 102],
                    'decoded' => '[CLS] test $ 1 r2 # 3 €4 £5 ¥6 [UNK] ₹8 ₱9 test [SEP]',
                ],
                'Currency with decimals' => [
                    'text' => TestStrings::CURRENCY_WITH_DECIMALS,
                    'tokens' => ['[CLS]', 'i', 'bought', 'an', 'apple', 'for', '$', '1', '.', '00', 'at', 'the', 'store', '.', '[SEP]'],
                    'ids' => [101, 1045, 4149, 2019, 6207, 2005, 1002, 1015, 1012, 4002, 2012, 1996, 3573, 1012, 102],
                    'decoded' => '[CLS] i bought an apple for $ 1. 00 at the store. [SEP]',
                ],
                'Ellipsis' => [
                    'text' => TestStrings::ELLIPSIS,
                    'tokens' => ['[CLS]', 'you', '…', '[SEP]'],
                    'ids' => [101, 2017, 1529, 102],
                    'decoded' => '[CLS] you … [SEP]',
                ],
                'Text with escape characters' => [
                    'text' => TestStrings::TEXT_WITH_ESCAPE_CHARACTERS,
                    'tokens' => ['[CLS]', 'you', '…', '[SEP]'],
                    'ids' => [101, 2017, 1529, 102],
                    'decoded' => '[CLS] you … [SEP]',
                ],
                'Text with escape characters 2' => [
                    'text' => TestStrings::TEXT_WITH_ESCAPE_CHARACTERS_2,
                    'tokens' => ['[CLS]', 'you', '…', 'you', '…', '[SEP]'],
                    'ids' => [101, 2017, 1529, 2017, 1529, 102],
                    'decoded' => '[CLS] you … you … [SEP]',
                ],
                'Tilde normalization' => [
                    'text' => TestStrings::TILDE_NORMALIZATION,
                    'tokens' => ['[CLS]', 'weird', '～', 'edge', '～', 'case', '[SEP]'],
                    'ids' => [101, 6881, 1995, 3341, 1995, 2553, 102],
                    'decoded' => '[CLS] weird ～ edge ～ case [SEP]',
                ],
                'Spiece underscore' => [
                    'text' => TestStrings::SPIECE_UNDERSCORE,
                    'tokens' => ['[CLS]', '[UNK]', '[UNK]', '[UNK]', '[UNK]', '[UNK]', '.', '[SEP]'],
                    'ids' => [101, 100, 100, 100, 100, 100, 1012, 102],
                    'decoded' => '[CLS] [UNK] [UNK] [UNK] [UNK] [UNK]. [SEP]',
                ],
                'Popular emojis' => [
                    'text' => TestStrings::POPULAR_EMOJIS,
                    'tokens' => ['[CLS]', ...array_fill(0, 39, '[UNK]'), '[SEP]'],
                    'ids' => [101, ...array_fill(0, 39, 100), 102],
                    'decoded' => '[CLS] '.trim(str_repeat('[UNK] ', 39)).' [SEP]',
                ],
                'Multibyte emojis' => [
                    'text' => TestStrings::MULTIBYTE_EMOJIS,
                    'tokens' => ['[CLS]', '[UNK]', '[UNK]', '[UNK]', '[UNK]', '[UNK]', '[UNK]', '[UNK]', '[UNK]', '[UNK]', '[UNK]', '[UNK]', '[UNK]', '[UNK]', '[SEP]'],
                    'ids' => [101, 100, 100, 100, 100, 100, 100, 100, 100, 100, 100, 100, 100, 100, 102],
                    'decoded' => '[CLS] [UNK] [UNK] [UNK] [UNK] [UNK] [UNK] [UNK] [UNK] [UNK] [UNK] [UNK] [UNK] [UNK] [SEP]',
                ],
                'Chinese latin mixed' => [
                    'text' => TestStrings::CHINESE_LATIN_MIXED,
                    'tokens' => ['[CLS]', 'ah', '博', '[UNK]', 'z', '##z', '[SEP]'],
                    'ids' => [101, 6289, 1786, 100, 1062, 2480, 102],
                    'decoded' => '[CLS] ah 博 [UNK] zz [SEP]',
                ],
                'Simple with accents' => [
                    'text' => TestStrings::SIMPLE_WITH_ACCENTS,
                    'tokens' => ['[CLS]', 'hello', '[SEP]'],
                    'ids' => [101, 7592, 102],
                    'decoded' => '[CLS] hello [SEP]',
                ],
                'Mixed case without accents' => [
                    'text' => TestStrings::MIXED_CASE_WITHOUT_ACCENTS,
                    'tokens' => ['[CLS]', 'hello', '!', 'how', 'are', 'you', '?', '[SEP]'],
                    'ids' => [101, 7592, 999, 2129, 2024, 2017, 1029, 102],
                    'decoded' => '[CLS] hello! how are you? [SEP]',
                ],
                'Mixed case with accents' => [
                    'text' => TestStrings::MIXED_CASE_WITH_ACCENTS,
                    'tokens' => ['[CLS]', 'hall', '##o', '!', 'how', 'are', 'you', '?', '[SEP]'],
                    'ids' => [101, 2534, 2080, 999, 2129, 2024, 2017, 1029, 102],
                    'decoded' => '[CLS] hallo! how are you? [SEP]',
                ],
                'Only whitespace' => [
                    'text' => TestStrings::ONLY_WHITESPACE,
                    'tokens' => ['[CLS]', '[SEP]'],
                    'ids' => [101, 102],
                    'decoded' => '[CLS] [SEP]',
                ],
                'Text pair' => [
                    'text' => 'hello',
                    'text_pair' => 'world',
                    'tokens' => ['[CLS]', 'hello', '[SEP]', 'world', '[SEP]'],
                    'ids' => [101, 7592, 102, 2088, 102],
                    'decoded' => '[CLS] hello [SEP] world [SEP]',
                ],
            ],
            'Xenova/bert-base-cased' => [
                'Javascript code' => [
                    'text' => TestStrings::JAVASCRIPT_CODE,
                    'tokens' => ['[CLS]', 'let', 'a', '=', 'o', '##b', '##j', '.', 'to', '##S', '##tring', '(', ')', ';', 'to', '##S', '##tring', '(', ')', ';', '[SEP]'],
                    'ids' => [101, 1519, 170, 134, 184, 1830, 3361, 119, 1106, 1708, 28108, 113, 114, 132, 1106, 1708, 28108, 113, 114, 132, 102],
                    'decoded' => '[CLS] let a = obj. toString ( ) ; toString ( ) ; [SEP]',
                ],
                'Basic' => [
                    'text' => TestStrings::BASIC,
                    'tokens' => ['[CLS]', 'UN', '##wan', '##té', '##d', ',', 'running', '[SEP]'],
                    'ids' => [101, 7414, 5491, 14608, 1181, 117, 1919, 102],
                    'decoded' => '[CLS] UNwantéd, running [SEP]',
                ],
                'Chinese only' => [
                    'text' => TestStrings::CHINESE_ONLY,
                    'tokens' => ['[CLS]', '生', '[UNK]', '[UNK]', '真', '[UNK]', '[UNK]', '[SEP]'],
                    'ids' => [101, 1056, 100, 100, 1061, 100, 100, 102],
                    'decoded' => '[CLS] 生 [UNK] [UNK] 真 [UNK] [UNK] [SEP]',
                ],
                'Currency' => [
                    'text' => TestStrings::CURRENCY,
                    'tokens' => ['[CLS]', 'test', '$', '1', 'R', '##2', '#', '3', '€', '##4', '£', '##5', '¥', '##6', '[UNK]', '₹', '##8', '₱', '##9', 'test', '[SEP]'],
                    'ids' => [101, 2774, 109, 122, 155, 1477, 108, 124, 836, 1527, 202, 1571, 203, 1545, 100, 838, 1604, 837, 1580, 2774, 102],
                    'decoded' => '[CLS] test $ 1 R2 # 3 €4 £5 ¥6 [UNK] ₹8 ₱9 test [SEP]',
                ],
                'Currency with decimals' => [
                    'text' => TestStrings::CURRENCY_WITH_DECIMALS,
                    'tokens' => ['[CLS]', 'I', 'bought', 'an', 'apple', 'for', '$', '1', '.', '00', 'at', 'the', 'store', '.', '[SEP]'],
                    'ids' => [101, 146, 3306, 1126, 12075, 1111, 109, 122, 119, 3135, 1120, 1103, 2984, 119, 102],
                    'decoded' => '[CLS] I bought an apple for $ 1. 00 at the store. [SEP]',
                ],
                'Tilde normalization' => [
                    'text' => TestStrings::TILDE_NORMALIZATION,
                    'tokens' => ['[CLS]', 'weird', '[UNK]', 'edge', '[UNK]', 'case', '[SEP]'],
                    'ids' => [101, 6994, 100, 2652, 100, 1692, 102],
                    'decoded' => '[CLS] weird [UNK] edge [UNK] case [SEP]',
                ],
                'Chinese latin mixed' => [
                    'text' => TestStrings::CHINESE_LATIN_MIXED,
                    'tokens' => ['[CLS]', 'ah', '[UNK]', '[UNK]', 'z', '##z', '[SEP]'],
                    'ids' => [101, 18257, 100, 100, 195, 1584, 102],
                    'decoded' => '[CLS] ah [UNK] [UNK] zz [SEP]',
                ],
                'Simple with accents' => [
                    'text' => TestStrings::SIMPLE_WITH_ACCENTS,
                    'tokens' => ['[CLS]', 'H', '##é', '##llo', '[SEP]'],
                    'ids' => [101, 145, 2744, 6643, 102],
                    'decoded' => '[CLS] Héllo [SEP]',
                ],
            ],
            'Xenova/multilingual-e5-small' => [
                'Trailing space' => [
                    'text' => TestStrings::TRAILING_SPACE,
                    'tokens' => ['<s>', '▁trail', 'ing', '▁space', '▁', '</s>'],
                    'ids' => [0, 141037, 214, 32628, 6, 2],
                    'decoded' => '<s> trailing space </s>',
                ],
                'Ellipsis' => [
                    'text' => TestStrings::ELLIPSIS,
                    'tokens' => ['<s>', '▁you', '...', '▁', '</s>'],
                    'ids' => [0, 398, 27, 6, 2],
                    'decoded' => '<s> you... </s>',
                ],
                'Text with escape characters' => [
                    'text' => TestStrings::TEXT_WITH_ESCAPE_CHARACTERS,
                    'tokens' => ['<s>', '▁you', '...', '▁', '</s>'],
                    'ids' => [0, 398, 27, 6, 2],
                    'decoded' => '<s> you... </s>',
                ],
                'Text with escape characters 2' => [
                    'text' => TestStrings::TEXT_WITH_ESCAPE_CHARACTERS_2,
                    'tokens' => ['<s>', '▁you', '...', '▁you', '...', '▁', '</s>'],
                    'ids' => [0, 398, 27, 398, 27, 6, 2],
                    'decoded' => '<s> you... you... </s>',
                ],
                'Mixed case without accents' => [
                    'text' => TestStrings::MIXED_CASE_WITHOUT_ACCENTS,
                    'tokens' => ['<s>', '▁He', 'LL', 'o', '!', 'how', '▁Are', '▁yo', 'U', '?', '▁', '</s>'],
                    'ids' => [0, 1529, 23708, 31, 38, 47251, 15901, 3005, 1062, 32, 6, 2],
                    'decoded' => '<s> HeLLo!how Are yoU? </s>',
                ],
                'Mixed case with accents' => [
                    'text' => TestStrings::MIXED_CASE_WITH_ACCENTS,
                    'tokens' => ['<s>', '▁Hä', 'LL', 'o', '!', 'how', '▁Are', '▁yo', 'U', '?', '▁', '</s>'],
                    'ids' => [0, 28863, 23708, 31, 38, 47251, 15901, 3005, 1062, 32, 6, 2],
                    'decoded' => '<s> HäLLo!how Are yoU? </s>',
                ],
            ],
            'Xenova/herbert-large-cased' => [
                'Simple' => [
                    'text' => TestStrings::SIMPLE,
                    'tokens' => ['<s>', 'Ho', 'w</w>', 'are</w>', 'you</w>', 'do', 'ing</w>', '?</w>', '</s>'],
                    'ids' => [0, 5213, 1019, 25720, 20254, 2065, 5129, 1550, 2],
                    'decoded' => '<s>How are you doing? </s>',
                ],
                'Simple with punctuation' => [
                    'text' => TestStrings::SIMPLE_WITH_PUNCTUATION,
                    'tokens' => ['<s>', 'You</w>', 'sho', 'uld</w>', "'</w>", 've</w>', 'd', 'one</w>', 'this</w>', '</s>'],
                    'ids' => [0, 32795, 14924, 48273, 1571, 6647, 72, 2290, 48846, 2],
                    'decoded' => "<s>You should've done this </s>",
                ],
                'Text with numbers' => [
                    'text' => TestStrings::TEXT_WITH_NUMBERS,
                    'tokens' => ['<s>', 'The</w>', 'co', 'mpany</w>', 'was</w>', 'fo', 'un', 'de', 'd</w>', 'in</w>', '20', '16</w>', '.</w>', '</s>'],
                    'ids' => [0, 7117, 2406, 41449, 9873, 3435, 2195, 2101, 1038, 2651, 5646, 2555, 1899, 2],
                    'decoded' => '<s>The company was founded in 2016. </s>',
                ],
                'Punctuation' => [
                    'text' => TestStrings::PUNCTUATION,
                    'tokens' => ['<s>', 'A</w>', "'</w>", 'll</w>', '!</w>', '!</w>', 'to</w>', '?</w>', "'</w>", 'd</w>', "'</w>", "'</w>", 'd</w>', 'of</w>', ',</w>', 'can</w>', "'</w>", 't</w>', '.</w>', '</s>'],
                    'ids' => [0, 1012, 1571, 9396, 1725, 1725, 2063, 1550, 1571, 1038, 1571, 1571, 1038, 6595, 1947, 26794, 1571, 1026, 1899, 2],
                    'decoded' => "<s>A'll!! to?'d'' d of, can't. </s>",
                ],
                'Python code' => [
                    'text' => TestStrings::PYTHON_CODE,
                    'tokens' => ['<s>', 'de', 'f</w>', 'main</w>', '(</w>', ')</w>', ':</w>', 'pa', 'ss</w>', '</s>'],
                    'ids' => [0, 2101, 1050, 41851, 1341, 1940, 1335, 2083, 5357, 2],
                    'decoded' => '<s>def main ( ) : pass </s>',
                ],
                'Javascript code' => [
                    'text' => TestStrings::JAVASCRIPT_CODE,
                    'tokens' => ['<s>', 'let</w>', 'a</w>', '=</w>', 'ob', 'j</w>', '.</w>', 'to', 'S', 'tr', 'ing</w>', '(</w>', ')</w>', ';</w>', 'to', 'S', 'tr', 'ing</w>', '(</w>', ')</w>', ';</w>', '</s>'],
                    'ids' => [0, 11324, 1011, 1789, 2033, 1013, 1899, 2146, 55, 2518, 5129, 1341, 1940, 1195, 2146, 55, 2518, 5129, 1341, 1940, 1195, 2],
                    'decoded' => '<s>let a = obj. toString ( ) ; toString ( ) ; </s>',
                ],
                'Newlines' => [
                    'text' => TestStrings::NEWLINES,
                    'tokens' => ['<s>', 'T', 'his</w>', 'is</w>', 'a</w>', 'test</w>', '.</w>', '</s>'],
                    'ids' => [0, 56, 22855, 6869, 1011, 14825, 1899, 2],
                    'decoded' => '<s>This is a test. </s>',
                ],
                'Basic' => [
                    'text' => TestStrings::BASIC,
                    'tokens' => ['<s>', 'UN', 'wan', 't', 'é', 'd</w>', ',</w>', 'run', 'ning</w>', '</s>'],
                    'ids' => [0, 23029, 2688, 88, 163, 1038, 1947, 4980, 17843, 2],
                    'decoded' => '<s>UNwantéd, running </s>',
                ],
                'Control tokens' => [
                    'text' => TestStrings::CONTROL_TOKENS,
                    'tokens' => ['<s>', '123</w>', '</s>'],
                    'ids' => [0, 19049, 2],
                    'decoded' => '<s>123 </s>',
                ],
                'Hello world titlecase' => [
                    'text' => TestStrings::HELLO_WORLD_TITLECASE,
                    'tokens' => ['<s>', 'Hel', 'lo</w>', 'World</w>', '</s>'],
                    'ids' => [0, 12156, 6170, 21207, 2],
                    'decoded' => '<s>Hello World </s>',
                ],
                'Hello world lowercase' => [
                    'text' => TestStrings::HELLO_WORLD_LOWERCASE,
                    'tokens' => ['<s>', 'hel', 'lo</w>', 'world</w>', '</s>'],
                    'ids' => [0, 11526, 6170, 38188, 2],
                    'decoded' => '<s>hello world </s>',
                ],
                'Chinese only' => [
                    'text' => TestStrings::CHINESE_ONLY,
                    'tokens' => ['<s>', '<unk>', '<unk>', '<unk>', '<unk>', '<unk>', '是</w>', '</s>'],
                    'ids' => [0, 3, 3, 3, 3, 3, 1776, 2],
                    'decoded' => '<s><unk><unk><unk><unk><unk>是 </s>',
                ],
                'Leading space' => [
                    'text' => TestStrings::LEADING_SPACE,
                    'tokens' => ['<s>', 'le', 'ad', 'ing</w>', 'space</w>', '</s>'],
                    'ids' => [0, 2018, 2035, 5129, 46489, 2],
                    'decoded' => '<s>leading space </s>',
                ],
                'Trailing space' => [
                    'text' => TestStrings::TRAILING_SPACE,
                    'tokens' => ['<s>', 'tra', 'i', 'ling</w>', 'space</w>', '</s>'],
                    'ids' => [0, 2201, 77, 16342, 46489, 2],
                    'decoded' => '<s>trailing space </s>',
                ],
                'Double space' => [
                    'text' => TestStrings::DOUBLE_SPACE,
                    'tokens' => ['<s>', 'H', 'i</w>', 'Hel', 'lo</w>', '</s>'],
                    'ids' => [0, 44, 1009, 12156, 6170, 2],
                    'decoded' => '<s>Hi Hello </s>',
                ],
                'Currency' => [
                    'text' => TestStrings::CURRENCY,
                    'tokens' => ['<s>', 'test</w>', '$</w>', '1</w>', 'R', '2</w>', '#</w>', '3</w>', '€', '4</w>', '£', '5</w>', '<unk>', '6</w>', '<unk>', '7</w>', '<unk>', '8</w>', '<unk>', '9</w>', 'test</w>', '</s>'],
                    'ids' => [0, 14825, 1927, 1029, 54, 1025, 1393, 1034, 706, 1018, 100, 1008, 3, 1036, 3, 1030, 3, 1064, 3, 1017, 14825, 2],
                    'decoded' => '<s>test $ 1 R2 # 3 €4 £5 <unk>6 <unk>7 <unk>8 <unk>9 test </s>',
                ],
                'Currency with decimals' => [
                    'text' => TestStrings::CURRENCY_WITH_DECIMALS,
                    'tokens' => ['<s>', 'I</w>', 'bou', 'ght</w>', 'an</w>', 'ap', 'ple</w>', 'for</w>', '$</w>', '1</w>', '.</w>', '00</w>', 'at</w>', 'the</w>', 'st', 'ore</w>', '.</w>', '</s>'],
                    'ids' => [0, 1056, 13016, 15272, 2879, 10309, 20861, 15181, 1927, 1029, 1899, 2291, 4772, 6854, 1989, 24005, 1899, 2],
                    'decoded' => '<s>I bought an apple for $ 1. 00 at the store. </s>',
                ],
                'Ellipsis' => [
                    'text' => TestStrings::ELLIPSIS,
                    'tokens' => ['<s>', 'you</w>', '…</w>', '</s>'],
                    'ids' => [0, 20254, 1826, 2],
                    'decoded' => '<s>you … </s>',
                ],
                'Text with escape characters' => [
                    'text' => TestStrings::TEXT_WITH_ESCAPE_CHARACTERS,
                    'tokens' => ['<s>', 'you</w>', '…</w>', '</s>'],
                    'ids' => [0, 20254, 1826, 2],
                    'decoded' => '<s>you … </s>',
                ],
                'Text with escape characters 2' => [
                    'text' => TestStrings::TEXT_WITH_ESCAPE_CHARACTERS_2,
                    'tokens' => ['<s>', 'you</w>', '…</w>', 'you</w>', '…</w>', '</s>'],
                    'ids' => [0, 20254, 1826, 20254, 1826, 2],
                    'decoded' => '<s>you … you … </s>',
                ],
                'Tilde normalization' => [
                    'text' => TestStrings::TILDE_NORMALIZATION,
                    'tokens' => ['<s>', 'we', 'ir', 'd</w>', '<unk>', 'e', 'dge</w>', '<unk>', 'ca', 'se</w>', '</s>'],
                    'ids' => [0, 2149, 17435, 1038, 3, 73, 25801, 3, 3833, 4417, 2],
                    'decoded' => '<s>weird <unk>edge <unk>case </s>',
                ],
                'Spiece underscore' => [
                    'text' => TestStrings::SPIECE_UNDERSCORE,
                    'tokens' => ['<s>', '<unk>', 'T', 'his</w>', '<unk>', 'is</w>', '<unk>', 'a</w>', '<unk>', 'test</w>', '<unk>', '.</w>', '</s>'],
                    'ids' => [0, 3, 56, 22855, 3, 6869, 3, 1011, 3, 14825, 3, 1899, 2],
                    'decoded' => '<s><unk>This <unk>is <unk>a <unk>test <unk>. </s>',
                ],
                'Chinese latin mixed' => [
                    'text' => TestStrings::CHINESE_LATIN_MIXED,
                    'tokens' => ['<s>', 'a', 'h</w>', '<unk>', '<unk>', 'zz</w>', '</s>'],
                    'ids' => [0, 69, 1021, 3, 3, 49185, 2],
                    'decoded' => '<s>ah <unk><unk>zz </s>',
                ],
                'Simple with accents' => [
                    'text' => TestStrings::SIMPLE_WITH_ACCENTS,
                    'tokens' => ['<s>', 'H', 'é', 'l', 'lo</w>', '</s>'],
                    'ids' => [0, 44, 163, 80, 6170, 2],
                    'decoded' => '<s>Héllo </s>',
                ],
                'Mixed case without accents' => [
                    'text' => TestStrings::MIXED_CASE_WITHOUT_ACCENTS,
                    'tokens' => ['<s>', 'He', 'L', 'L', 'o</w>', '!</w>', 'ho', 'w</w>', 'Ar', 'e</w>', 'yo', 'U</w>', '?</w>', '</s>'],
                    'ids' => [0, 4596, 48, 48, 1007, 1725, 3145, 1019, 2921, 1015, 13908, 1041, 1550, 2],
                    'decoded' => '<s>HeLLo! how Are yoU? </s>',
                ],
                'Mixed case with accents' => [
                    'text' => TestStrings::MIXED_CASE_WITH_ACCENTS,
                    'tokens' => ['<s>', 'H', 'ä', 'L', 'L', 'o</w>', '!</w>', 'ho', 'w</w>', 'Ar', 'e</w>', 'yo', 'U</w>', '?</w>', '</s>'],
                    'ids' => [0, 44, 158, 48, 48, 1007, 1725, 3145, 1019, 2921, 1015, 13908, 1041, 1550, 2],
                    'decoded' => '<s>HäLLo! how Are yoU? </s>',
                ],
            ],
        ];
    }
}
