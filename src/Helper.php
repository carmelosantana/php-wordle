<?php

declare(strict_types=1);

namespace CarmeloSantana\PHPWordle;

class Helper
{
    public static function addGuess($guess)
    {
        $GLOBALS['GAME']->guesses[] = str_split($guess);
    }

    public static function addScore($score)
    {
        $GLOBALS['GAME']->scores[] = $score;
    }

    public static function getInstance()
    {
        return $GLOBALS['GAME'];
    }

    public static function getEnv(string $key, $default = false)
    {
        return $_ENV[$key] ?? $default;
    }

    public static function getGuess($default = '')
    {
        return self::getInstance()->guess ?? $default;
    }

    public static function getGuesses($row, $char, $default = ' ')
    {
        return self::getInstance()->guesses[$row][$char] ?? $default;
    }

    public static function getRound()
    {
        return self::getInstance()->round;
    }

    public static function getScore($row, $char, $default = 0)
    {
        return self::getInstance()->scores[$row][$char] ?? $default;
    }

    public static function getMaxDisplay()
    {
        return self::getRound()->mode->getCurrent()['max_display'];
    }

    public static function getMaxLength()
    {
        return self::getRound()->mode->getCurrent()['max_length'];
    }

    public static function getMaxTries()
    {
        return self::getRound()->mode->getCurrent()['max_tries'];
    }

    public static function getState()
    {
        return self::getRound()->state;
    }

    public static function getTheme(string $style)
    {
        return self::getRound()->render->theme->get($style);
    }

    public static function getTries()
    {
        return self::getRound()->tries;
    }

    public static function getWord()
    {
        return self::getRound()->word;
    }

    /**
     * https://www.php.net/manual/en/function.is-bool.php
     * Check "Booleanic" Conditions :)
     *
     * @param  [mixed]  $variable  Can be anything (string, bol, integer, etc.)
     * @return [boolean]           Returns TRUE  for "1", "true", "on" and "yes"
     *                             Returns FALSE for "0", "false", "off" and "no"
     *                             Returns NULL otherwise.
     */
    public static function isEnabled($variable)
    {
        if (!isset($variable))
            return null;

        return filter_var($variable, FILTER_VALIDATE_BOOLEAN, FILTER_NULL_ON_FAILURE);
    }

    public static function isDebug()
    {
        return self::isEnabled(self::getenv('DEBUG'));
    }

    public static function keyboardInput()
    {
        // https://stackoverflow.com/a/3684565
        system("stty -icanon");

        while ($c = fread(STDIN, 1)) {
            return $c;
        }
    }

    public static function loadEnv()
    {
        $dotenv = \Dotenv\Dotenv::createImmutable(dirname(__DIR__));
        $dotenv->load();

        return $dotenv;
    }

    public static function removeLastGuess()
    {
        array_pop(self::getInstance()->guesses);
    }
}
