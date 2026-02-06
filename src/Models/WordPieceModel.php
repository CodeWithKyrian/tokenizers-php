<?php

declare(strict_types=1);

namespace Codewithkyrian\Tokenizers\Models;

class WordPieceModel extends AbstractModel
{
    protected int $maxInputCharsPerWord;
    protected string $continuingSubwordPrefix;

    /**
     * @param array<string, int> $vocab                   the vocabulary
     * @param string             $unkToken                the unknown token
     * @param int                $maxInputCharsPerWord    the maximum input characters per word
     * @param string             $continuingSubwordPrefix the continuing subword prefix
     */
    public function __construct(
        array $vocab,
        string $unkToken = '[UNK]',
        int $maxInputCharsPerWord = 100,
        string $continuingSubwordPrefix = '##'
    ) {
        $this->tokenToIds = $vocab;
        $this->unkToken = $unkToken;
        $this->unkTokenId = $this->tokenToIds[$this->unkToken] ?? null;
        $this->vocab = array_flip($this->tokenToIds);
        $this->maxInputCharsPerWord = $maxInputCharsPerWord;
        $this->continuingSubwordPrefix = $continuingSubwordPrefix;
    }

    /**
     * @param string[] $tokens the tokens to tokenize
     *
     * @return string[]
     */
    public function tokenize(array $tokens): array
    {
        $outputTokens = [];

        foreach ($tokens as $token) {
            $chars = mb_str_split($token);

            if (\count($chars) > $this->maxInputCharsPerWord) {
                $outputTokens[] = $this->unkToken;

                continue;
            }

            $isUnknown = false;
            $start = 0;
            $subTokens = [];

            while ($start < \count($chars)) {
                $end = \count($chars);
                $currentSubstring = null;

                while ($start < $end) {
                    $substr = implode('', \array_slice($chars, $start, $end - $start));

                    if ($start > 0) {
                        $substr = $this->continuingSubwordPrefix.$substr;
                    }

                    if (\array_key_exists($substr, $this->tokenToIds)) {
                        $currentSubstring = $substr;

                        break;
                    }

                    --$end;
                }

                if (null === $currentSubstring) {
                    $isUnknown = true;

                    break;
                }

                $subTokens[] = $currentSubstring;
                $start = $end;
            }

            if ($isUnknown) {
                $outputTokens[] = $this->unkToken;
            } else {
                $outputTokens = array_merge($outputTokens, $subTokens);
            }
        }

        return $outputTokens;
    }

    public function getConfig(?string $key = null, mixed $default = null): mixed
    {
        if (null !== $key) {
            return match ($key) {
                'type' => 'WordPiece',
                'vocab' => $this->tokenToIds,
                'unk_token' => $this->unkToken,
                'max_input_chars_per_word' => $this->maxInputCharsPerWord,
                'continuing_subword_prefix' => $this->continuingSubwordPrefix,
                default => $default,
            };
        }

        return [
            'type' => 'WordPiece',
            'vocab' => $this->tokenToIds,
            'unk_token' => $this->unkToken,
            'max_input_chars_per_word' => $this->maxInputCharsPerWord,
            'continuing_subword_prefix' => $this->continuingSubwordPrefix,
        ];
    }
}
