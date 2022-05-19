<?php

declare(strict_types=1);

namespace CarmeloSantana\PHPWordle;

enum State
{
    case Guessing;
    case Won;
    case Loss;
}
