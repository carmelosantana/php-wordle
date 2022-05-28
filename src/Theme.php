<?php

declare(strict_types=1);

namespace CarmeloSantana\PHPWordle;

class Theme
{
    // Theme default values.
    public array $default = [
        'answer' => ['text-neutral-900', 'bg-neutral-50'],
        'logo' => ['text-neutral-50', ''],
        'tile-0' => ['text-neutral-50', 'bg-slate-700'],
        'tile-1' => ['text-neutral-50', 'bg-amber-500'],
        'tile-2' => ['text-neutral-50', 'bg-emerald-500'],
    ];
    
    /**
     * Get colors for element.
     *
     * @param string $style Style key
     *
     * @return array
     */
    public function get(string $style): string
    {
        return implode(' ', $this->default[$style]);
    }
    
    /**
     * Get tile color per score.
     *
     * @param int $score Tile score
     *
     * @return array
     */
    public function getTile(int $score): string
    {
        return $this->get('tile-' . $score);
    }
}
