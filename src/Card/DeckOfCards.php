<?php

namespace App\Card;

use App\Card\CardGraphic;

class DeckOfCards
{
    public $series;
    protected $types = [
        "hearts",
        "diamonds",
        "clubs",
        "spades"
    ];
    protected $countbytype = 13;

    public function __construct()
    {
        $this->series = [];
    }

    private function addCard($type, $value): void
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

    public function getDeckLength(): int
    {
        return count($this->series);
    }

    public function getDeck(): array
    {
        return $this->series;
    }

    public function getDeckAsString(): array
    {
        $values = [];
        foreach ($this->series as $value) {
            $values[] = $value->getAsString();
        }
        return $values;
    }
}
