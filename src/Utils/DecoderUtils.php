<?php

declare(strict_types=1);

namespace Codewithkyrian\Tokenizers\Utils;

class DecoderUtils
{
    /**
     * Clean up a list of simple English tokenization artifacts like spaces before punctuations and abbreviated forms.
     *
     * This method removes unwanted spaces that appear before punctuation marks and in contractions
     * that are artifacts of the tokenization process.
     *
     * @param string $text the text to clean up
     *
     * @return string the cleaned up text
     */
    public static function cleanUpTokenization(string $text): string
    {
        // return str_replace(
        //     [' .', ' ?', ' !', ' ,', " ' ", " n't", " 'm", " 's", " 've", " 're"],
        //     ['.', '?', '!', ',', "'", "n't", "'m", "'s", "'ve", "'re"],
        //     $text
        // );
        $text = preg_replace('/ \./', '.', $text);
        $text = preg_replace('/ \?/', '?', $text);
        $text = preg_replace('/ \!/', '!', $text);
        $text = preg_replace('/ ,/', ',', $text);
        $text = preg_replace('/ \' /', "'", $text);
        $text = preg_replace('/ n\'t/', "n't", $text);
        $text = preg_replace('/ \'m/', "'m", $text);
        $text = preg_replace('/ \'s/', "'s", $text);
        $text = preg_replace('/ \'ve/', "'ve", $text);

        return preg_replace('/ \'re/', "'re", $text);
    }
}
