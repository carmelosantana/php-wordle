<?php

declare(strict_types=1);

namespace CarmeloSantana\PHPWordle;

class HTML
{
    public function __construct()
    {
        $this->theme = new Theme();
    }

    public function board()
    {
        $length = (new Helper())::getMaxLength();

        $show = (new Helper())::getMaxDisplay();

        $rows = '';
        $rows .= '<div class="m-1 flex-1">';
        for ($i = 0; $i < $show; $i++) {
            $rows .= '<div class="w-full mb-1 text-center">';
            for ($c = 0; $c < $length; $c++) {
                $bg = $this->theme->getTileBG((new Helper())::getScore($i, $c));
                $text = $this->theme->getTileText((new Helper())::getScore($i, $c));
                $rows .= $this::tag('span', "$bg $text mx-1 px-1 text-center font-bold w-1/" . ($show + 1), strtoupper((new Helper)::getGuesses($i, $c, ' ')));
            }
            $rows .= '</div>';
        }
        $rows .= '</div>';

        return $rows;
    }

    public function debugBar()
    {
        $out = '';

        if ((new Helper())::isDebug()) {
            $word = (new Helper())::getWord();
            $guess = (new Helper())::getGuess();
            $retries = (new Helper())::getTries();

            $out = <<<HTML
                <div>
                    <p class="m-0">
                        <span class="ml-1 text-yellow-800 mr-1">word</span>
                        <span class="bg-yellow-200 px-1 font-bold text-gray-700">$word</span>

                        <span class="ml-1 text-yellow-800 mr-1">guess</span>
                        <span class="bg-yellow-200 px-1 font-bold text-gray-700">$guess</span>

                        <span class="ml-1 text-yellow-800 mr-1">retries</span>
                        <span class="bg-yellow-200 px-1 font-bold text-gray-700">$retries</span>
                    </p>
                </div>
            HTML;
        }

        return $out;
    }

    public function footer()
    {
        $out = <<<HTML
            </div>
        HTML;

        return $out;
    }

    public function header()
    {
        $out = <<<HTML
            <div>
        HTML;

        return $out;
    }

    public function navTop()
    {
        $bg = $this->theme->get('logo-bg');
        $text = $this->theme->get('logo-text');

        $out = <<<HTML
            <div class="m-1 flex-l">
                <p class="m-0 text-center w-full">
                    <span class="px-1 $bg $text text-center">php-<b>Wordle</b></span>
                </p>
            </div>
        HTML;

        return $out;
    }

    public static function tag(string $tag, string $class = '', string $text = '')
    {
        return "<$tag" . (!empty($class) ? " class='$class'" : "") . ">$text</$tag>";
    }
}
