<?php

declare(strict_types=1);

namespace CarmeloSantana\PHPWordle;

class Theme
{
    public array $default = [
        'logo-bg' => 'bg-neutral-50',
        'logo-text' => 'text-neutral-900',
        'tile-0-bg' => 'bg-slate-700',
        'tile-0-text' => 'text-neutral-50',
        'tile-1-bg' => 'bg-amber-500',
        'tile-1-text' => 'text-neutral-50',
        'tile-2-bg' => 'bg-emerald-500',
        'tile-2-text' => 'text-neutral-50',
    ];

    public function get(string $style)
    {
        return $this->default[$style];
    }

    public function getTileBG(int $score)
    {
        return $this->get('tile-' . $score . '-bg');
    }

    public function getTileText(int $score)
    {
        return $this->get('tile-' . $score . '-text');
    }
}
