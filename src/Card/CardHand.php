<?php

namespace App\Card;

class CardHand
{
    /**
     * @var array<object>
     */
    protected array $series;

    public function __construct()
    {
        $this->series = [];
    }

    public function add(DeckOfCards $object): void
    {
        $this->series[] = $object->draw();
    }

    public function resetHand(): void
    {
        $this->series = [];
    }

    /**
     * @method int getCardValue()
     */
    public function getHandSum(): int
    {
        $sum = 0;
        foreach ($this->series as $value) {
            $sum += $value->getCardValue();
        }
        return $sum;
    }

    /**
     * @return array<object>
     */
    public function getHandValues(): array
    {
        $values = [];
        foreach ($this->series as $value) {
            $cardValue = $value->getCardValue();
            array_push($values, $cardValue);
        }
        return $values;
    }

    /**
     * @return array<string>
     */
    public function getHandAsString(): array
    {
        $values = [];
        foreach ($this->series as $value) {
            $values[] = $value->getAsString();
        }
        return $values;
    }
}
