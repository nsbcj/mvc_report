<?php

namespace App\Dice;

class DiceGraphic extends Dice
{
    /**
     * @var array<string>
     */
    private array $representation = [
        '⚀',
        '⚁',
        '⚂',
        '⚃',
        '⚄',
        '⚅',
    ];

    public function __construct()
    {
        parent::__construct();
    }

    public function getAsString(): string
    {
        return $this->representation[$this->getValue() - 1];
    }
}
