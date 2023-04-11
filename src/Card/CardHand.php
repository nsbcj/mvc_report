<?php

namespace App\Card;

class CardHand
{
    protected $series;

    public function __construct()
    {
        $this->series = [];
    }

    public function add(DeckOfCards $object): void
    {
        $this->series[] = $object->draw();
    }

    public function getHandAsString(): array
    {
        $values = [];
        foreach ($this->series as $value) {
            $values[] = $value->getAsString();
        }
        return $values;
    }
}
