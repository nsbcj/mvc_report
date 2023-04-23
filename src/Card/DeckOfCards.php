<?php

namespace App\Card;

use App\Card\CardGraphic;

class DeckOfCards
{
    /**
     * @var array<object>
     */
    public array $series;
    /**
     * @var array<string>
     */
    protected array $types = [
        "hearts",
        "diamonds",
        "clubs",
        "spades"
    ];
    protected int $countbytype = 13;

    public function __construct()
    {
        $this->series = [];
    }

    private function addCard(string $type, int $value): void
    {
        $card = new CardGraphic();
        $card->setCard($type, $value);
        $this->series[] = $card;
    }

    public function init(): void
    {
        foreach ($this->types as $type) {
            for ($i=1; $i <= $this->countbytype ; $i++) {
                $this->addCard($type, $i);
            }
        }
    }

    public function shuffle(): void
    {
        shuffle($this->series);
    }

    public function draw(): object
    {
        return array_pop($this->series);
    }

    /**
     * @return int
     */
    public function getDeckLength(): int
    {
        return count($this->series);
    }

    /**
     * @return array<object>
     */
    public function getDeck(): array
    {
        return $this->series;
    }

    /**
     * @return array<object>
     */
    public function getDeckValues(): array
    {
        $values = [];
        foreach ($this->series as $value) {
            $cardValue = $value->getCardValue();
            array_push($values, $cardValue);
        }
        return $values;
    }

    /**
     * @return array<object>
     */
    public function getDeckAsString(): array
    {
        $values = [];
        foreach ($this->series as $value) {
            $values[] = $value->getAsString();
        }
        return $values;
    }
}
