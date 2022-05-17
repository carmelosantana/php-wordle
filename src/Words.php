<?php

declare(strict_types=1);

namespace CarmeloSantana\PHPWordle;

class Words
{
    private $wordsDB = [];

    public function __construct(
        public string $file = ''
    ) {
        if (empty($this->file)) {
            $this->file = dirname(__DIR__) . '/data/words.txt';
        }

        $this->loadList($this->file);
    }

    public function getRandomWord($seed): string
    {
        srand($seed);
        return $this->wordsDB[array_rand($this->wordsDB)];
    }

    public function loadList($file): void
    {
        $handle = fopen($file, 'r');
        if ($handle) {
            while (($line = fgets($handle)) != false) {
                $this->wordsDB[] = trim($line);
            }
            fclose($handle);
        }
    }

    public function isValidWord(string $word = ''): bool
    {
        $word = strtolower($word);

        // Not a string.
        if (!is_string($word)) {
            return false;
        }

        // Only letters.
        if (!preg_match('/^[a-z]+$/i', $word)) {
            return false;
        }

        // if word string length is not equal to max_length return false.
        if (strlen($word) !== (new Helper())::getMaxLength()) {
            return false;
        }

        // TODO: Add spell check.
        return true;
    }


    public function score($guess, $word)
    {
        $guess = str_split($guess);
        $word = str_split($word);

        $score = [];

        foreach ($guess as $i => $letter) {
            if (strtolower($letter) == strtolower($word[$i])) {
                $score[$i] = 2;
            } elseif (in_array(strtolower($letter), $word)) {
                $score[$i] = 1;
            } else {
                $score[$i] = 0;
            }
        }

        return $score;
    }
}
