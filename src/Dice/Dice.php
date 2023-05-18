<?php

namespace App\Dice;

use App\Dice\Dice;

class Dice
{
    protected int|null $value;

    public function __construct()
    {
        $this->value = null;
    }

    public function roll(): int
    {
        $this->value = random_int(1, 6);
        return $this->value;
    }

    public function getValue(): ?int
    {
        return $this->value;
    }
}
