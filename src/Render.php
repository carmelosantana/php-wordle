<?php

declare(strict_types=1);

namespace CarmeloSantana\PHPWordle;

use function Termwind\{ask};
use function Termwind\{render};
use function Termwind\{terminal};
use PhpSchool\CliMenu\CliMenu;
use PhpSchool\CliMenu\Builder\CliMenuBuilder;

class Render
{
    public function __construct()
    {
        $this->html = new HTML();
    }

    /**
     * Clears terminal and renders all game output.
     *
     * @return void
     */
    public function container(): void
    {
        // Always clear terminal before rendering new container, if not debug.
        terminal()->clear();

        $out = '';
        $out .= $this->html->header();
        $out .= $this->html->debug();
        $out .= $this->html->navTop();

        // Render various game states.
        switch ((new Helper())::getState()) {
            case State::Loss:
                $out .= $this->html->board();
                $out .= $this->html->answer();
                break;

            default:
                $out .= $this->html->board();
                break;
        }

        $out .= $this->html->footer();

        // Render the container.
        render($out);
    }

    /**
     * Adds, renders, and removes current guess from guesses array.
     *
     * @param string $answer User input
     *
     * @return void
     */
    public function inputUpdate(string $answer): void
    {
        (new Helper())::addGuess($answer);
        $this->container();
        (new Helper())::removeLastGuess();
    }

    /**
     * Handles user input.
     *
     * @return void
     */
    public function askWord(): string
    {
        $answer = '';
        $skip = 0;
        $tries = (new Helper())::getTries();

        while ($tries == (new Helper())::getTries()) {
            $c = (new Helper())::keyboardInput();

            if ($skip != 0) {
                $skip--;
                continue;
            }

            switch ($c) {
                case "\n":
                    // [return]
                    return $answer;

                case "\x7f":
                    // [backspace]
                    $answer = substr($answer, 0, -1);
                    break;

                case "[":
                    // Arrow keys
                    $skip = 1;
                    break;

                default:
                    // Anything else
                    if (strlen($answer) < (new Helper())::getMaxLength() and preg_match('/^[a-zA-Z]$/', $c)) {
                        $answer .= $c;
                    }
                    break;
            }

            $this->inputUpdate($answer);
        }
    }

    /**
     * ¡Hasta mañana! 👋
     *
     * @return void
     */
    public function stop(): void
    {
        // Final render before close.
        $this->container();

        // We're done.
        exit;
    }
}
