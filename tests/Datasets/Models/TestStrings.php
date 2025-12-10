<?php

declare(strict_types=1);

namespace Codewithkyrian\Tokenizers\Tests\Datasets\Models;

/**
 * Test strings for tokenizer testing.
 */
class TestStrings
{
    // ============================================================================
    // Base Test Strings
    // ============================================================================

    public const SIMPLE = 'How are you doing?';

    public const SIMPLE_WITH_PUNCTUATION = "You should've done this";

    public const NUMBERS = '0123456789 0 1 2 3 4 5 6 7 8 9 10 100 1000';

    public const TEXT_WITH_NUMBERS = 'The company was founded in 2016.';

    public const PUNCTUATION = "A\n'll !!to?'d''d of, can't.";

    public const PYTHON_CODE = "def main():\n\tpass";

    public const JAVASCRIPT_CODE = "let a = obj.toString();\ntoString();";

    public const NEWLINES = "This\n\nis\na\ntest.";

    public const BASIC = "UNwant\u{00e9}d,running";

    public const CONTROL_TOKENS = "1\u{0000}2\u{FFFD}3";

    public const HELLO_WORLD_TITLECASE = 'Hello World';

    public const HELLO_WORLD_LOWERCASE = 'hello world';

    public const CHINESE_ONLY = '生活的真谛是';

    public const LEADING_SPACE = '   leading space';

    public const TRAILING_SPACE = 'trailing space   ';

    public const SURROUNDING_SPACE = '   surrounding space   ';

    public const DOUBLE_SPACE = 'Hi  Hello';

    public const CURRENCY = 'test $1 R2 #3 €4 £5 ¥6 ₣7 ₹8 ₱9 test';

    public const CURRENCY_WITH_DECIMALS = 'I bought an apple for $1.00 at the store.';

    public const ELLIPSIS = 'you…  ';

    public const TEXT_WITH_ESCAPE_CHARACTERS = "\u{0079}\u{006F}\u{0075}\u{2026}\u{00A0}\u{00A0}";

    public const TEXT_WITH_ESCAPE_CHARACTERS_2 = "\u{0079}\u{006F}\u{0075}\u{2026}\u{00A0}\u{00A0}\u{0079}\u{006F}\u{0075}\u{2026}\u{00A0}\u{00A0}";

    public const TILDE_NORMALIZATION = "weird \u{FF5E} edge \u{FF5E} case";

    public const SPIECE_UNDERSCORE = '▁This ▁is ▁a ▁test ▁.';

    public const POPULAR_EMOJIS = '😂 👍 🤣 😍 😭 🎉 🙏 😊 🔥 😁 😅 🤗 😆 👏 ❤️ 💜 💚 💗 💙 🖤 😎 👌 🥳 💪 ✨ 👉 👀 💯 🎈 🙈 🙌 💀 👇 👋 ✅ 🎁 🌞 🌸 💰';

    public const MULTIBYTE_EMOJIS = '✨ 🤗 👁️ 👱🏻 🕵‍♂️ 🧙🏻‍♂ 👨🏻‍🌾 🧑‍🤝‍🧑 👩‍❤‍💋‍👨 👩‍👩‍👧‍👦 🧑🏻‍🤝‍🧑🏻 🏴󠁧󠁢󠁥󠁮󠁧󠁿 👨🏻‍❤️‍💋‍👨🏼';

    public const ONLY_WHITESPACE = " \t\n";

    // ============================================================================
    // BERT Test Strings
    // ============================================================================

    public const CHINESE_LATIN_MIXED = "ah\u{535a}\u{63a8}zz";

    public const SIMPLE_WITH_ACCENTS = "H\u{00e9}llo";

    public const MIXED_CASE_WITHOUT_ACCENTS = " \tHeLLo!how  \n Are yoU?  ";

    public const MIXED_CASE_WITH_ACCENTS = " \tHäLLo!how  \n Are yoU?  ";

    // ============================================================================
    // SentencePiece Test Strings
    // ============================================================================

    public const SENTENCEPIECE_SPECIAL_WITH_TRAILING_WHITESPACE = "<s>\n";

    public const SENTENCEPIECE_SPECIAL_SURROUNDED_BY_WHITESPACE = ' </s> test </s> ';

    public const SENTENCEPIECE_SPECIAL_NO_WHITESPACE = '</s>test</s>';

    // ============================================================================
    // Llama Test Strings
    // ============================================================================

    public const LLAMA_BPE_SCORES_PRIORITY_1 = 'grabbed';

    public const LLAMA_BPE_SCORES_PRIORITY_2 = ' grabbed';

    public const LLAMA_BPE_SCORES_PRIORITY_3 = '           grabbed';

    public const LLAMA_NEWLINE = "\n";

    public const LLAMA_NEWLINES = "ax\n####\nboo";

    public const LLAMA_NEWLINE_WITH_LEADING_SPACE = " \n";

    public const LLAMA_TABS = '	tabs				out here';

    public const LLAMA_NEWLINE_AND_TAB = "\n\t\n";

    public const LLAMA_CHINESE_LETTER = '镇';

    public const LLAMA_EMOJIS_1 = '🦙';

    public const LLAMA_EMOJIS_2 = '🦙Ꙋ';

    public const LLAMA_EMOJIS_3 = 'Ꙋ🦙';

    public const LLAMA_PARAGRAPH = 'The llama (/ˈlɑːmə/; 🦙Spanish pronunciation: [ˈʎama]) (Lama glama) is a domesticated South American camelid, widely used as a meat and pack animal by Andean cultures since the Pre-Columbian era. Llamas are social animals and live with others as a herd. Their wool is soft and contains only a small amount of lanolin.[2] Llamas can learn simple tasks after a few repetitions. When using a pack, they can carry about 25 to 30% of their body weight for 8 to 13 km (5–8 miles).[3] The name llama (in the past also spelled "lama" or "glama") was adopted by European settlers from native Peruvians.[4] The ancestors of llamas are thought to have originated from the Great Plains of North America about 40 million years ago, and subsequently migrated to South America about three million years ago during the Great American Interchange. By the end of the last ice age (10,000–12,000 years ago), camelids were extinct in North America.[3] As of 2007, there were over seven million llamas and alpacas in South America and over 158,000 llamas and 100,000Ꙋ🦙 alpacas, descended from progenitors imported late in the 20th century, in the United States and Canada.[5] In Aymara mythology, llamas are important beings. The Heavenly Llama is said to drink water from the ocean and urinates as it rains.[6] According to Aymara eschatology, llamas will return to the water springs and lagoons where they come from at the end of time.[6]';

    public const LLAMA_IGNORE_MERGES = "Ne için gittiğimi falan bilmiyordum, Washington'da belirtilen bir yere rapor vermem gerekiyordu.";

    // ============================================================================
    // VITS Test Strings
    // ============================================================================

    public const VITS_BASIC = 'abcdefghijklmnopqrstuvwxyz01234567890';

    public const VITS_SPECIAL_CHARACTERS = 'ț ţ';

    // ============================================================================
    // Qwen Test Strings
    // ============================================================================

    public const QWEN_PUNCTUATION_SPLIT = "i'm i'M i've i've i'Ve i'vE i'VE";

    // ============================================================================
    // Whisper Test Strings
    // ============================================================================

    public const WHISPER_SPECIAL_TOKENS = '   <|startoftranscript|> <|en|>   ';

    // ============================================================================
    // Blenderbot Small Test Strings
    // ============================================================================

    public const BLENDERBOT_SMALL_SPECIAL_TOKENS = '__start__hello world__end__';

    public const BLENDERBOT_SMALL_WHITESPACE_1 = '__start__ hey __end__';

    public const BLENDERBOT_SMALL_WHITESPACE_2 = '__start__hey __end__';

    // ============================================================================
    // T5 Test Strings
    // Tests the new T5 tokenizer, which uses a different prepend_scheme for its pre_tokenizer
    // See https://github.com/huggingface/transformers/pull/26678 for more information
    // ============================================================================

    public const T5_PREPEND_SCHEME = 'Hey </s>. how are you';

    // ============================================================================
    // Falcon Test Strings
    // ============================================================================

    public const FALCON_NUMBERS_SPLIT = '12 and 123 and 1234';

    // ============================================================================
    // ESM Test Strings
    // ============================================================================

    public const ESM_SPECIAL_TOKENS = '<unk><pad><mask><cls><eos><bos>';

    public const ESM_PROTEIN_SEQUENCES_1 = 'ATTCCGATTCCGATTCCG';

    public const ESM_PROTEIN_SEQUENCES_2 = 'ATTTCTCTCTCTCTCTGAGATCGATCGATCGAT';

    // ============================================================================
    // BLOOM Test Strings
    // ============================================================================

    public const BLOOM_END_OF_SENTENCE_PUNCTUATION = 'test. test, test! test? test… test。 test， test、 test। test۔ test، test';

    // ============================================================================
    // M2M-100 Test Strings
    // ============================================================================

    public const M2M_100_TRANSLATION_INPUTS = '__en__ hello world</s>';

    public const M2M_100_HINDI_TEXT = 'जीवन एक चॉकलेट बॉक्स की तरह है।';

    public const M2M_100_CHINESE_TEXT = '生活就像一盒巧克力。';

    // ============================================================================
    // Normalization Test Strings
    // Adapted from https://developer.mozilla.org/en-US/docs/Web/JavaScript/Reference/Global_Objects/String/normalize
    // ============================================================================

    public const NORMALIZATION_DEFAULT_EXAMPLE = "\u{0041}\u{006d}\u{00e9}\u{006c}\u{0069}\u{0065} | \u{0041}\u{006d}\u{0065}\u{0301}\u{006c}\u{0069}\u{0065}";

    public const NORMALIZATION_CANONICAL_EQUIVALENCE = "\u{00F1} | \u{006E}\u{0303}";

    public const NORMALIZATION_COMPATIBILITY = "\u{FB00} | \u{0066}\u{0066}";

    public const NORMALIZATION_COMBINED_EXAMPLE = "\u{1E9B}\u{0323} | \u{1E9B}\u{0323} | \u{017F}\u{0323}\u{0307} | \u{1E69} | \u{0073}\u{0323}\u{0307}";
}
