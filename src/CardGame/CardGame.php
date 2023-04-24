<?php

namespace App\CardGame;

use App\Card\DeckOfCards;
use App\Card\CardHand;
use App\CardGame\Player;
use App\CardGame\HousePlayer;
use App\CardGame\GameStats;

class CardGame
{
    public object $house;
    public object $player;
    public object $deck;
    public object $gamestats;
    public bool $done;
    public string|null $winner;

    public int $sum;
    /**
     * @var array<object>
     */
    public array $values;

    public function __construct()
    {
        $this->deck = new DeckOfCards();
        $this->player = new Player();
        $this->house = new HousePlayer();
        $this->gamestats = new GameStats();
        $this->done = false;
        $this->winner = null;
    }

    /**
     * @return array<string,array<mixed>|bool|string|null>
     */
    public function play()
    {
        $data = [
            "house" => [
                "name" => $this->house->name,
                "hand" => $this->house->hand->getHandAsString(),
                "sum" => $this->getPlayerHandSum($this->house->hand),
                "under" => $this->checkPlayerHand($this->house),
                "percentage" => $this->getHouseDrawPercentage()
            ],
            "player" => [
                "name" => $this->player->name,
                "hand" => $this->player->hand->getHandAsString(),
                "sum" => $this->getPlayerHandSum($this->player->hand),
                "under" => $this->checkPlayerHand($this->player),
                "percentage" => $this->getPlayerDrawPercentage()
            ],
            "deck" => [
                "deck" => $this->deck->getDeckAsString(),
                "deckLength" => $this->deck->getDeckLength(),
                "cardLeft" => ($this->deck->getDeckLength() > 0)
            ],
            "gamestats" => $this->getGameStats(),
            "done" => $this->done,
            "winner" => $this->winner
        ];

        return $data;
    }

    public function init(): void
    {
        $this->deck->init();
        $this->deck->shuffle();

        $this->player->setPlayer();
        $this->house->setHousePlayer();
    }

    public function reset(): void
    {
        $this->house->hand->resetHand();

        $this->player->hand->resetHand();

        $this->unsetGameDone();
    }

    public function drawCard(
        DeckOfCards $deck,
        Player|Houseplayer $player
    ): void {
        $player->draw($deck);
    }

    public function houseDraw(): void
    {
        while ($this->getHouseDrawPercentage() >= 50) {
            $this->house->hand->add($this->deck);
        }
    }

    public function checkPlayerHand(
        Player|Houseplayer $player
    ): bool {
        return ($player->getPlayerSum() <= 21);
    }

    public function getPlayerHandSum(
        CardHand $playerHand
    ): int {
        $sum = 0;

        $values = $playerHand->getHandValues();

        rsort($values);

        foreach ($values as $value) {
            if ($sum < 9 && $value == 1) {
                $sum += 14;
                continue;
            }
            $sum += $value;
        }

        return $sum;
    }

    /**
     * @return array<object>
     */
    public function getPlayerHandAsString(
        Player|Houseplayer $player
    ): array {
        return $player->getHandAsString();
    }

    public function setGameDone(): void
    {
        $this->done = true;
    }

    public function unsetGameDone(): void
    {
        $this->done = false;
    }
    /**
     * @return array<object>
     */
    public function getGameStats(): array
    {
        $this->gamestats->setDeckStats($this->deck);
        return $this->gamestats->getDeckStatsAsString($this->deck);
    }

    public function getPlayerDrawPercentage(): float|null
    {
        return $this->gamestats->getPlayerDrawPercentage($this->deck, $this->player->hand);
    }

    public function getHouseDrawPercentage(): float|null
    {
        return $this->gamestats->getPlayerDrawPercentage($this->deck, $this->house->hand);
    }

    public function setWinner(): void
    {
        switch ($this) {
            case !$this->checkPlayerHand($this->player):
                $this->winner = $this->house->name;
                break;
            case !$this->checkPlayerHand($this->house):
                $this->winner = $this->player->name;
                break;
            case ($this->player->hand->getHandSum() <= $this->house->hand->getHandSum()):
                $this->winner = $this->house->name;
                break;
            case ($this->player->hand->getHandSum() > $this->house->hand->getHandSum()):
                $this->winner = $this->player->name;
                break;
        }
    }
}
