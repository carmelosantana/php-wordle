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
    
    /**
     * Starts new game mode.
     *
     * @param int $mode Selectable mode
     *
     * @return void
     */
    public function __construct(int $mode = 0)
    {
        // Setup rounds.
        $this->mode = new Mode();
        $this->render = new Render();
        $this->words = new Words();

        // Set game mode.
        $this->mode->set($mode);

        // Get word for this session and game mode.
        $this->word = $this->words->getRandomWord($this->mode->getCurrent()['seed']);

        // Set tries.
        $this->tries = $this->mode->getCurrent()['max_tries'];
    }
    
    /**
     * Primary game loop.
     *
     * @return void
     */
    public function game(): void
    {
        // Start game.
        $this->state = State::Guessing;

        // Prompt for guess, while tries don't equal 0.
        while ($this->tries > 0) {
            // Start rendering game board.
            $this->render->container();

            // Reset guess.
            $this->guess = $this->render->askWord();

            // If word is valid score it. 
            if ($this->words->isValidWord($this->guess)) {
                (new Helper())::addGuess($this->guess);
                (new Helper())::addScore($this->score($this->guess));

                // If word is correct, lets end this game.
                if ($this->guess == $this->word) {
                    $this->state = State::Won;
                    $this->render->stop();
                }

                // If word is not correct, decrement tries.
                $this->tries--;
            }
        }

        // If retries equal 0, game over.
        $this->state = State::Loss;
        $this->render->stop();
    }
    
    /**
     * Score user guess.
     * 2 for correct letter and position
     * 1 for correct letter
     *
     * @param string $guess User input
     *
     * @return int
     */
    public function score(string $guess): array
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
