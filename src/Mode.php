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
    ];

    // All modes available during runtime.
    private array $modes = [];

    // Standard game modes.
    private array $standard = [
        [
            'name' => 'Daily',
            'description' => 'Daily php-Wordle with shared community seed.',
            'seed' => 'seedDaily',
        ],
        [
            'name' => 'Trainer',
            'description' => 'Unlimited matches!',
            'max_tries' => -1,
        ],
    ];

    /**
     * Initialize game modes. 
     *
     * @return void
     */
    public function __construct()
    {
        $this->add();
    }

    /**
     * Builds functional game modes merging default values.
     *
     * @return void
     */
    public function add(): void
    {
        $c = 0;
        foreach ($this->standard as $mode) {
            $tmp = array_merge($this->defaults, $mode);
            if (isset($tmp['seed'])) {
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

    /**
     * Generates seed for unified daily game.
     *
     * @return int
     */
    public function seedDaily(): int
    {
        return strtotime(gmdate('Ymd'));
    }

    public function set(int $id): void
    {
        $this->mode = $id;
    }
}
