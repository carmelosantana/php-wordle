<?php

declare(strict_types=1);

namespace CarmeloSantana\PHPWordle;

require_once __DIR__ . '/vendor/autoload.php';

$GLOBALS['GAME'] = new Game();

$GLOBALS['GAME']->run();
