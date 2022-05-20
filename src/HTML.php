<?php

declare(strict_types=1);

namespace CarmeloSantana\PHPWordle;

class HTML
{
    public function __construct()
    {
        $this->theme = new Theme();
    }

    public function answer()
    {
        $word = (new Helper())::getWord();

        return $this->bar($word, 'answer');
    }

    public function bar(
        string $content,
        string $style,
    ) {
        $style = $this->theme->get($style);

        $out = <<<HTML
            <div class="m-1 flex-l">
                <p class="m-0 text-center w-full">
                    <span class="px-1 $style text-center">$content</span>
                </p>
            </div>
        HTML;

        return $out;
    }

    public function board()
    {
        $length = (new Helper())::getMaxLength();

        $show = (new Helper())::getMaxDisplay();

        $rows = '';
        $rows .= '<div class="mx-1 flex-1">';
        for ($i = 0; $i < $show; $i++) {
            if ($i == ($show - 1)) {
                $mb = 'mb-0';
            } else {
                $mb = 'mb-1';
            }
            $rows .= '<div class="w-full ' . $mb . ' text-center">';
            for ($c = 0; $c < $length; $c++) {
                $style = $this->theme->getTile((new Helper())::getScore($i, $c));
                $rows .= $this::tag('span', "$style mx-1 px-1 text-center font-bold w-1/" . ($show + 1), strtoupper((new Helper)::getGuesses($i, $c, ' ')));
            }
            $rows .= '</div>';
        }
        $rows .= '</div>';

        return $rows;
    }

    public function debug()
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
        $content = 'php-<b>Wordle</b>';

        return $this->bar($content, 'logo');
    }

    public static function tag(string $tag, string $class = '', string $text = '')
    {
        return "<$tag" . (!empty($class) ? " class='$class'" : "") . ">$text</$tag>";
    }
}
