<?php

declare(strict_types=1);

namespace CarmeloSantana\PHPWordle;

class Words
{
    // Selectable words.
    private $wordsDB = [];

    /**
     * Builds selectable words list from a file.
     * Defaults to the pre-NYT word list.
     *
     * @param string $file File path
     * 
     * @return void
     */
    public function __construct(
        public string $file = ''
    ) {
        if (empty($this->file)) {
            $this->file = dirname(__DIR__) . '/wordle-words/word-bank.csv';
        }

        $this->loadList($this->file);
    }

    /**
     * Selects a random word from the list.
     * Use a seed to get the same word every time.
     *
     * @param int $seed 
     *
     * @return string
     */
    public function getRandomWord(int $seed = 0): string
    {
        srand($seed);
        return $this->wordsDB[array_rand($this->wordsDB)];
    }

    /**
     * Populates the words list from a file.
     *
     * @param string $file File path
     *
     * @return void
     */
    public function loadList(string $file): void
    {
        $handle = fopen($file, 'r');
        if ($handle) {
            while (($line = fgets($handle)) != false) {
                $this->wordsDB[] = trim($line);
            }
            fclose($handle);
        }
    }

    /**
     * Performs validation on user guess.
     * - Must be a string.
     * - Only letters.
     * - Length must match mode max_length.
     *
     * @param string $word User input
     *
     * @return bool
     */
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
}
