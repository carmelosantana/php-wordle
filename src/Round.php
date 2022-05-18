<?php

declare(strict_types=1);

namespace CarmeloSantana\PHPWordle;

class Round
{
    public string $guess = '';

    public array $guesses = [];

    public array $scores = [];

    public int $tries = 0;

    public string $word = '';

    public function __construct(int $mode = 0)
    {
        // Setup rounds.
        $this->mode = new Mode();
        $this->render = new Render();
        $this->words = new Words();

        // Set game mode choosen by user
        $this->mode->set($mode);

        // Get word for this session and game mode
        $this->word = $this->words->getRandomWord($this->mode->getCurrent()['seed']);

        // Set retries
        $this->tries = $this->mode->getCurrent()['max_tries'];
    }

    public function game()
    {
        // Prompt for guess, while retries don't equal 0.
        while ($this->tries > 0) {
            // Start rendering game board.
            $this->render->container();

            // Reset guess.
            $this->guess = $this->render->askWord();

            // If word is valid score it. 
            if ($this->words->isValidWord($this->guess)) {
                (new Helper())::addGuess($this->guess);
                (new Helper())::addScore($this->score($this->guess));
                $this->tries--;
            }
        }

        // If retries equal 0, game over.
        $this->render->stop();
    }

    public function score($guess)
    {
        $guess = str_split($guess);
        $word = str_split((new Helper())::getWord());

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
