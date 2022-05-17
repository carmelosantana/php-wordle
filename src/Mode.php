<?php

declare(strict_types=1);

namespace CarmeloSantana\PHPWordle;

class Mode
{
    // Mode default values.
    private array $defaults = [
        'name' => '',
        'description' => '',
        'max_length' => 5,
        'max_display' => 6,
        'max_tries' => 6,
        'seed' => 'seedDaily',
    ];

    // All modes available during runtime.
    private array $modes = [];

    // Standard game modes.
    private array $standard = [
        [
            'name' => 'Daily',
            'description' => 'Daily php-Wordle with shared community seed.',
        ],
        [
            'name' => 'Trainer',
            'description' => 'Unlimited matches!',
            'max_tries' => -1,
            'seed' => 0,
        ],
    ];

    public function __construct()
    {
        $this->add();
    }

    public function add()
    {
        $c = 0;
        foreach ($this->standard as $mode) {
            $tmp = array_merge($this->defaults, $mode);
            if ($tmp['seed']) {
                $tmp['seed'] = $this->{$tmp['seed']}();
            }
            $this->modes[] = $tmp;
            $c++;
        }
    }

    public function get()
    {
        return $this->modes[$this->mode];
    }

    public function getAll()
    {
        return $this->modes;
    }

    public function getCurrent()
    {
        return $this->modes[$this->mode];
    }

    public function seedDaily(): int
    {
        return strtotime(gmdate('Ymd'));
    }

    public function set(int $id): void
    {
        $this->mode = $id;
    }
}
