<?php

namespace App\Dice;

class DiceHand
{
    protected $hand;

    public function __construct()
    {
        $this->hand = [];
    }

    public function add(Dice $dice): void
    {
        $this->hand[] = $dice;
    }

    public function roll(): void
    {
        foreach ($this->hand as $dice) {
            $dice->roll();
        }
    }

    public function getNumberOfDices(): int
    {
        return count($this->hand);
    }

    public function getValues(): array
    {
        $values = [];
        foreach ($this->hand as $dice) {
            $values[] = $dice->getValue();
        }
        return $values;
    }

    public function getString(): array
    {
        $values = [];
        foreach ($this->hand as $dice) {
            $values[] = $dice->getAsString();
        }
        return $values;
    }
}
