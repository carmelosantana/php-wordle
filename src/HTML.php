<?php

declare(strict_types=1);

namespace CarmeloSantana\PHPWordle;

class HTML
{
    public function __construct()
    {
        $this->theme = new Theme();
    }

    /**
     * Correct answer.
     *
     * @return string
     */
    public function answer(): string
    {
        return $this->bar((new Helper())::getWord(), 'answer');
    }

    /**
     * Full width bar.
     *
     * @param string $content Inner content
     * @param string $style tailwindcss class
     *
     * @return string
     */
    public function bar(string $content, string $style): string
    {
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

    /**
     * Board output with entries and colored tiles.
     *
     * @return string
     */
    public function board(): string
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

    /**
     * Debugger with current word, entry and retries.
     *
     * @return string
     */
    public function debug(): string
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

    public function footer(): string
    {
        $out = <<<HTML
            </div>
        HTML;

        return $out;
    }

    public function header(): string
    {
        $out = <<<HTML
            <div class="mb-2">
        HTML;

        return $out;
    }

    public function navTop(): string
    {
        $content = 'php-<b>Wordle</b>';

        return $this->bar($content, 'logo');
    }

    /**
     * Wrapper for building tags.
     *
     * @param string $tag HTML tag
     * @param string $class Classes
     * @param string $text Content
     *
     * @return string
     */
    public static function tag(string $tag, string $class = '', string $text = ''): string
    {
        return "<$tag" . (!empty($class) ? " class='$class'" : "") . ">$text</$tag>";
    }
}
