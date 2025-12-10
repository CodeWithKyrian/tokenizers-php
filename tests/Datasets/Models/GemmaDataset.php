<?php

declare(strict_types=1);

namespace Codewithkyrian\Tokenizers\Tests\Datasets\Models;

class GemmaDataset
{
    /**
     * Returns the dataset for Gemma models.
     *
     * @return array<string, array<string, array{text: string, tokens: string[], ids: int[], decoded: string}>>
     */
    public static function data(): array
    {
        return [
            'Xenova/gemma2-tokenizer' => [
                'Simple' => [
                    'text' => TestStrings::SIMPLE,
                    'tokens' => ['<bos>', 'How', '▁are', '▁you', '▁doing', '?'],
                    'ids' => [2, 2299, 708, 692, 3900, 235336],
                    'decoded' => '<bos>How are you doing?',
                ],
                'Simple with punctuation' => [
                    'text' => TestStrings::SIMPLE_WITH_PUNCTUATION,
                    'tokens' => ['<bos>', 'You', '▁should', "'", 've', '▁done', '▁this'],
                    'ids' => [2, 2045, 1412, 235303, 524, 3015, 736],
                    'decoded' => "<bos>You should've done this",
                ],
                'Numbers' => [
                    'text' => TestStrings::NUMBERS,
                    'tokens' => ['<bos>', '0', '1', '2', '3', '4', '5', '6', '7', '8', '9', '▁', '0', '▁', '1', '▁', '2', '▁', '3', '▁', '4', '▁', '5', '▁', '6', '▁', '7', '▁', '8', '▁', '9', '▁', '1', '0', '▁', '1', '0', '0', '▁', '1', '0', '0', '0'],
                    'ids' => [2, 235276, 235274, 235284, 235304, 235310, 235308, 235318, 235324, 235321, 235315, 235248, 235276, 235248, 235274, 235248, 235284, 235248, 235304, 235248, 235310, 235248, 235308, 235248, 235318, 235248, 235324, 235248, 235321, 235248, 235315, 235248, 235274, 235276, 235248, 235274, 235276, 235276, 235248, 235274, 235276, 235276, 235276],
                    'decoded' => '<bos>0123456789 0 1 2 3 4 5 6 7 8 9 10 100 1000',
                ],
                'Text with numbers' => [
                    'text' => TestStrings::TEXT_WITH_NUMBERS,
                    'tokens' => ['<bos>', 'The', '▁company', '▁was', '▁founded', '▁in', '▁', '2', '0', '1', '6', '.'],
                    'ids' => [2, 651, 3277, 729, 18942, 575, 235248, 235284, 235276, 235274, 235318, 235265],
                    'decoded' => '<bos>The company was founded in 2016.',
                ],
                'Punctuation' => [
                    'text' => TestStrings::PUNCTUATION,
                    'tokens' => ['<bos>', 'A', "\n", "'", 'll', '▁!!', 'to', "?'", 'd', "''", 'd', '▁of', ',', '▁can', "'", 't', '.'],
                    'ids' => [2, 235280, 108, 235303, 529, 9063, 511, 18016, 235258, 3404, 235258, 576, 235269, 798, 235303, 235251, 235265],
                    'decoded' => "<bos>A\n'll !!to?'d''d of, can't.",
                ],
                'Python code' => [
                    'text' => TestStrings::PYTHON_CODE,
                    'tokens' => ['<bos>', 'def', '▁main', '():', "\n", "\t", 'pass'],
                    'ids' => [2, 1293, 1872, 4409, 108, 226, 3095],
                    'decoded' => "<bos>def main():\n\tpass",
                ],
                'Javascript code' => [
                    'text' => TestStrings::JAVASCRIPT_CODE,
                    'tokens' => ['<bos>', 'let', '▁a', '▁=', '▁obj', '.', 'toString', '();', "\n", 'toString', '();'],
                    'ids' => [2, 1243, 476, 589, 6555, 235265, 7114, 821, 108, 7114, 821],
                    'decoded' => "<bos>let a = obj.toString();\ntoString();",
                ],
                'Newlines' => [
                    'text' => TestStrings::LLAMA_NEWLINES,
                    'tokens' => ['<bos>', 'ax', "\n", '####', "\n", 'boo'],
                    'ids' => [2, 1247, 108, 3308, 108, 31931],
                    'decoded' => "<bos>ax\n####\nboo",
                ],
                'Basic' => [
                    'text' => TestStrings::BASIC,
                    'tokens' => ['<bos>', 'UN', 'want', 'éd', ',', 'running'],
                    'ids' => [2, 2019, 29007, 45346, 235269, 23655],
                    'decoded' => "<bos>UNwant\u{00E9}d,running",
                ],
                'Control tokens' => [
                    'text' => TestStrings::CONTROL_TOKENS,
                    'tokens' => ['<bos>', '1', '<0x00>', '2', '�', '3'],
                    'ids' => [2, 235274, 217, 235284, 236193, 235304],
                    'decoded' => "<bos>1\u{0000}2\u{FFFD}3",
                ],
                'Hello world titlecase' => [
                    'text' => TestStrings::HELLO_WORLD_TITLECASE,
                    'tokens' => ['<bos>', 'Hello', '▁World'],
                    'ids' => [2, 4521, 3855],
                    'decoded' => '<bos>Hello World',
                ],
                'Hello world lowercase' => [
                    'text' => TestStrings::HELLO_WORLD_LOWERCASE,
                    'tokens' => ['<bos>', 'hello', '▁world'],
                    'ids' => [2, 17534, 2134],
                    'decoded' => '<bos>hello world',
                ],
                'Chinese only' => [
                    'text' => TestStrings::CHINESE_ONLY,
                    'tokens' => ['<bos>', '生活的', '真', '谛', '是'],
                    'ids' => [2, 122182, 235710, 245467, 235427],
                    'decoded' => '<bos>生活的真谛是',
                ],
                'Leading space' => [
                    'text' => TestStrings::LEADING_SPACE,
                    'tokens' => ['<bos>', '▁▁▁', 'leading', '▁space'],
                    'ids' => [2, 140, 26650, 3641],
                    'decoded' => '<bos>   leading space',
                ],
                'Trailing space' => [
                    'text' => TestStrings::TRAILING_SPACE,
                    'tokens' => ['<bos>', 'trailing', '▁space', '▁▁▁'],
                    'ids' => [2, 100504, 3641, 140],
                    'decoded' => '<bos>trailing space   ',
                ],
                'Double space' => [
                    'text' => TestStrings::DOUBLE_SPACE,
                    'tokens' => ['<bos>', 'Hi', '▁▁', 'Hello'],
                    'ids' => [2, 2151, 139, 4521],
                    'decoded' => '<bos>Hi  Hello',
                ],
                'Currency' => [
                    'text' => TestStrings::CURRENCY,
                    'tokens' => ['<bos>', 'test', '▁$', '1', '▁R', '2', '▁#', '3', '▁€', '4', '▁£', '5', '▁¥', '6', '▁', '₣', '7', '▁₹', '8', '▁', '₱', '9', '▁test'],
                    'ids' => [2, 2195, 697, 235274, 625, 235284, 1700, 235304, 8296, 235310, 5955, 235308, 74393, 235318, 235248, 252058, 235324, 56712, 235321, 235248, 243132, 235315, 2121],
                    'decoded' => '<bos>test $1 R2 #3 €4 £5 ¥6 ₣7 ₹8 ₱9 test',
                ],
                'Currency with decimals' => [
                    'text' => TestStrings::CURRENCY_WITH_DECIMALS,
                    'tokens' => ['<bos>', 'I', '▁bought', '▁an', '▁apple', '▁for', '▁$', '1', '.', '0', '0', '▁at', '▁the', '▁store', '.'],
                    'ids' => [2, 235285, 8989, 671, 15491, 604, 697, 235274, 235265, 235276, 235276, 696, 573, 4659, 235265],
                    'decoded' => '<bos>I bought an apple for $1.00 at the store.',
                ],
                'Ellipsis' => [
                    'text' => TestStrings::ELLIPSIS,
                    'tokens' => ['<bos>', 'you', '…', '▁▁'],
                    'ids' => [2, 4747, 235417, 139],
                    'decoded' => '<bos>you…  ',
                ],
                'Text with escape characters' => [
                    'text' => TestStrings::TEXT_WITH_ESCAPE_CHARACTERS,
                    'tokens' => ['<bos>', 'you', '…', "\u{a0}\u{a0}"],
                    'ids' => [2, 4747, 235417, 25445],
                    'decoded' => "<bos>you…\u{a0}\u{a0}",
                ],
                'Text with escape characters 2' => [
                    'text' => TestStrings::TEXT_WITH_ESCAPE_CHARACTERS_2,
                    'tokens' => ['<bos>', 'you', '…', "\u{a0}\u{a0}", 'you', '…', "\u{a0}\u{a0}"],
                    'ids' => [2, 4747, 235417, 25445, 4747, 235417, 25445],
                    'decoded' => "<bos>you…\u{a0}\u{a0}you…\u{a0}\u{a0}",
                ],
                'Tilde normalization' => [
                    'text' => TestStrings::TILDE_NORMALIZATION,
                    'tokens' => ['<bos>', 'weird', '▁～', '▁edge', '▁～', '▁case'],
                    'ids' => [2, 102422, 134012, 8541, 134012, 2270],
                    'decoded' => '<bos>weird ～ edge ～ case',
                ],
                'Spiece underscore' => [
                    'text' => TestStrings::SPIECE_UNDERSCORE,
                    'tokens' => ['<bos>', '▁This', '▁▁', 'is', '▁▁', 'a', '▁▁', 'test', '▁▁', '.'],
                    'ids' => [2, 1417, 139, 502, 139, 235250, 139, 2195, 139, 235265],
                    'decoded' => '<bos> This  is  a  test  .',
                ],
                'Popular emojis' => [
                    'text' => TestStrings::POPULAR_EMOJIS,
                    'tokens' => ['<bos>', '😂', '▁👍', '▁🤣', '▁😍', '▁😭', '▁🎉', '▁🙏', '▁😊', '▁🔥', '▁😁', '▁😅', '▁🤗', '▁😆', '▁👏', '▁❤️', '▁💜', '▁💚', '▁💗', '▁💙', '▁🖤', '▁😎', '▁👌', '▁🥳', '▁💪', '▁✨', '▁👉', '▁👀', '▁💯', '▁', '🎈', '▁', '🙈', '▁🙌', '▁💀', '▁👇', '▁👋', '▁✅', '▁', '🎁', '▁', '🌞', '▁🌸', '▁', '💰'],
                    'ids' => [2, 236471, 38104, 55937, 46434, 55605, 160588, 68226, 44416, 72373, 70636, 75298, 156808, 120433, 104492, 35373, 131674, 191384, 204903, 146773, 166620, 87949, 83860, 211978, 142816, 64726, 166368, 108892, 174882, 235248, 242431, 235248, 241259, 134540, 106918, 154601, 169692, 92641, 235248, 241227, 235248, 241971, 233958, 235248, 241034],
                    'decoded' => '<bos>😂 👍 🤣 😍 😭 🎉 🙏 😊 🔥 😁 😅 🤗 😆 👏 ❤️ 💜 💚 💗 💙 🖤 😎 👌 🥳 💪 ✨ 👉 👀 💯 🎈 🙈 🙌 💀 👇 👋 ✅ 🎁 🌞 🌸 💰',
                ],
                'Multibyte emojis' => [
                    'text' => TestStrings::MULTIBYTE_EMOJIS,
                    'tokens' => ['<bos>', '✨', '▁🤗', '▁', '👁', '️', '▁', '👱', '🏻', '▁', '🕵', '‍♂️', '▁', '🧙', '🏻', '‍♂', '▁', '👨', '🏻', '‍', '🌾', '▁', '🧑', '‍', '🤝', '‍', '🧑', '▁', '👩', '‍', '❤', '‍', '💋', '‍', '👨', '▁', '👩', '‍', '👩', '‍', '👧', '‍', '👦', '▁', '🧑', '🏻', '‍', '🤝', '‍', '🧑', '🏻', '▁', '🏴', "\u{E0067}", "\u{E0062}", "\u{E0065}", "\u{E006E}", "\u{E0067}", "\u{E007F}", '▁', '👨', '🏻', '‍', '❤️', '‍', '💋', '‍', '👨', '🏼'],
                    'ids' => [2, 236309, 156808, 235248, 241666, 235969, 235248, 247216, 237933, 235248, 246522, 68399, 235248, 246422, 237933, 63233, 235248, 241568, 237933, 235879, 244448, 235248, 243634, 235879, 241668, 235879, 243634, 235248, 241355, 235879, 236457, 235879, 240887, 235879, 241568, 235248, 241355, 235879, 241355, 235879, 244355, 235879, 244670, 235248, 243634, 237933, 235879, 241668, 235879, 243634, 237933, 235248, 244443, 246738, 247704, 250142, 250123, 246738, 247662, 235248, 241568, 237933, 235879, 16176, 235879, 240887, 235879, 241568, 238683],
                    'decoded' => '<bos>✨ 🤗 👁️ 👱🏻 🕵‍♂️ 🧙🏻‍♂ 👨🏻‍🌾 🧑‍🤝‍🧑 👩‍❤‍💋‍👨 👩‍👩‍👧‍👦 🧑🏻‍🤝‍🧑🏻 🏴󠁧󠁢󠁥󠁮󠁧󠁿 👨🏻‍❤️‍💋‍👨🏼',
                ],
                'BPE scores priority 1' => [
                    'text' => TestStrings::LLAMA_BPE_SCORES_PRIORITY_1,
                    'tokens' => ['<bos>', 'grab', 'bed'],
                    'ids' => [2, 59031, 2907],
                    'decoded' => '<bos>grabbed',
                ],
                'BPE scores priority 2' => [
                    'text' => TestStrings::LLAMA_BPE_SCORES_PRIORITY_2,
                    'tokens' => ['<bos>', '▁grabbed'],
                    'ids' => [2, 41939],
                    'decoded' => '<bos> grabbed',
                ],
                'BPE scores priority 3' => [
                    'text' => TestStrings::LLAMA_BPE_SCORES_PRIORITY_3,
                    'tokens' => ['<bos>', '▁▁▁▁▁▁▁▁▁▁▁', 'grab', 'bed'],
                    'ids' => [2, 148, 59031, 2907],
                    'decoded' => '<bos>           grabbed',
                ],
                'Newline' => [
                    'text' => TestStrings::LLAMA_NEWLINE,
                    'tokens' => ['<bos>', "\n"],
                    'ids' => [2, 108],
                    'decoded' => "<bos>\n",
                ],
                'Newline with leading space' => [
                    'text' => TestStrings::LLAMA_NEWLINE_WITH_LEADING_SPACE,
                    'tokens' => ['<bos>', '▁', "\n"],
                    'ids' => [2, 235248, 108],
                    'decoded' => "<bos> \n",
                ],
                'Tabs' => [
                    'text' => TestStrings::LLAMA_TABS,
                    'tokens' => ['<bos>', "\t", 'tabs', "\t\t\t\t", 'out', '▁here'],
                    'ids' => [2, 226, 31973, 255971, 745, 1517],
                    'decoded' => "<bos>\ttabs\t\t\t\tout here",
                ],
                'Newline and tab' => [
                    'text' => TestStrings::LLAMA_NEWLINE_AND_TAB,
                    'tokens' => ['<bos>', "\n", "\t", "\n"],
                    'ids' => [2, 108, 226, 108],
                    'decoded' => "<bos>\n\t\n",
                ],
                'Chinese letter' => [
                    'text' => TestStrings::LLAMA_CHINESE_LETTER,
                    'tokens' => ['<bos>', '镇'],
                    'ids' => [2, 237796],
                    'decoded' => '<bos>镇',
                ],
                'Emojis 1' => [
                    'text' => TestStrings::LLAMA_EMOJIS_1,
                    'tokens' => ['<bos>', '🦙'],
                    'ids' => [2, 250645],
                    'decoded' => '<bos>🦙',
                ],
                'Emojis 2' => [
                    'text' => TestStrings::LLAMA_EMOJIS_2,
                    'tokens' => ['<bos>', '🦙', '<0xEA>', '<0x99>', '<0x8A>'],
                    'ids' => [2, 250645, 451, 370, 355],
                    'decoded' => '<bos>🦙Ꙋ',
                ],
                'Emojis 3' => [
                    'text' => TestStrings::LLAMA_EMOJIS_3,
                    'tokens' => ['<bos>', '<0xEA>', '<0x99>', '<0x8A>', '🦙'],
                    'ids' => [2, 451, 370, 355, 250645],
                    'decoded' => '<bos>Ꙋ🦙',
                ],
                'Paragraph' => [
                    'text' => TestStrings::LLAMA_PARAGRAPH,
                    'tokens' => ['<bos>', 'The', '▁llama', '▁(/', 'ˈ', 'l', 'ɑ', 'ː', 'mə', '/;', '▁', '🦙', 'Spanish', '▁pronunciation', ':', '▁[', 'ˈ', 'ʎ', 'ama', '])', '▁(', 'Lama', '▁g', 'lama', ')', '▁is', '▁a', '▁domesticated', '▁South', '▁American', '▁came', 'lid', ',', '▁widely', '▁used', '▁as', '▁a', '▁meat', '▁and', '▁pack', '▁animal', '▁by', '▁Andean', '▁cultures', '▁since', '▁the', '▁Pre', '-', 'Columb', 'ian', '▁era', '.', '▁Lla', 'mas', '▁are', '▁social', '▁animals', '▁and', '▁live', '▁with', '▁others', '▁as', '▁a', '▁herd', '.', '▁Their', '▁wool', '▁is', '▁soft', '▁and', '▁contains', '▁only', '▁a', '▁small', '▁amount', '▁of', '▁lan', 'olin', '.[', '2', ']', '▁Lla', 'mas', '▁can', '▁learn', '▁simple', '▁tasks', '▁after', '▁a', '▁few', '▁repetitions', '.', '▁When', '▁using', '▁a', '▁pack', ',', '▁they', '▁can', '▁carry', '▁about', '▁', '2', '5', '▁to', '▁', '3', '0', '%', '▁of', '▁their', '▁body', '▁weight', '▁for', '▁', '8', '▁to', '▁', '1', '3', '▁km', '▁(', '5', '–', '8', '▁miles', ').[', '3', ']', '▁The', '▁name', '▁llama', '▁(', 'in', '▁the', '▁past', '▁also', '▁spelled', '▁"', 'lama', '"', '▁or', '▁"', 'g', 'lama', '")', '▁was', '▁adopted', '▁by', '▁European', '▁settlers', '▁from', '▁native', '▁Peru', 'vi', 'ans', '.[', '4', ']', '▁The', '▁ancestors', '▁of', '▁llamas', '▁are', '▁thought', '▁to', '▁have', '▁originated', '▁from', '▁the', '▁Great', '▁Plains', '▁of', '▁North', '▁America', '▁about', '▁', '4', '0', '▁million', '▁years', '▁ago', ',', '▁and', '▁subsequently', '▁migrated', '▁to', '▁South', '▁America', '▁about', '▁three', '▁million', '▁years', '▁ago', '▁during', '▁the', '▁Great', '▁American', '▁Interchange', '.', '▁By', '▁the', '▁end', '▁of', '▁the', '▁last', '▁ice', '▁age', '▁(', '1', '0', ',', '0', '0', '0', '–', '1', '2', ',', '0', '0', '0', '▁years', '▁ago', '),', '▁came', 'lids', '▁were', '▁extinct', '▁in', '▁North', '▁America', '.[', '3', ']', '▁As', '▁of', '▁', '2', '0', '0', '7', ',', '▁there', '▁were', '▁over', '▁seven', '▁million', '▁llamas', '▁and', '▁al', 'pac', 'as', '▁in', '▁South', '▁America', '▁and', '▁over', '▁', '1', '5', '8', ',', '0', '0', '0', '▁llamas', '▁and', '▁', '1', '0', '0', ',', '0', '0', '0', '<0xEA>', '<0x99>', '<0x8A>', '🦙', '▁al', 'pac', 'as', ',', '▁descended', '▁from', '▁progen', 'itors', '▁imported', '▁late', '▁in', '▁the', '▁', '2', '0', 'th', '▁century', ',', '▁in', '▁the', '▁United', '▁States', '▁and', '▁Canada', '.[', '5', ']', '▁In', '▁A', 'ym', 'ara', '▁mythology', ',', '▁llamas', '▁are', '▁important', '▁beings', '.', '▁The', '▁Heavenly', '▁Llama', '▁is', '▁said', '▁to', '▁drink', '▁water', '▁from', '▁the', '▁ocean', '▁and', '▁urin', 'ates', '▁as', '▁it', '▁rains', '.[', '6', ']', '▁According', '▁to', '▁A', 'ym', 'ara', '▁es', 'ch', 'atology', ',', '▁llamas', '▁will', '▁return', '▁to', '▁the', '▁water', '▁springs', '▁and', '▁lagoons', '▁where', '▁they', '▁come', '▁from', '▁at', '▁the', '▁end', '▁of', '▁time', '.[', '6', ']'],
                    'ids' => [2, 651, 19001, 101949, 239229, 235257, 240527, 240342, 128631, 102430, 235248, 250645, 51590, 74569, 235292, 892, 239229, 246752, 2867, 3013, 591, 221520, 583, 10450, 235275, 603, 476, 183304, 4316, 3725, 3392, 3353, 235269, 16714, 1671, 685, 476, 11827, 578, 3386, 8205, 731, 207552, 24541, 2754, 573, 2769, 235290, 222963, 1282, 6063, 235265, 172809, 2616, 708, 3127, 8398, 578, 3685, 675, 3588, 685, 476, 48010, 235265, 10368, 23834, 603, 4072, 578, 7744, 1297, 476, 2301, 3619, 576, 7607, 28424, 19047, 235284, 235307, 172809, 2616, 798, 3918, 3890, 13333, 1452, 476, 2619, 126286, 235265, 3194, 2177, 476, 3386, 235269, 984, 798, 6383, 1105, 235248, 235284, 235308, 577, 235248, 235304, 235276, 235358, 576, 1024, 2971, 5171, 604, 235248, 235321, 577, 235248, 235274, 235304, 5821, 591, 235308, 235389, 235321, 7112, 232524, 235304, 235307, 714, 1503, 19001, 591, 473, 573, 3433, 1170, 73003, 664, 10450, 235281, 689, 664, 235264, 10450, 1388, 729, 13861, 731, 7737, 57710, 774, 11634, 30160, 893, 779, 19047, 235310, 235307, 714, 44106, 576, 129953, 708, 3421, 577, 791, 52102, 774, 573, 6553, 55118, 576, 4612, 5783, 1105, 235248, 235310, 235276, 4416, 1658, 3958, 235269, 578, 27956, 106398, 577, 4316, 5783, 1105, 2149, 4416, 1658, 3958, 2290, 573, 6553, 3725, 193879, 235265, 3339, 573, 1580, 576, 573, 2001, 8357, 3911, 591, 235274, 235276, 235269, 235276, 235276, 235276, 235389, 235274, 235284, 235269, 235276, 235276, 235276, 1658, 3958, 823, 3392, 41253, 1049, 78561, 575, 4612, 5783, 19047, 235304, 235307, 1877, 576, 235248, 235284, 235276, 235276, 235324, 235269, 1104, 1049, 1163, 6861, 4416, 129953, 578, 717, 23337, 508, 575, 4316, 5783, 578, 1163, 235248, 235274, 235308, 235321, 235269, 235276, 235276, 235276, 129953, 578, 235248, 235274, 235276, 235276, 235269, 235276, 235276, 235276, 451, 370, 355, 250645, 717, 23337, 508, 235269, 64700, 774, 66279, 15517, 29271, 5245, 575, 573, 235248, 235284, 235276, 489, 7861, 235269, 575, 573, 3520, 3858, 578, 6591, 19047, 235308, 235307, 878, 586, 3985, 1610, 76701, 235269, 129953, 708, 2845, 27290, 235265, 714, 89830, 170669, 603, 1180, 577, 7182, 2003, 774, 573, 13940, 578, 111204, 1204, 685, 665, 50852, 19047, 235318, 235307, 11926, 577, 586, 3985, 1610, 875, 530, 92764, 235269, 129953, 877, 2203, 577, 573, 2003, 31104, 578, 221493, 1570, 984, 2063, 774, 696, 573, 1580, 576, 1069, 19047, 235318, 235307],
                    'decoded' => '<bos>The llama (/ˈlɑːmə/; 🦙Spanish pronunciation: [ˈʎama]) (Lama glama) is a domesticated South American camelid, widely used as a meat and pack animal by Andean cultures since the Pre-Columbian era. Llamas are social animals and live with others as a herd. Their wool is soft and contains only a small amount of lanolin.[2] Llamas can learn simple tasks after a few repetitions. When using a pack, they can carry about 25 to 30% of their body weight for 8 to 13 km (5–8 miles).[3] The name llama (in the past also spelled "lama" or "glama") was adopted by European settlers from native Peruvians.[4] The ancestors of llamas are thought to have originated from the Great Plains of North America about 40 million years ago, and subsequently migrated to South America about three million years ago during the Great American Interchange. By the end of the last ice age (10,000–12,000 years ago), camelids were extinct in North America.[3] As of 2007, there were over seven million llamas and alpacas in South America and over 158,000 llamas and 100,000Ꙋ🦙 alpacas, descended from progenitors imported late in the 20th century, in the United States and Canada.[5] In Aymara mythology, llamas are important beings. The Heavenly Llama is said to drink water from the ocean and urinates as it rains.[6] According to Aymara eschatology, llamas will return to the water springs and lagoons where they come from at the end of time.[6]',
                ],
            ],
        ];
    }
}
