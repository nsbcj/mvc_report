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

    /**
     * Constructor method creating properties containing objects deck, player, house and gamestats. Keeps track of is round is done and last round winner.
     */
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
     * Method creating associative array containing state of the game. Contains details about player and house to keep track of score.
     * @return array<string,array<mixed>|bool|string|null>
     */
    public function play(): array
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

    /**
     * Initiates and shuffles the deck and sets name for player and house.
     */
    public function init(): void
    {
        $this->deck->init();
        $this->deck->shuffle();

        $this->player->setPlayer();
        $this->house->setHousePlayer();
    }

    /**
     * Resets player and house hands. Initiates new round by setting $this->done to false.
     */
    public function reset(): void
    {
        $this->house->hand->resetHand();

        $this->player->hand->resetHand();

        $this->unsetGameDone();
    }

    /**
     * Draws card from object deck and adding it to player or house.
     */
    public function drawCard(
        DeckOfCards $deck,
        Player|Houseplayer $player
    ): void {
        $player->draw($deck);
    }

    /**
     * Calculating if house should draw more cards, depending on draw percentage. House is set to draw if drawpercentage is equal to or greater than 50%.
     */
    public function houseDraw(): void
    {
        while ($this->getHouseDrawPercentage() >= 50) {
            $this->house->hand->add($this->deck);
        }
    }

    /**
     * Calculating if house should draw more cards, depending on draw percentage. House is set to draw if drawpercentage is equal to or greater than 50%.
     */
    public function houseDrawProj(): void
    {
        while ($this->getHouseDrawPercentage() >= 50) {
            $this->house->hand->add($this->deck);
        }
    }

    /**
     * Checks if player or house hand has att total sum less or equal to 21. Returns boolean.
     */
    public function checkPlayerHand(
        Player|Houseplayer $player
    ): bool {
        return ($player->getPlayerSum() <= 21);
    }

    /**
     * Returns integer based on total sum of a CardHand.
     */
    public function getPlayerHandSum(
        CardHand $playerHand
    ): int {
        $sum = 0;

        $values = $playerHand->getHandValues();

        rsort($values);

        foreach ($values as $value) {
            if ($sum < 8 && $value == 1) {
                $sum += 14;
                continue;
            }
            $sum += $value;
        }

        return $sum;
    }

    /**
    * Returns player or house CardHand as a string.
     * @return array<object>
     */
    public function getPlayerHandAsString(
        Player|Houseplayer $player
    ): array {
        return $player->getHandAsString();
    }

    /**
     * Ends current round by setting $this->done to true.
     */
    public function setGameDone(): void
    {
        $this->done = true;
    }

    /**
     * Starts new round by setting $this->done to false.
     */
    public function unsetGameDone(): void
    {
        $this->done = false;
    }
    /**
    * Returns stats about Cards left in DeckOfCards.
     * @return array<object>
     */
    public function getGameStats(): array
    {
        $this->gamestats->setDeckStats($this->deck);
        return $this->gamestats->getDeckStatsAsString($this->deck);
    }

    /**
     * Gets a percentage based on probability to not get over 21 after the next Card is drawed.
     */
    public function getPlayerDrawPercentage(): float|null
    {
        return $this->gamestats->getPlayerDrawPercentage($this->deck, $this->player->hand);
    }

    /**
     * Gets a percentage based on probability to not get over 21 after the next Card is drawed.
     */
    public function getHouseDrawPercentage(): float|null
    {
        return $this->gamestats->getPlayerDrawPercentage($this->deck, $this->house->hand);
    }

    /**
     * Sets a string to show winner of the last round.
     */
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
