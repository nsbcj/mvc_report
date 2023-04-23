<?php

namespace App\CardGame;

use App\Card\CardHand;
use App\Card\DeckOfCards;

class Player
{
    public string|null $name;
    public object $hand;

    public function __construct()
    {
        $this->name = null;
        $this->hand = new CardHand();
    }

    public function setPlayer(
        string $name = "Player 1"
    ): void {
        $this->name = $name;
    }

    public function draw(
        DeckOfCards $deck
    ): void {
        $this->hand->add($deck);
    }

    public function getPlayerSum(): int
    {
        return $this->hand->getHandSum();
    }

    /**
     * @return array<object>
     */
    public function getHandAsString(): array
    {
        return $this->hand->getHandAsString();
    }
}
