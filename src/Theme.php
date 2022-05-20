<?php

declare(strict_types=1);

namespace CarmeloSantana\PHPWordle;

class Theme
{
    public array $default = [
        'answer' => ['text-neutral-900', 'bg-neutral-50'],
        'logo' => ['text-neutral-50', ''],
        'tile-0' => ['text-neutral-50', 'bg-slate-700'],
        'tile-1' => ['text-neutral-50', 'bg-amber-500'],
        'tile-2' => ['text-neutral-50', 'bg-emerald-500'],
    ];

    public function get(string $style)
    {
        return implode(' ', $this->default[$style]);
    }

    public function getTile(int $score)
    {
        return $this->get('tile-' . $score);
    }
}
