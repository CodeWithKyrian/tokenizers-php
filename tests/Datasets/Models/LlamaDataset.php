<?php

declare(strict_types=1);

namespace Codewithkyrian\Tokenizers\Tests\Datasets\Models;

class LlamaDataset
{
    /**
     * Datasets for LLaMA-family tokenizers.
     *
     * @return array<string, array<string, array{text: string, tokens: string[], ids: int[], decoded: string}>>
     */
    public static function data(): array
    {
        return [
            'Xenova/llama3-tokenizer' => [
                'Simple' => [
                    'text' => TestStrings::SIMPLE,
                    'tokens' => ['How', 'Ġare', 'Ġyou', 'Ġdoing', '?'],
                    'ids' => [4438, 527, 499, 3815, 30],
                    'decoded' => 'How are you doing?',
                ],
                'Simple with punctuation' => [
                    'text' => TestStrings::SIMPLE_WITH_PUNCTUATION,
                    'tokens' => ['You', 'Ġshould', "'ve", 'Ġdone', 'Ġthis'],
                    'ids' => [2675, 1288, 3077, 2884, 420],
                    'decoded' => "You should've done this",
                ],
                'Numbers' => [
                    'text' => TestStrings::NUMBERS,
                    'tokens' => ['012', '345', '678', '9', 'Ġ', '0', 'Ġ', '1', 'Ġ', '2', 'Ġ', '3', 'Ġ', '4', 'Ġ', '5', 'Ġ', '6', 'Ġ', '7', 'Ġ', '8', 'Ġ', '9', 'Ġ', '10', 'Ġ', '100', 'Ġ', '100', '0'],
                    'ids' => [11531, 12901, 17458, 24, 220, 15, 220, 16, 220, 17, 220, 18, 220, 19, 220, 20, 220, 21, 220, 22, 220, 23, 220, 24, 220, 605, 220, 1041, 220, 1041, 15],
                    'decoded' => '0123456789 0 1 2 3 4 5 6 7 8 9 10 100 1000',
                ],
                'Text with numbers' => [
                    'text' => TestStrings::TEXT_WITH_NUMBERS,
                    'tokens' => ['The', 'Ġcompany', 'Ġwas', 'Ġfounded', 'Ġin', 'Ġ', '201', '6', '.'],
                    'ids' => [791, 2883, 574, 18538, 304, 220, 679, 21, 13],
                    'decoded' => 'The company was founded in 2016.',
                ],
                'Punctuation' => [
                    'text' => TestStrings::PUNCTUATION,
                    'tokens' => ['A', 'Ċ', "'ll", 'Ġ!!', 'to', "?'", 'd', "''", 'd', 'Ġof', ',', 'Ġcan', "'t", '.'],
                    'ids' => [32, 198, 3358, 11261, 998, 20837, 67, 4708, 67, 315, 11, 649, 956, 13],
                    'decoded' => "A\n'll!!to?'d''d of, can't.",
                ],
                'Python code' => [
                    'text' => TestStrings::PYTHON_CODE,
                    'tokens' => ['def', 'Ġmain', '():Ċ', 'ĉpass'],
                    'ids' => [755, 1925, 4019, 42531],
                    'decoded' => "def main():\n\tpass",
                ],
                'Javascript code' => [
                    'text' => TestStrings::JAVASCRIPT_CODE,
                    'tokens' => ['let', 'Ġa', 'Ġ=', 'Ġobj', '.toString', '();Ċ', 'toString', '();'],
                    'ids' => [1169, 264, 284, 2909, 5180, 545, 6712, 2178],
                    'decoded' => "let a = obj.toString();\ntoString();",
                ],
                'Newlines' => [
                    'text' => TestStrings::LLAMA_NEWLINES,
                    'tokens' => ['ax', 'Ċ', '####Ċ', 'boo'],
                    'ids' => [710, 198, 71050, 34093],
                    'decoded' => "ax\n####\nboo",
                ],
                'Basic' => [
                    'text' => TestStrings::BASIC,
                    'tokens' => ['UN', 'want', 'Ã©d', ',', 'running'],
                    'ids' => [1899, 53757, 15433, 11, 28272],
                    'decoded' => 'UNwantéd,running',
                ],
                'Control tokens' => [
                    'text' => TestStrings::CONTROL_TOKENS,
                    'tokens' => ['1', 'Ā', '2', 'ï¿½', '3'],
                    'ids' => [16, 188, 17, 5809, 18],
                    'decoded' => "1\u{0000}2\u{fffd}3",
                ],
                'Hello world titlecase' => [
                    'text' => TestStrings::HELLO_WORLD_TITLECASE,
                    'tokens' => ['Hello', 'ĠWorld'],
                    'ids' => [9906, 4435],
                    'decoded' => 'Hello World',
                ],
                'Hello world lowercase' => [
                    'text' => TestStrings::HELLO_WORLD_LOWERCASE,
                    'tokens' => ['hello', 'Ġworld'],
                    'ids' => [15339, 1917],
                    'decoded' => 'hello world',
                ],
                'Chinese only' => [
                    'text' => TestStrings::CHINESE_ONLY,
                    'tokens' => ['çĶŁæ´»', 'çļĦ', 'çľŁ', 'è°', 'Ľ', 'æĺ¯'],
                    'ids' => [104654, 9554, 89151, 39013, 249, 21043],
                    'decoded' => '生活的真谛是',
                ],
                'Leading space' => [
                    'text' => TestStrings::LEADING_SPACE,
                    'tokens' => ['ĠĠ', 'Ġleading', 'Ġspace'],
                    'ids' => [256, 6522, 3634],
                    'decoded' => '   leading space',
                ],
                'Trailing space' => [
                    'text' => TestStrings::TRAILING_SPACE,
                    'tokens' => ['tr', 'ailing', 'Ġspace', 'ĠĠĠ'],
                    'ids' => [376, 14612, 3634, 262],
                    'decoded' => 'trailing space   ',
                ],
                'Double space' => [
                    'text' => TestStrings::DOUBLE_SPACE,
                    'tokens' => ['Hi', 'Ġ', 'ĠHello'],
                    'ids' => [13347, 220, 22691],
                    'decoded' => 'Hi  Hello',
                ],
                'Currency' => [
                    'text' => TestStrings::CURRENCY,
                    'tokens' => ['test', 'Ġ$', '1', 'ĠR', '2', 'Ġ#', '3', 'ĠâĤ¬', '4', 'ĠÂ£', '5', 'ĠÂ¥', '6', 'ĠâĤ', '£', '7', 'ĠâĤ¹', '8', 'ĠâĤ', '±', '9', 'Ġtest'],
                    'ids' => [1985, 400, 16, 432, 17, 674, 18, 13281, 19, 7083, 20, 72588, 21, 113384, 96, 22, 90891, 23, 113384, 109, 24, 1296],
                    'decoded' => 'test $1 R2 #3 €4 £5 ¥6 ₣7 ₹8 ₱9 test',
                ],
                'Currency with decimals' => [
                    'text' => TestStrings::CURRENCY_WITH_DECIMALS,
                    'tokens' => ['I', 'Ġbought', 'Ġan', 'Ġapple', 'Ġfor', 'Ġ$', '1', '.', '00', 'Ġat', 'Ġthe', 'Ġstore', '.'],
                    'ids' => [40, 11021, 459, 24149, 369, 400, 16, 13, 410, 520, 279, 3637, 13],
                    'decoded' => 'I bought an apple for $1.00 at the store.',
                ],
                'Ellipsis' => [
                    'text' => TestStrings::ELLIPSIS,
                    'tokens' => ['you', 'âĢ¦', 'ĠĠ'],
                    'ids' => [9514, 1981, 256],
                    'decoded' => 'you…  ',
                ],
                'Text with escape characters' => [
                    'text' => TestStrings::TEXT_WITH_ESCAPE_CHARACTERS,
                    'tokens' => ['you', 'âĢ¦', 'ÂłÂł'],
                    'ids' => [9514, 1981, 9421],
                    'decoded' => "you…\u{00a0}\u{00a0}",
                ],
                'Text with escape characters 2' => [
                    'text' => TestStrings::TEXT_WITH_ESCAPE_CHARACTERS_2,
                    'tokens' => ['you', 'âĢ¦', 'Âł', 'Âł', 'you', 'âĢ¦', 'ÂłÂł'],
                    'ids' => [9514, 1981, 4194, 4194, 9514, 1981, 9421],
                    'decoded' => "you…\u{00a0}\u{00a0}you…\u{00a0}\u{00a0}",
                ],
                'Tilde normalization' => [
                    'text' => TestStrings::TILDE_NORMALIZATION,
                    'tokens' => ['we', 'ird', 'Ġï½ŀ', 'Ġedge', 'Ġï½ŀ', 'Ġcase'],
                    'ids' => [906, 2668, 111942, 6964, 111942, 1162],
                    'decoded' => 'weird ～ edge ～ case',
                ],
                'Spiece underscore' => [
                    'text' => TestStrings::SPIECE_UNDERSCORE,
                    'tokens' => ['âĸ', 'ģ', 'This', 'Ġâĸ', 'ģ', 'is', 'Ġâĸ', 'ģ', 'a', 'Ġâĸ', 'ģ', 'test', 'Ġâĸ', 'ģ', '.'],
                    'ids' => [10634, 223, 2028, 14860, 223, 285, 14860, 223, 64, 14860, 223, 1985, 14860, 223, 13],
                    'decoded' => '▁This ▁is ▁a ▁test ▁.',
                ],
                'Popular emojis' => [
                    'text' => TestStrings::POPULAR_EMOJIS,
                    'tokens' => ['ðŁĺ', 'Ĥ', 'ĠðŁĳ', 'į', 'ĠðŁ', '¤', '£', 'ĠðŁĺ', 'į', 'ĠðŁĺ', 'Ń', 'ĠðŁ', 'İ', 'ī', 'ĠðŁ', 'Ļ', 'ı', 'ĠðŁĺ', 'Ĭ', 'ĠðŁĶ', '¥', 'ĠðŁĺ', 'ģ', 'ĠðŁĺ', 'ħ', 'ĠðŁ', '¤', 'Ĺ', 'ĠðŁĺ', 'Ĩ', 'ĠðŁĳ', 'ı', 'ĠâĿ¤', 'ï¸ı', 'ĠðŁĴ', 'ľ', 'ĠðŁĴ', 'ļ', 'ĠðŁĴ', 'Ĺ', 'ĠðŁĴ', 'Ļ', 'ĠðŁ', 'ĸ', '¤', 'ĠðŁĺ', 'İ', 'ĠðŁĳ', 'Į', 'ĠðŁ', '¥', '³', 'ĠðŁĴ', 'ª', 'Ġâľ', '¨', 'ĠðŁĳ', 'ī', 'ĠðŁĳ', 'Ģ', 'ĠðŁĴ', '¯', 'ĠðŁ', 'İ', 'Ī', 'ĠðŁ', 'Ļ', 'Ī', 'ĠðŁ', 'Ļ', 'Į', 'ĠðŁĴ', 'Ģ', 'ĠðŁĳ', 'ĩ', 'ĠðŁĳ', 'ĭ', 'Ġâľ', 'ħ', 'ĠðŁ', 'İ', 'ģ', 'ĠðŁ', 'Į', 'ŀ', 'ĠðŁ', 'Į', '¸', 'ĠðŁĴ', '°'],
                    'ids' => [76460, 224, 62904, 235, 11410, 97, 96, 27623, 235, 27623, 255, 11410, 236, 231, 11410, 247, 237, 27623, 232, 96169, 98, 27623, 223, 27623, 227, 11410, 97, 245, 27623, 228, 62904, 237, 71570, 31643, 64139, 250, 64139, 248, 64139, 245, 64139, 247, 11410, 244, 97, 27623, 236, 62904, 234, 11410, 98, 111, 64139, 103, 26602, 101, 62904, 231, 62904, 222, 64139, 107, 11410, 236, 230, 11410, 247, 230, 11410, 247, 234, 64139, 222, 62904, 229, 62904, 233, 26602, 227, 11410, 236, 223, 11410, 234, 252, 11410, 234, 116, 64139, 108],
                    'decoded' => '😂 👍 🤣 😍 😭 🎉 🙏 😊 🔥 😁 😅 🤗 😆 👏 ❤️ 💜 💚 💗 💙 🖤 😎 👌 🥳 💪 ✨ 👉 👀 💯 🎈 🙈 🙌 💀 👇 👋 ✅ 🎁 🌞 🌸 💰',
                ],
                'Multibyte emojis' => [
                    'text' => TestStrings::MULTIBYTE_EMOJIS,
                    'tokens' => ['âľ', '¨', 'ĠðŁ', '¤', 'Ĺ', 'ĠðŁĳ', 'ģ', 'ï¸ı', 'ĠðŁĳ', '±', 'ðŁ', 'ı', '»', 'ĠðŁ', 'ķ', 'µ', 'âĢį', 'âĻ', 'Ĥ', 'ï¸ı', 'ĠðŁ', '§', 'Ļ', 'ðŁ', 'ı', '»', 'âĢį', 'âĻ', 'Ĥ', 'ĠðŁĳ', '¨', 'ðŁ', 'ı', '»', 'âĢį', 'ðŁ', 'Į', '¾', 'ĠðŁ', '§', 'ĳ', 'âĢį', 'ðŁ', '¤', 'Ŀ', 'âĢį', 'ðŁ', '§', 'ĳ', 'ĠðŁĳ', '©', 'âĢį', 'âĿ¤', 'âĢį', 'ðŁĴ', 'ĭ', 'âĢį', 'ðŁ', 'ĳ', '¨', 'ĠðŁĳ', '©', 'âĢį', 'ðŁ', 'ĳ', '©', 'âĢį', 'ðŁ', 'ĳ', '§', 'âĢį', 'ðŁ', 'ĳ', '¦', 'ĠðŁ', '§', 'ĳ', 'ðŁ', 'ı', '»', 'âĢį', 'ðŁ', '¤', 'Ŀ', 'âĢį', 'ðŁ', '§', 'ĳ', 'ðŁ', 'ı', '»', 'ĠðŁ', 'ı', '´', 'ó', 'łģ', '§', 'ó', 'łģ', '¢', 'ó', 'łģ', '¥', 'ó', 'łģ', '®', 'ó', 'łģ', '§', 'ó', 'łģ', '¿', 'ĠðŁĳ', '¨', 'ðŁ', 'ı', '»', 'âĢį', 'âĿ¤', 'ï¸ı', 'âĢį', 'ðŁĴ', 'ĭ', 'âĢį', 'ðŁ', 'ĳ', '¨', 'ðŁ', 'ı', '¼'],
                    'ids' => [38798, 101, 11410, 97, 245, 62904, 223, 31643, 62904, 109, 9468, 237, 119, 11410, 243, 113, 102470, 17245, 224, 31643, 11410, 100, 247, 9468, 237, 119, 102470, 17245, 224, 62904, 101, 9468, 237, 119, 102470, 9468, 234, 122, 11410, 100, 239, 102470, 9468, 97, 251, 102470, 9468, 100, 239, 62904, 102, 102470, 121643, 102470, 93273, 233, 102470, 9468, 239, 101, 62904, 102, 102470, 9468, 239, 102, 102470, 9468, 239, 100, 102470, 9468, 239, 99, 11410, 100, 239, 9468, 237, 119, 102470, 9468, 97, 251, 102470, 9468, 100, 239, 9468, 237, 119, 11410, 237, 112, 175, 16050, 100, 175, 16050, 95, 175, 16050, 98, 175, 16050, 106, 175, 16050, 100, 175, 16050, 123, 62904, 101, 9468, 237, 119, 102470, 121643, 31643, 102470, 93273, 233, 102470, 9468, 239, 101, 9468, 237, 120],
                    'decoded' => '✨ 🤗 👁️ 👱🏻 🕵‍♂️ 🧙🏻‍♂ 👨🏻‍🌾 🧑‍🤝‍🧑 👩‍❤‍💋‍👨 👩‍👩‍👧‍👦 🧑🏻‍🤝‍🧑🏻 🏴󠁧󠁢󠁥󠁮󠁧󠁿 👨🏻‍❤️‍💋‍👨🏼',
                ],
                'BPE scores priority 1' => [
                    'text' => TestStrings::LLAMA_BPE_SCORES_PRIORITY_1,
                    'tokens' => ['grab', 'bed'],
                    'ids' => [59312, 2788],
                    'decoded' => 'grabbed',
                ],
                'BPE scores priority 2' => [
                    'text' => TestStrings::LLAMA_BPE_SCORES_PRIORITY_2,
                    'tokens' => ['Ġgrabbed'],
                    'ids' => [30418],
                    'decoded' => ' grabbed',
                ],
                'BPE scores priority 3' => [
                    'text' => TestStrings::LLAMA_BPE_SCORES_PRIORITY_3,
                    'tokens' => ['ĠĠĠĠĠĠĠĠĠĠ', 'Ġgrabbed'],
                    'ids' => [1881, 30418],
                    'decoded' => '           grabbed',
                ],
                'Newline' => [
                    'text' => TestStrings::LLAMA_NEWLINE,
                    'tokens' => ['Ċ'],
                    'ids' => [198],
                    'decoded' => "\n",
                ],
                'Newline with leading space' => [
                    'text' => TestStrings::LLAMA_NEWLINE_WITH_LEADING_SPACE,
                    'tokens' => ['ĠĊ'],
                    'ids' => [720],
                    'decoded' => " \n",
                ],
                'Tabs' => [
                    'text' => TestStrings::LLAMA_TABS,
                    'tokens' => ['ĉt', 'abs', 'ĉĉĉ', 'ĉout', 'Ġhere'],
                    'ids' => [3324, 3518, 573, 14294, 1618],
                    'decoded' => "\ttabs\t\t\t\tout here",
                ],
                'Newline and tab' => [
                    'text' => TestStrings::LLAMA_NEWLINE_AND_TAB,
                    'tokens' => ['ĊĉĊ'],
                    'ids' => [18108],
                    'decoded' => "\n\t\n",
                ],
                'Chinese letter' => [
                    'text' => TestStrings::LLAMA_CHINESE_LETTER,
                    'tokens' => ['éķĩ'],
                    'ids' => [104643],
                    'decoded' => '镇',
                ],
                'Emojis 1' => [
                    'text' => TestStrings::LLAMA_EMOJIS_1,
                    'tokens' => ['ðŁ', '¦', 'Ļ'],
                    'ids' => [9468, 99, 247],
                    'decoded' => '🦙',
                ],
                'Emojis 2' => [
                    'text' => TestStrings::LLAMA_EMOJIS_2,
                    'tokens' => ['ðŁ', '¦', 'Ļ', 'ê', 'Ļ', 'Ĭ'],
                    'ids' => [9468, 99, 247, 166, 247, 232],
                    'decoded' => '🦙Ꙋ',
                ],
                'Emojis 3' => [
                    'text' => TestStrings::LLAMA_EMOJIS_3,
                    'tokens' => ['ê', 'Ļ', 'Ĭ', 'ðŁ', '¦', 'Ļ'],
                    'ids' => [166, 247, 232, 9468, 99, 247],
                    'decoded' => 'Ꙋ🦙',
                ],
                'Paragraph' => [
                    'text' => TestStrings::LLAMA_PARAGRAPH,
                    'tokens' => ['The', 'Ġllama', 'Ġ(/', 'Ë', 'Ī', 'l', 'É', 'ĳ', 'Ë', 'Ĳ', 'm', 'ÉĻ', '/', ';', 'ĠðŁ', '¦', 'Ļ', 'Spanish', 'Ġpronunciation', ':', 'Ġ[', 'Ë', 'Ī', 'Ê', 'İ', 'ama', '])', 'Ġ(', 'L', 'ama', 'Ġgl', 'ama', ')', 'Ġis', 'Ġa', 'Ġdomestic', 'ated', 'ĠSouth', 'ĠAmerican', 'Ġcamel', 'id', ',', 'Ġwidely', 'Ġused', 'Ġas', 'Ġa', 'Ġmeat', 'Ġand', 'Ġpack', 'Ġanimal', 'Ġby', 'ĠAnd', 'ean', 'Ġcultures', 'Ġsince', 'Ġthe', 'ĠPre', '-C', 'olum', 'bian', 'Ġera', '.', 'ĠL', 'lam', 'as', 'Ġare', 'Ġsocial', 'Ġanimals', 'Ġand', 'Ġlive', 'Ġwith', 'Ġothers', 'Ġas', 'Ġa', 'Ġherd', '.', 'ĠTheir', 'Ġwool', 'Ġis', 'Ġsoft', 'Ġand', 'Ġcontains', 'Ġonly', 'Ġa', 'Ġsmall', 'Ġamount', 'Ġof', 'Ġlan', 'olin', '.[', '2', ']', 'ĠL', 'lam', 'as', 'Ġcan', 'Ġlearn', 'Ġsimple', 'Ġtasks', 'Ġafter', 'Ġa', 'Ġfew', 'Ġrepetitions', '.', 'ĠWhen', 'Ġusing', 'Ġa', 'Ġpack', ',', 'Ġthey', 'Ġcan', 'Ġcarry', 'Ġabout', 'Ġ', '25', 'Ġto', 'Ġ', '30', '%', 'Ġof', 'Ġtheir', 'Ġbody', 'Ġweight', 'Ġfor', 'Ġ', '8', 'Ġto', 'Ġ', '13', 'Ġkm', 'Ġ(', '5', 'âĢĵ', '8', 'Ġmiles', ').[', '3', ']', 'ĠThe', 'Ġname', 'Ġllama', 'Ġ(', 'in', 'Ġthe', 'Ġpast', 'Ġalso', 'Ġspelled', 'Ġ"', 'lama', '"', 'Ġor', 'Ġ"', 'gl', 'ama', '")', 'Ġwas', 'Ġadopted', 'Ġby', 'ĠEuropean', 'Ġsettlers', 'Ġfrom', 'Ġnative', 'ĠPer', 'uv', 'ians', '.[', '4', ']', 'ĠThe', 'Ġancestors', 'Ġof', 'Ġll', 'amas', 'Ġare', 'Ġthought', 'Ġto', 'Ġhave', 'Ġoriginated', 'Ġfrom', 'Ġthe', 'ĠGreat', 'ĠPlains', 'Ġof', 'ĠNorth', 'ĠAmerica', 'Ġabout', 'Ġ', '40', 'Ġmillion', 'Ġyears', 'Ġago', ',', 'Ġand', 'Ġsubsequently', 'Ġmigrated', 'Ġto', 'ĠSouth', 'ĠAmerica', 'Ġabout', 'Ġthree', 'Ġmillion', 'Ġyears', 'Ġago', 'Ġduring', 'Ġthe', 'ĠGreat', 'ĠAmerican', 'ĠInter', 'change', '.', 'ĠBy', 'Ġthe', 'Ġend', 'Ġof', 'Ġthe', 'Ġlast', 'Ġice', 'Ġage', 'Ġ(', '10', ',', '000', 'âĢĵ', '12', ',', '000', 'Ġyears', 'Ġago', '),', 'Ġcamel', 'ids', 'Ġwere', 'Ġextinct', 'Ġin', 'ĠNorth', 'ĠAmerica', '.[', '3', ']', 'ĠAs', 'Ġof', 'Ġ', '200', '7', ',', 'Ġthere', 'Ġwere', 'Ġover', 'Ġseven', 'Ġmillion', 'Ġll', 'amas', 'Ġand', 'Ġal', 'pac', 'as', 'Ġin', 'ĠSouth', 'ĠAmerica', 'Ġand', 'Ġover', 'Ġ', '158', ',', '000', 'Ġll', 'amas', 'Ġand', 'Ġ', '100', ',', '000', 'ê', 'Ļ', 'Ĭ', 'ðŁ', '¦', 'Ļ', 'Ġal', 'pac', 'as', ',', 'Ġdescended', 'Ġfrom', 'Ġprogen', 'itors', 'Ġimported', 'Ġlate', 'Ġin', 'Ġthe', 'Ġ', '20', 'th', 'Ġcentury', ',', 'Ġin', 'Ġthe', 'ĠUnited', 'ĠStates', 'Ġand', 'ĠCanada', '.[', '5', ']', 'ĠIn', 'ĠA', 'ym', 'ara', 'Ġmythology', ',', 'Ġll', 'amas', 'Ġare', 'Ġimportant', 'Ġbeings', '.', 'ĠThe', 'ĠHeavenly', 'ĠL', 'lama', 'Ġis', 'Ġsaid', 'Ġto', 'Ġdrink', 'Ġwater', 'Ġfrom', 'Ġthe', 'Ġocean', 'Ġand', 'Ġur', 'in', 'ates', 'Ġas', 'Ġit', 'Ġrains', '.[', '6', ']', 'ĠAccording', 'Ġto', 'ĠA', 'ym', 'ara', 'Ġes', 'chat', 'ology', ',', 'Ġll', 'amas', 'Ġwill', 'Ġreturn', 'Ġto', 'Ġthe', 'Ġwater', 'Ġsprings', 'Ġand', 'Ġl', 'ago', 'ons', 'Ġwhere', 'Ġthey', 'Ġcome', 'Ġfrom', 'Ġat', 'Ġthe', 'Ġend', 'Ġof', 'Ġtime', '.[', '6', ']'],
                    'ids' => [791, 94776, 47325, 135, 230, 75, 133, 239, 135, 238, 76, 99638, 14, 26, 11410, 99, 247, 62897, 71722, 25, 510, 135, 230, 134, 236, 3105, 2526, 320, 43, 3105, 2840, 3105, 8, 374, 264, 13018, 660, 4987, 3778, 50252, 307, 11, 13882, 1511, 439, 264, 13339, 323, 3854, 10065, 555, 1628, 5420, 27833, 2533, 279, 5075, 7813, 1152, 13464, 11639, 13, 445, 24705, 300, 527, 3674, 10099, 323, 3974, 449, 3885, 439, 264, 59213, 13, 11205, 39640, 374, 8579, 323, 5727, 1193, 264, 2678, 3392, 315, 31791, 37737, 8032, 17, 60, 445, 24705, 300, 649, 4048, 4382, 9256, 1306, 264, 2478, 86066, 13, 3277, 1701, 264, 3854, 11, 814, 649, 6920, 922, 220, 914, 311, 220, 966, 4, 315, 872, 2547, 4785, 369, 220, 23, 311, 220, 1032, 13437, 320, 20, 4235, 23, 8931, 94638, 18, 60, 578, 836, 94776, 320, 258, 279, 3347, 1101, 68918, 330, 81101, 1, 477, 330, 6200, 3105, 909, 574, 18306, 555, 7665, 61107, 505, 10068, 3700, 12328, 5493, 8032, 19, 60, 578, 38618, 315, 9507, 29189, 527, 3463, 311, 617, 44853, 505, 279, 8681, 63911, 315, 4892, 5270, 922, 220, 1272, 3610, 1667, 4227, 11, 323, 28520, 73691, 311, 4987, 5270, 922, 2380, 3610, 1667, 4227, 2391, 279, 8681, 3778, 5783, 3455, 13, 3296, 279, 842, 315, 279, 1566, 10054, 4325, 320, 605, 11, 931, 4235, 717, 11, 931, 1667, 4227, 705, 50252, 3447, 1051, 69918, 304, 4892, 5270, 8032, 18, 60, 1666, 315, 220, 1049, 22, 11, 1070, 1051, 927, 8254, 3610, 9507, 29189, 323, 453, 46051, 300, 304, 4987, 5270, 323, 927, 220, 11286, 11, 931, 9507, 29189, 323, 220, 1041, 11, 931, 166, 247, 232, 9468, 99, 247, 453, 46051, 300, 11, 58842, 505, 84360, 12170, 25973, 3389, 304, 279, 220, 508, 339, 9478, 11, 304, 279, 3723, 4273, 323, 7008, 8032, 20, 60, 763, 362, 1631, 5169, 59492, 11, 9507, 29189, 527, 3062, 23837, 13, 578, 88150, 445, 81101, 374, 1071, 311, 7172, 3090, 505, 279, 18435, 323, 4433, 258, 988, 439, 433, 62555, 8032, 21, 60, 10771, 311, 362, 1631, 5169, 1560, 9884, 2508, 11, 9507, 29189, 690, 471, 311, 279, 3090, 42242, 323, 326, 6438, 2439, 1405, 814, 2586, 505, 520, 279, 842, 315, 892, 8032, 21, 60],
                    'decoded' => TestStrings::LLAMA_PARAGRAPH,
                ],
            ],
            'Xenova/deepseek-coder-1.3b-instruct' => [
                'Simple' => [
                    'text' => TestStrings::SIMPLE,
                    'tokens' => ['<｜begin▁of▁sentence｜>', 'How', 'Ġare', 'Ġyou', 'Ġdoing', '?'],
                    'ids' => [32013, 2808, 417, 340, 3207, 30],
                    'decoded' => '<｜begin▁of▁sentence｜>How are you doing?',
                ],
                'Simple with punctuation' => [
                    'text' => TestStrings::SIMPLE_WITH_PUNCTUATION,
                    'tokens' => ['<｜begin▁of▁sentence｜>', 'You', 'Ġshould', "'", 've', 'Ġdone', 'Ġthis'],
                    'ids' => [32013, 2042, 1020, 6, 312, 2359, 437],
                    'decoded' => "<｜begin▁of▁sentence｜>You should've done this",
                ],
                'Numbers' => [
                    'text' => TestStrings::NUMBERS,
                    'tokens' => ['<｜begin▁of▁sentence｜>', '0', '1', '2', '3', '4', '5', '6', '7', '8', '9', 'Ġ', '0', 'Ġ', '1', 'Ġ', '2', 'Ġ', '3', 'Ġ', '4', 'Ġ', '5', 'Ġ', '6', 'Ġ', '7', 'Ġ', '8', 'Ġ', '9', 'Ġ', '1', '0', 'Ġ', '1', '0', '0', 'Ġ', '1', '0', '0', '0'],
                    'ids' => [32013, 15, 16, 17, 18, 19, 20, 21, 22, 23, 24, 207, 15, 207, 16, 207, 17, 207, 18, 207, 19, 207, 20, 207, 21, 207, 22, 207, 23, 207, 24, 207, 16, 15, 207, 16, 15, 15, 207, 16, 15, 15, 15],
                    'decoded' => '<｜begin▁of▁sentence｜>0123456789 0 1 2 3 4 5 6 7 8 9 10 100 1000',
                ],
                'Text with numbers' => [
                    'text' => TestStrings::TEXT_WITH_NUMBERS,
                    'tokens' => ['<｜begin▁of▁sentence｜>', 'The', 'Ġcompany', 'Ġwas', 'Ġfounded', 'Ġin', 'Ġ', '2', '0', '1', '6', '.'],
                    'ids' => [32013, 546, 2595, 438, 16316, 279, 207, 17, 15, 16, 21, 13],
                    'decoded' => '<｜begin▁of▁sentence｜>The company was founded in 2016.',
                ],
                'Punctuation' => [
                    'text' => TestStrings::PUNCTUATION,
                    'tokens' => ['<｜begin▁of▁sentence｜>', 'A', 'Ċ', "'", 'll', 'Ġ!!', 'to', "?'", 'd', "''", 'd', 'Ġof', ',', 'Ġcan', "'", 't', '.'],
                    'ids' => [32013, 32, 185, 6, 642, 24466, 577, 11665, 67, 4191, 67, 280, 11, 482, 6, 83, 13],
                    'decoded' => "<｜begin▁of▁sentence｜>A\n'll !!to?'d''d of, can't.",
                ],
                'Python code' => [
                    'text' => TestStrings::PYTHON_CODE,
                    'tokens' => ['<｜begin▁of▁sentence｜>', 'def', 'Ġmain', '():', 'Ċ', 'ĉ', 'pass'],
                    'ids' => [32013, 1551, 1959, 10942, 185, 184, 4805],
                    'decoded' => "<｜begin▁of▁sentence｜>def main():\n\tpass",
                ],
                'Javascript code' => [
                    'text' => TestStrings::JAVASCRIPT_CODE,
                    'tokens' => ['<｜begin▁of▁sentence｜>', 'let', 'Ġa', 'Ġ=', 'Ġobj', '.', 'toString', '();', 'Ċ', 'toString', '();'],
                    'ids' => [32013, 1160, 245, 405, 6528, 13, 12617, 1293, 185, 12617, 1293],
                    'decoded' => "<｜begin▁of▁sentence｜>let a = obj.toString();\ntoString();",
                ],
                'Newlines' => [
                    'text' => TestStrings::LLAMA_NEWLINES,
                    'tokens' => ['<｜begin▁of▁sentence｜>', 'ax', 'Ċ', '####', 'Ċ', 'bo', 'o'],
                    'ids' => [32013, 1099, 185, 3576, 185, 952, 78],
                    'decoded' => "<｜begin▁of▁sentence｜>ax\n####\nboo",
                ],
                'Basic' => [
                    'text' => TestStrings::BASIC,
                    'tokens' => ['<｜begin▁of▁sentence｜>', 'UN', 'want', 'Ã©d', ',', 'running'],
                    'ids' => [32013, 4348, 28626, 31898, 11, 22785],
                    'decoded' => '<｜begin▁of▁sentence｜>UNwantéd,running',
                ],
                'Control tokens' => [
                    'text' => TestStrings::CONTROL_TOKENS,
                    'tokens' => ['<｜begin▁of▁sentence｜>', '1', 'Ā', '2', 'ï¿½', '3'],
                    'ids' => [32013, 16, 175, 17, 10006, 18],
                    'decoded' => "<｜begin▁of▁sentence｜>1\u{0000}2\u{fffd}3",
                ],
                'Hello world titlecase' => [
                    'text' => TestStrings::HELLO_WORLD_TITLECASE,
                    'tokens' => ['<｜begin▁of▁sentence｜>', 'Hello', 'ĠWorld'],
                    'ids' => [32013, 17535, 5414],
                    'decoded' => '<｜begin▁of▁sentence｜>Hello World',
                ],
                'Hello world lowercase' => [
                    'text' => TestStrings::HELLO_WORLD_LOWERCASE,
                    'tokens' => ['<｜begin▁of▁sentence｜>', 'hello', 'Ġworld'],
                    'ids' => [32013, 31702, 1835],
                    'decoded' => '<｜begin▁of▁sentence｜>hello world',
                ],
                'Chinese only' => [
                    'text' => TestStrings::CHINESE_ONLY,
                    'tokens' => ['<｜begin▁of▁sentence｜>', 'çĶŁæ´»çļĦ', 'çľŁ', 'è°', 'Ľ', 'æĺ¯'],
                    'ids' => [32013, 23393, 2651, 1534, 236, 502],
                    'decoded' => '<｜begin▁of▁sentence｜>生活的真谛是',
                ],
                'Leading space' => [
                    'text' => TestStrings::LEADING_SPACE,
                    'tokens' => ['<｜begin▁of▁sentence｜>', 'ĠĠ', 'Ġleading', 'Ġspace'],
                    'ids' => [32013, 243, 5877, 2507],
                    'decoded' => '<｜begin▁of▁sentence｜>   leading space',
                ],
                'Trailing space' => [
                    'text' => TestStrings::TRAILING_SPACE,
                    'tokens' => ['<｜begin▁of▁sentence｜>', 'tra', 'iling', 'Ġspace', 'ĠĠĠ'],
                    'ids' => [32013, 7246, 5964, 2507, 315],
                    'decoded' => '<｜begin▁of▁sentence｜>trailing space   ',
                ],
                'Double space' => [
                    'text' => TestStrings::DOUBLE_SPACE,
                    'tokens' => ['<｜begin▁of▁sentence｜>', 'Hi', 'Ġ', 'ĠH', 'ello'],
                    'ids' => [32013, 11041, 207, 414, 9489],
                    'decoded' => '<｜begin▁of▁sentence｜>Hi  Hello',
                ],
                'Currency' => [
                    'text' => TestStrings::CURRENCY,
                    'tokens' => ['<｜begin▁of▁sentence｜>', 'test', 'Ġ$', '1', 'ĠR', '2', 'Ġ#', '3', 'Ġ', 'âĤ¬', '4', 'ĠÂ£', '5', 'ĠÂ', '¥', '6', 'Ġ', 'âĤ', '£', '7', 'Ġ', 'âĤ', '¹', '8', 'Ġ', 'âĤ', '±', '9', 'Ġtest'],
                    'ids' => [32013, 2806, 371, 16, 432, 17, 1494, 18, 207, 11010, 19, 8761, 20, 2688, 98, 21, 207, 7935, 96, 22, 207, 7935, 117, 23, 207, 7935, 109, 24, 1719],
                    'decoded' => '<｜begin▁of▁sentence｜>test $1 R2 #3 €4 £5 ¥6 ₣7 ₹8 ₱9 test',
                ],
                'Currency with decimals' => [
                    'text' => TestStrings::CURRENCY_WITH_DECIMALS,
                    'tokens' => ['<｜begin▁of▁sentence｜>', 'I', 'Ġbought', 'Ġan', 'Ġapple', 'Ġfor', 'Ġ$', '1', '.', '0', '0', 'Ġat', 'Ġthe', 'Ġstore', '.'],
                    'ids' => [32013, 40, 8942, 274, 15902, 327, 371, 16, 13, 15, 15, 429, 254, 4730, 13],
                    'decoded' => '<｜begin▁of▁sentence｜>I bought an apple for $1.00 at the store.',
                ],
                'Ellipsis' => [
                    'text' => TestStrings::ELLIPSIS,
                    'tokens' => ['<｜begin▁of▁sentence｜>', 'you', 'âĢ¦', 'ĠĠ'],
                    'ids' => [32013, 4209, 2484, 243],
                    'decoded' => '<｜begin▁of▁sentence｜>you…  ',
                ],
                'Text with escape characters' => [
                    'text' => TestStrings::TEXT_WITH_ESCAPE_CHARACTERS,
                    'tokens' => ['<｜begin▁of▁sentence｜>', 'you', 'âĢ¦', 'ÂłÂł'],
                    'ids' => [32013, 4209, 2484, 10447],
                    'decoded' => "<｜begin▁of▁sentence｜>you…\u{00a0}\u{00a0}",
                ],
                'Text with escape characters 2' => [
                    'text' => TestStrings::TEXT_WITH_ESCAPE_CHARACTERS_2,
                    'tokens' => ['<｜begin▁of▁sentence｜>', 'you', 'âĢ¦', 'Âł', 'Âł', 'you', 'âĢ¦', 'ÂłÂł'],
                    'ids' => [32013, 4209, 2484, 1200, 1200, 4209, 2484, 10447],
                    'decoded' => "<｜begin▁of▁sentence｜>you…\u{00a0}\u{00a0}you…\u{00a0}\u{00a0}",
                ],
                'Tilde normalization' => [
                    'text' => TestStrings::TILDE_NORMALIZATION,
                    'tokens' => ['<｜begin▁of▁sentence｜>', 'we', 'ird', 'Ġ', 'ï', '½', 'ŀ', 'Ġedge', 'Ġ', 'ï', '½', 'ŀ', 'Ġcase'],
                    'ids' => [32013, 828, 2369, 207, 169, 121, 239, 5935, 207, 169, 121, 239, 1452],
                    'decoded' => '<｜begin▁of▁sentence｜>weird ～ edge ～ case',
                ],
                'Popular emojis' => [
                    'text' => TestStrings::POPULAR_EMOJIS,
                    'tokens' => ['<｜begin▁of▁sentence｜>', 'ðŁ', 'ĺ', 'Ĥ', 'ĠðŁ', 'ĳ', 'į', 'ĠðŁ', '¤', '£', 'ĠðŁ', 'ĺ', 'į', 'ĠðŁ', 'ĺ', 'Ń', 'ĠðŁ', 'İ', 'ī', 'ĠðŁĻ', 'ı', 'ĠðŁ', 'ĺ', 'Ĭ', 'ĠðŁ', 'Ķ', '¥', 'ĠðŁ', 'ĺ', 'ģ', 'ĠðŁ', 'ĺ', 'ħ', 'ĠðŁ', '¤', 'Ĺ', 'ĠðŁ', 'ĺ', 'Ĩ', 'ĠðŁ', 'ĳ', 'ı', 'Ġ', 'â', 'Ŀ', '¤', 'ï', '¸', 'ı', 'ĠðŁ', 'Ĵ', 'ľ', 'ĠðŁ', 'Ĵ', 'ļ', 'ĠðŁ', 'Ĵ', 'Ĺ', 'ĠðŁ', 'Ĵ', 'Ļ', 'ĠðŁ', 'ĸ', '¤', 'ĠðŁ', 'ĺ', 'İ', 'ĠðŁ', 'ĳ', 'Į', 'ĠðŁ', '¥', '³', 'ĠðŁ', 'Ĵ', 'ª', 'Ġ', 'â', 'ľ', '¨', 'ĠðŁ', 'ĳ', 'ī', 'ĠðŁ', 'ĳ', 'Ģ', 'ĠðŁ', 'Ĵ', '¯', 'ĠðŁ', 'İ', 'Ī', 'ĠðŁĻ', 'Ī', 'ĠðŁĻ', 'Į', 'ĠðŁ', 'Ĵ', 'Ģ', 'ĠðŁ', 'ĳ', 'ĩ', 'ĠðŁ', 'ĳ', 'ĭ', 'Ġ', 'â', 'ľ', 'ħ', 'ĠðŁ', 'İ', 'ģ', 'ĠðŁ', 'Į', 'ŀ', 'ĠðŁ', 'Į', '¸', 'ĠðŁ', 'Ĵ', '°'],
                    'ids' => [32013, 10047, 233, 211, 12394, 226, 222, 12394, 97, 96, 12394, 233, 222, 12394, 233, 242, 12394, 223, 218, 22709, 224, 12394, 233, 219, 12394, 229, 98, 12394, 233, 210, 12394, 233, 214, 12394, 97, 232, 12394, 233, 215, 12394, 226, 224, 207, 156, 238, 97, 169, 116, 224, 12394, 227, 237, 12394, 227, 235, 12394, 227, 232, 12394, 227, 234, 12394, 231, 97, 12394, 233, 223, 12394, 226, 221, 12394, 98, 111, 12394, 227, 103, 207, 156, 237, 101, 12394, 226, 218, 12394, 226, 209, 12394, 227, 107, 12394, 223, 217, 22709, 217, 22709, 221, 12394, 227, 209, 12394, 226, 216, 12394, 226, 220, 207, 156, 237, 214, 12394, 223, 210, 12394, 221, 239, 12394, 221, 116, 12394, 227, 108],
                    'decoded' => '<｜begin▁of▁sentence｜>😂 👍 🤣 😍 😭 🎉 🙏 😊 🔥 😁 😅 🤗 😆 👏 ❤️ 💜 💚 💗 💙 🖤 😎 👌 🥳 💪 ✨ 👉 👀 💯 🎈 🙈 🙌 💀 👇 👋 ✅ 🎁 🌞 🌸 💰',
                ],
                'Multibyte emojis' => [
                    'text' => TestStrings::MULTIBYTE_EMOJIS,
                    'tokens' => ['<｜begin▁of▁sentence｜>', 'â', 'ľ', '¨', 'ĠðŁ', '¤', 'Ĺ', 'ĠðŁ', 'ĳ', 'ģ', 'ï', '¸', 'ı', 'ĠðŁ', 'ĳ', '±', 'ðŁ', 'ı', '»', 'ĠðŁ', 'ķ', 'µ', 'âĢ', 'į', 'â', 'Ļ', 'Ĥ', 'ï', '¸', 'ı', 'ĠðŁ', '§', 'Ļ', 'ðŁ', 'ı', '»', 'âĢ', 'į', 'â', 'Ļ', 'Ĥ', 'ĠðŁ', 'ĳ', '¨', 'ðŁ', 'ı', '»', 'âĢ', 'į', 'ðŁ', 'Į', '¾', 'ĠðŁ', '§', 'ĳ', 'âĢ', 'į', 'ðŁ', '¤', 'Ŀ', 'âĢ', 'į', 'ðŁ', '§', 'ĳ', 'ĠðŁ', 'ĳ', '©', 'âĢ', 'į', 'â', 'Ŀ', '¤', 'âĢ', 'į', 'ðŁ', 'Ĵ', 'ĭ', 'âĢ', 'į', 'ðŁ', 'ĳ', '¨', 'ĠðŁ', 'ĳ', '©', 'âĢ', 'į', 'ðŁ', 'ĳ', '©', 'âĢ', 'į', 'ðŁ', 'ĳ', '§', 'âĢ', 'į', 'ðŁ', 'ĳ', '¦', 'ĠðŁ', '§', 'ĳ', 'ðŁ', 'ı', '»', 'âĢ', 'į', 'ðŁ', '¤', 'Ŀ', 'âĢ', 'į', 'ðŁ', '§', 'ĳ', 'ðŁ', 'ı', '»', 'ĠðŁ', 'ı', '´', 'ó', 'ł', 'ģ', '§', 'ó', 'ł', 'ģ', '¢', 'ó', 'ł', 'ģ', '¥', 'ó', 'ł', 'ģ', '®', 'ó', 'ł', 'ģ', '§', 'ó', 'ł', 'ģ', '¿', 'ĠðŁ', 'ĳ', '¨', 'ðŁ', 'ı', '»', 'âĢ', 'į', 'â', 'Ŀ', '¤', 'ï', '¸', 'ı', 'âĢ', 'į', 'ðŁ', 'Ĵ', 'ĭ', 'âĢ', 'į', 'ðŁ', 'ĳ', '¨', 'ðŁ', 'ı', '¼'],
                    'ids' => [32013, 156, 237, 101, 12394, 97, 232, 12394, 226, 210, 169, 116, 224, 12394, 226, 109, 10047, 224, 119, 12394, 230, 113, 350, 222, 156, 234, 211, 169, 116, 224, 12394, 100, 234, 10047, 224, 119, 350, 222, 156, 234, 211, 12394, 226, 101, 10047, 224, 119, 350, 222, 10047, 221, 122, 12394, 100, 226, 350, 222, 10047, 97, 238, 350, 222, 10047, 100, 226, 12394, 226, 102, 350, 222, 156, 238, 97, 350, 222, 10047, 227, 220, 350, 222, 10047, 226, 101, 12394, 226, 102, 350, 222, 10047, 226, 102, 350, 222, 10047, 226, 100, 350, 222, 10047, 226, 99, 12394, 100, 226, 10047, 224, 119, 350, 222, 10047, 97, 238, 350, 222, 10047, 100, 226, 10047, 224, 119, 12394, 224, 112, 173, 241, 210, 100, 173, 241, 210, 95, 173, 241, 210, 98, 173, 241, 210, 106, 173, 241, 210, 100, 173, 241, 210, 123, 12394, 226, 101, 10047, 224, 119, 350, 222, 156, 238, 97, 169, 116, 224, 350, 222, 10047, 227, 220, 350, 222, 10047, 226, 101, 10047, 224, 120],
                    'decoded' => '<｜begin▁of▁sentence｜>✨ 🤗 👁️ 👱🏻 🕵‍♂️ 🧙🏻‍♂ 👨🏻‍🌾 🧑‍🤝‍🧑 👩‍❤‍💋‍👨 👩‍👩‍👧‍👦 🧑🏻‍🤝‍🧑🏻 🏴󠁧󠁢󠁥󠁮󠁧󠁿 👨🏻‍❤️‍💋‍👨🏼',
                ],
                'Spiece underscore' => [
                    'text' => TestStrings::SPIECE_UNDERSCORE,
                    'tokens' => ['<｜begin▁of▁sentence｜>', 'âĸ', 'ģ', 'This', 'Ġ', 'âĸ', 'ģ', 'is', 'Ġ', 'âĸ', 'ģ', 'a', 'Ġ', 'âĸ', 'ģ', 'test', 'Ġ', 'âĸ', 'ģ', '.'],
                    'ids' => [32013, 11028, 210, 1559, 207, 11028, 210, 262, 207, 11028, 210, 64, 207, 11028, 210, 2806, 207, 11028, 210, 13],
                    'decoded' => '<｜begin▁of▁sentence｜>▁This ▁is ▁a ▁test ▁.',
                ],
                'BPE scores priority 1' => [
                    'text' => TestStrings::LLAMA_BPE_SCORES_PRIORITY_1,
                    'tokens' => ['<｜begin▁of▁sentence｜>', 'gr', 'ab', 'bed'],
                    'ids' => [32013, 877, 356, 3861],
                    'decoded' => '<｜begin▁of▁sentence｜>grabbed',
                ],
                'BPE scores priority 2' => [
                    'text' => TestStrings::LLAMA_BPE_SCORES_PRIORITY_2,
                    'tokens' => ['<｜begin▁of▁sentence｜>', 'Ġgrab', 'bed'],
                    'ids' => [32013, 14596, 3861],
                    'decoded' => '<｜begin▁of▁sentence｜> grabbed',
                ],
                'BPE scores priority 3' => [
                    'text' => TestStrings::LLAMA_BPE_SCORES_PRIORITY_3,
                    'tokens' => ['<｜begin▁of▁sentence｜>', 'ĠĠĠĠĠĠĠĠĠĠ', 'Ġgrab', 'bed'],
                    'ids' => [32013, 3137, 14596, 3861],
                    'decoded' => '<｜begin▁of▁sentence｜>           grabbed',
                ],
                'Newline' => [
                    'text' => TestStrings::LLAMA_NEWLINE,
                    'tokens' => ['<｜begin▁of▁sentence｜>', 'Ċ'],
                    'ids' => [32013, 185],
                    'decoded' => "<｜begin▁of▁sentence｜>\n",
                ],
                'Newline with leading space' => [
                    'text' => TestStrings::LLAMA_NEWLINE_WITH_LEADING_SPACE,
                    'tokens' => ['<｜begin▁of▁sentence｜>', 'Ġ', 'Ċ'],
                    'ids' => [32013, 207, 185],
                    'decoded' => "<｜begin▁of▁sentence｜> \n",
                ],
                'Tabs' => [
                    'text' => TestStrings::LLAMA_TABS,
                    'tokens' => ['<｜begin▁of▁sentence｜>', 'ĉ', 'tabs', 'ĉĉĉ', 'ĉ', 'out', 'Ġhere'],
                    'ids' => [32013, 184, 20611, 1749, 184, 406, 1283],
                    'decoded' => "<｜begin▁of▁sentence｜>\ttabs\t\t\t\tout here",
                ],
                'Newline and tab' => [
                    'text' => TestStrings::LLAMA_NEWLINE_AND_TAB,
                    'tokens' => ['<｜begin▁of▁sentence｜>', 'Ċ', 'ĉ', 'Ċ'],
                    'ids' => [32013, 185, 184, 185],
                    'decoded' => "<｜begin▁of▁sentence｜>\n\t\n",
                ],
                'Chinese letter' => [
                    'text' => TestStrings::LLAMA_CHINESE_LETTER,
                    'tokens' => ['<｜begin▁of▁sentence｜>', 'éķĩ'],
                    'ids' => [32013, 6759],
                    'decoded' => '<｜begin▁of▁sentence｜>镇',
                ],
                'Emojis 1' => [
                    'text' => TestStrings::LLAMA_EMOJIS_1,
                    'tokens' => ['<｜begin▁of▁sentence｜>', 'ðŁ', '¦', 'Ļ'],
                    'ids' => [32013, 10047, 99, 234],
                    'decoded' => '<｜begin▁of▁sentence｜>🦙',
                ],
                'Emojis 2' => [
                    'text' => TestStrings::LLAMA_EMOJIS_2,
                    'tokens' => ['<｜begin▁of▁sentence｜>', 'ðŁ', '¦', 'Ļ', 'ê', 'Ļ', 'Ĭ'],
                    'ids' => [32013, 10047, 99, 234, 164, 234, 219],
                    'decoded' => '<｜begin▁of▁sentence｜>🦙Ꙋ',
                ],
                'Emojis 3' => [
                    'text' => TestStrings::LLAMA_EMOJIS_3,
                    'tokens' => ['<｜begin▁of▁sentence｜>', 'ê', 'Ļ', 'Ĭ', 'ðŁ', '¦', 'Ļ'],
                    'ids' => [32013, 164, 234, 219, 10047, 99, 234],
                    'decoded' => '<｜begin▁of▁sentence｜>Ꙋ🦙',
                ],
                // 'Paragraph' => [
                //     'text' => TestStrings::LLAMA_PARAGRAPH,
                //     'tokens' => ['<｜begin▁of▁sentence｜>', 'The', 'Ġll', 'ama', 'Ġ(/', 'ËĪ', 'l', 'É', 'ĵ', 'Ë', 'Ĳ', 'm', 'ÉĻ', '/', ';', 'ĠðŁ', '¦', 'Ļ', 'Spanish', 'Ġpronunciation', ':', 'Ġ[', 'ËĪ', 'Ê', 'İ', 'ama', '])', 'Ġ(', 'L', 'ama', 'Ġgl', 'ama', ')', 'Ġis', 'Ġa', 'Ġdomestic', 'ated', 'ĠSouth', 'ĠAmerican', 'Ġcam', 'el', 'id', ',', 'Ġwidely', 'Ġused', 'Ġas', 'Ġa', 'Ġmeat', 'Ġand', 'Ġpack', 'Ġanimal', 'Ġby', 'ĠAnd', 'ean', 'Ġcultures', 'Ġsince', 'Ġthe', 'ĠPre', '-', 'Col', 'umb', 'ian', 'Ġera', '.', 'ĠL', 'lam', 'as', 'Ġare', 'Ġsocial', 'Ġanimals', 'Ġand', 'Ġlive', 'Ġwith', 'Ġothers', 'Ġas', 'Ġa', 'Ġher', 'd', '.', 'ĠTheir', 'Ġwool', 'Ġis', 'Ġsoft', 'Ġand', 'Ġcontains', 'Ġonly', 'Ġa', 'Ġsmall', 'Ġamount', 'Ġof', 'Ġlan', 'ol', 'in', '.[', '2', ']', 'ĠL', 'lam', 'as', 'Ġcan', 'Ġlearn', 'Ġsimple', 'Ġtasks', 'Ġafter', 'Ġa', 'Ġfew', 'Ġrepet', 'itions', '.', 'ĠWhen', 'Ġusing', 'Ġa', 'Ġpack', ',', 'Ġthey', 'Ġcan', 'Ġcarry', 'Ġabout', 'Ġ', '2', '5', 'Ġto', 'Ġ', '3', '0', '%', 'Ġof', 'Ġtheir', 'Ġbody', 'Ġweight', 'Ġfor', 'Ġ', '8', 'Ġto', 'Ġ', '1', '3', 'Ġkm', 'Ġ(', '5', 'âĢµ', '8', 'Ġmiles', ').', '[', '3', ']', 'ĠThe', 'Ġname', 'Ġll', 'ama', 'Ġ(', 'in', 'Ġthe', 'Ġpast', 'Ġalso', 'Ġsp', 'elled', 'Ġ"', 'l', 'ama', '"', 'Ġor', 'Ġ"', 'gl', 'ama', '")', 'Ġwas', 'Ġadopted', 'Ġby', 'ĠEuropean', 'Ġsett', 'lers', 'Ġfrom', 'Ġnative', 'ĠPer', 'uv', 'ians', '.[', '4', ']', 'ĠThe', 'Ġancest', 'ors', 'Ġof', 'Ġllam', 'as', 'Ġare', 'Ġthought', 'Ġto', 'Ġhave', 'Ġorigin', 'ated', 'Ġfrom', 'Ġthe', 'ĠGreat', 'ĠPl', 'ains', 'Ġof', 'ĠNorth', 'ĠAmerica', 'Ġabout', 'Ġ', '4', '0', 'Ġmillion', 'Ġyears', 'Ġago', ',', 'Ġand', 'Ġsubsequently', 'Ġmig', 'rated', 'Ġto', 'ĠSouth', 'ĠAmerica', 'Ġabout', 'Ġthree', 'Ġmillion', 'Ġyears', 'Ġago', 'Ġduring', 'Ġthe', 'ĠGreat', 'ĠAmerican', 'ĠInter', 'change', '.', 'ĠBy', 'Ġthe', 'Ġend', 'Ġof', 'Ġthe', 'Ġlast', 'Ġice', 'Ġage', 'Ġ(', '1', '0', ',', '0', '0', '0', 'âĢµ', '1', '2', ',', '0', '0', '0', 'Ġyears', 'Ġago', '),', 'Ġcamel', 'ids', 'Ġwere', 'Ġext', 'inct', 'Ġin', 'ĠNorth', 'ĠAmerica', '.[', '3', ']', 'ĠAs', 'Ġof', 'Ġ', '2', '0', '0', '7', ',', 'Ġthere', 'Ġwere', 'Ġover', 'Ġseven', 'Ġmillion', 'Ġllam', 'as', 'Ġand', 'Ġal', 'pac', 'as', 'Ġin', 'ĠSouth', 'ĠAmerica', 'Ġand', 'Ġover', 'Ġ', '1', '5', '8', ',', '0', '0', '0', 'Ġllam', 'as', 'Ġand', 'Ġ', '1', '0', '0', ',', '0', '0', '0', 'êĻĬ', 'ðŁ¦Ļ', 'Ġal', 'pac', 'as', ',', 'Ġdesc', 'ended', 'Ġfrom', 'Ġpro', 'gen', 'itors', 'Ġimported', 'Ġlate', 'Ġin', 'Ġthe', 'Ġ', '2', '0', 'th', 'Ġcentury', ',', 'Ġin', 'Ġthe', 'ĠUnited', 'ĠStates', 'Ġand', 'ĠCanada', '.[', '5', ']', 'ĠIn', 'ĠA', 'ym', 'ara', 'Ġmyth', 'ology', ',', 'Ġllam', 'as', 'Ġare', 'Ġimportant', 'Ġbeings', '.', 'ĠThe', 'ĠHeaven', 'ly', 'ĠLl', 'ama', 'Ġis', 'Ġsaid', 'Ġto', 'Ġdrink', 'Ġwater', 'Ġfrom', 'Ġthe', 'Ġocean', 'Ġand', 'Ġur', 'in', 'ates', 'Ġas', 'Ġit', 'Ġra', 'ins', '.[', '6', ']', 'ĠAccording', 'Ġto', 'ĠA', 'ym', 'ara', 'Ġes', 'chat', 'ology', ',', 'Ġllam', 'as', 'Ġwill', 'Ġreturn', 'Ġto', 'Ġthe', 'Ġwater', 'Ġsprings', 'Ġand', 'Ġl', 'ago', 'ons', 'Ġwhere', 'Ġthey', 'Ġcome', 'Ġfrom', 'Ġat', 'Ġthe', 'Ġend', 'Ġof', 'Ġtime', '.[', '6', ']'],
                //     'ids' => [32013, 546, 1703, 4204, 31905, 31459, 75, 131, 226, 133, 225, 76, 28747, 14, 26, 12394, 99, 234, 20786, 840, 9119, 25307, 25, 821, 31459, 132, 223, 4204, 5589, 334, 43, 4204, 1649, 4204, 8, 317, 245, 13569, 612, 5168, 4115, 4370, 282, 304, 11, 13620, 1219, 372, 245, 12342, 285, 2379, 9542, 457, 1306, 24391, 24783, 1952, 254, 7606, 12, 2608, 4313, 987, 2895, 13, 412, 8265, 281, 417, 3601, 8469, 285, 3516, 365, 3060, 372, 245, 706, 67, 13, 9195, 24547, 317, 2829, 285, 5396, 885, 245, 1752, 3733, 280, 27264, 313, 246, 9469, 17, 60, 412, 8265, 281, 482, 3059, 2966, 9227, 1164, 245, 1853, 15747, 2160, 13, 2463, 1242, 245, 2379, 11, 653, 482, 5642, 782, 207, 17, 20, 276, 207, 18, 15, 4, 280, 699, 3110, 4285, 327, 207, 23, 276, 207, 16, 18, 9004, 334, 20, 887, 23, 6595, 628, 58, 18, 60, 428, 1208, 1703, 4204, 334, 246, 254, 2872, 835, 731, 6679, 440, 75, 4204, 1, 409, 440, 2521, 4204, 2456, 438, 13509, 457, 8717, 6762, 12104, 473, 8118, 3043, 12466, 3091, 9469, 19, 60, 428, 18901, 710, 280, 15410, 281, 417, 2207, 276, 463, 6948, 612, 473, 254, 6984, 2284, 2200, 280, 5216, 6092, 782, 207, 19, 15, 4866, 1547, 4074, 11, 285, 23909, 8290, 9831, 276, 5168, 6092, 782, 1846, 4866, 1547, 4074, 2310, 254, 6984, 4115, 6660, 4865, 13, 3550, 254, 1223, 280, 254, 1554, 9405, 4489, 334, 16, 15, 11, 15, 15, 15, 887, 16, 17, 11, 15, 15, 15, 1547, 4074, 650, 4370, 282, 2929, 773, 1309, 5729, 279, 5216, 6092, 9469, 18, 60, 1725, 280, 207, 17, 15, 15, 22, 11, 741, 773, 851, 7970, 4866, 15410, 281, 285, 360, 79, 305, 281, 279, 5168, 6092, 285, 851, 207, 16, 20, 23, 11, 15, 15, 15, 15410, 281, 285, 207, 16, 15, 15, 11, 15, 15, 15, 164, 234, 219, 10047, 99, 234, 360, 79, 305, 281, 11, 1774, 2611, 473, 381, 4920, 6041, 26357, 5179, 279, 254, 207, 17, 15, 392, 8299, 11, 279, 254, 4783, 5098, 285, 8905, 9469, 20, 60, 680, 338, 1254, 3367, 25157, 2333, 11, 15410, 281, 417, 2364, 22792, 13, 428, 18933, 326, 9140, 4204, 317, 989, 276, 7371, 2345, 473, 254, 15439, 285, 8580, 246, 980, 372, 359, 1809, 1231, 9469, 21, 60, 10068, 276, 338, 1254, 3367, 707, 24570, 2333, 11, 15410, 281, 540, 967, 276, 254, 2345, 30851, 285, 284, 5980, 875, 1064, 653, 1857, 473, 429, 254, 1223, 280, 761, 9469, 21, 60],
                //     'decoded' => "<｜begin▁of▁sentence｜>" . TestStrings::LLAMA_PARAGRAPH,
                // ],
            ],
        ];
    }
}
