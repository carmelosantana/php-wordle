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

    public function container()
    {
        // Always clear terminal before rendering new container, if not debug.
        terminal()->clear();

        $out = '';
        $out .= $this->html->header();
        $out .= $this->html->navTop();
        $out .= $this->html->board();
        $out .= $this->html->debugBar();
        $out .= $this->html->footer();

        // Render the container.
        render($out);
    }

    public function inputUpdate($answer)
    {
        (new Helper())::addGuess($answer);
        $this->container();
        (new Helper())::removeLastGuess();
    }

    public function askWord()
    {
        $answer = '';
        $skip = 0;
        $tries = (new Helper())::getTries();

        while ($tries == (new Helper())::getTries()) {
            $c = (new Helper())::keyboardInput();

            if ( $skip != 0 ){
                $skip--;
                continue;
            }

            switch ($c) {
                // [return]
                case "\n":
                    return $answer;

                // [backspace]
                case "\x7f":
                    $answer = substr($answer, 0, -1);
                    break;

                // Arrow keys
                case "[":
                    $skip = 1;
                    break;

                // Anything else
                default:
                    if (strlen($answer) < (new Helper())::getMaxLength() and preg_match('/^[a-zA-Z]$/', $c)) {
                        $answer .= $c;
                    }
                    break;
            }

            $this->inputUpdate($answer);
        }
    }

    // We're done.
    public function stop()
    {
        // Final render before close.
        $this->container();

        // ¡Hasta mañana!
        exit;
    }    
}
