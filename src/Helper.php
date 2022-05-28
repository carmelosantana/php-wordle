<?php

declare(strict_types=1);

namespace CarmeloSantana\PHPWordle;

class Helper
{
    public static function addGuess(string $guess): void
    {
        $GLOBALS['GAME']->guesses[] = str_split($guess);
    }

    public static function addScore(array $score): void
    {
        $GLOBALS['GAME']->scores[] = $score;
    }

    public static function getInstance(): object
    {
        return $GLOBALS['GAME'];
    }

    public static function getEnv(string $key, $default = false)
    {
        return $_ENV[$key] ?? $default;
    }

    public static function getGuess(string $default = ''): string
    {
        return self::getInstance()->guess ?? $default;
    }

    public static function getGuesses(int $row, int $char, string $default = ' '): string
    {
        return self::getInstance()->guesses[$row][$char] ?? $default;
    }

    public static function getRound(): object
    {
        return self::getInstance()->round;
    }

    public static function getScore(int $row, int $char, $default = 0): int
    {
        return self::getInstance()->scores[$row][$char] ?? $default;
    }

    public static function getMaxDisplay(): int
    {
        return self::getRound()->mode->getCurrent()['max_display'];
    }

    public static function getMaxLength(): int
    {
        return self::getRound()->mode->getCurrent()['max_length'];
    }

    public static function getMaxTries(): int
    {
        return self::getRound()->mode->getCurrent()['max_tries'];
    }

    public static function getState()
    {
        return self::getRound()->state;
    }

    public static function getTheme(string $style): string
    {
        return self::getRound()->render->theme->get($style);
    }

    public static function getTries(): int
    {
        return self::getRound()->tries;
    }

    public static function getWord(): string
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

    public static function isDebug(): bool
    {
        return self::isEnabled(self::getenv('DEBUG'));
    }

    public static function keyboardInput(): string
    {
        // https://stackoverflow.com/a/3684565
        system("stty -icanon");

        while ($c = fread(STDIN, 1)) {
            return $c;
        }
    }

    public static function loadEnv(): object
    {
        $dotenv = \Dotenv\Dotenv::createImmutable(dirname(__DIR__));
        $dotenv->load();

        return $dotenv;
    }

    public static function removeLastGuess(): void
    {
        array_pop(self::getInstance()->guesses);
    }
}
