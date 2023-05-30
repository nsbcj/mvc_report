<?php

namespace App\Card;

use App\Project\ProjDeckOfCards;

class CardHand
{
    /**
     * @var array<object>
     */
    protected array $series;
    public int $bet;
    public bool $active;

    public function __construct()
    {
        $this->series = [];
        $this->bet = 0;
        $this->active = true;
    }

    public function add(
        ProjDeckOfCards|DeckOfCards $object
    ): void {
        $this->series[] = $object->draw();
    }

    public function setCard(
        CardGraphic $card
    ): void {
        $this->series[] = $card;
    }

    /**
     * @return array<object>
     */
    public function getCards(): array
    {
        return $this->series;
    }

    public function setBet(int $amount): void
    {
        $this->bet = $amount;
    }

    public function doubleBet(): void
    {
        $this->bet = $this->bet*2;
    }

    /**
     * @return int
     */
    public function getBet(): int
    {
        return $this->bet;
    }

    public function resetHand(): void
    {
        $this->series = [];
    }

    public function hold(): void
    {
        $this->active = false;
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
     * @method int getCardValue()
     */
    public function getProjHandSum(): int
    {
        $sum = 0;
        $values = $this->getHandValues();
        sort($values);
        foreach ($values as $value) {
            switch ($value) {
                case $value > 10:
                    $sum += 10;
                    break;
                case $value == 1 && $sum < 11:
                    $sum += 11;
                    break;
                default:
                    $sum += $value;
                    break;
            }
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

    /**
     * check if hand is splitable
     * @return bool
     */
     public function isSplitable(): bool
     {
         $handValues = $this->getHandValues();
         $handLengthIsTwo = (count($handValues) == 2);
         $res = ($handLengthIsTwo && $handValues[0] == $handValues[1]);

         return $res;
     }
}
