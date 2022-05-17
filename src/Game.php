<?php

declare(strict_types=1);

namespace CarmeloSantana\PHPWordle;

class Game
{
    public function __construct()
    {
        // Load game.
        $this->round = new Round();

        // Set environment variables.
        $this->dotenv = (new Helper())::loadEnv();
    }

    // Start game.
    public function run()
    {
        // Start match.
        $this->round->game();
    }
}
