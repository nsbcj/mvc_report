<?php

namespace App\Project;

use App\Card\CardHand;
use App\Card\CardGraphic;
use App\Project\ProjDeckOfCards;
use App\Project\ProjWallet;

class ProjPlayer
{
    public string $name;
    /**
     * @var array<object>
     */
    public array $hands;
    public object $wallet;

    /**
     * method constructing ProjPlayer object
     */
    public function __construct()
    {
        $this->name = "";
        $this->hands = [];
        $this->wallet = new ProjWallet();
    }

    /**
     * method setting ProjPlayer name and balance
     */
    public function setPlayer(
        string $name = "Player 1",
        int $amount = 100
    ): void {
        $this->name = $name;
        $this->wallet->addBalance($amount);
    }

    /**
     * method reseting ProjPlayer hands
     */
    public function resetPlayerHands(): void
    {
        $this->hands = [];
    }

    /**
     * method getting ProjPlayer hands
     * @return array<object>
     */
    public function getHands(): array
    {
        return $this->hands;
    }

    /**
     * method adding CardHand with bet to hands. Optional parameter to set specific CardGrapic
     */
    public function addHand(
        int $bet,
        ?CardGraphic $card = null
    ): void {
        $cardHand = new CardHand();
        $currentBalance = $this->wallet->getBalance();
        if ($currentBalance >= $bet) {
            $cardHand->setBet($bet);
        }
        if (isset($card)) {
            $cardHand->setCard($card);
        }
        $this->hands[] = $cardHand;
    }

    /**
     * method returning array with CardHands still in play
     * @return array<object>
     */
    public function getActiveHands(): array
    {
        $res = [];
        foreach ($this->hands as $hand) {
            if ($hand->active) {
                $res[] = $hand;
            }
        }
        return $res;
    }

    /**
     * method getting index of current CardHand in play
     */
    public function getActiveHandIndex(): ?int
    {
        $countActiveHands = count($this->getActiveHands());
        if ($countActiveHands > 0) {
            return $countActiveHands - 1;
        }
        return -1;
    }

    /**
     * method checking if any active CardHands still in play
     */
    public function checkPlayerDone(): bool
    {
        return ($this->getCountOfHands() > 0 && $this->getActiveHandIndex() == -1);
    }

    public function draw(
        ProjDeckOfCards $deck
    ): void {
        $start = $this->getCountOfHands() - 1;
        for ($i=$start; $i >= 0; $i--) {
            if ($this->hands[$i]->active) {
                $this->hands[$i]->add($deck);
                break;
            }
        }
    }

    /**
     * method adding a CardHand to hands without a bet
     */
    public function addHandWithoutBet(): void
    {
        $cardHand = new CardHand();
        $this->hands[] = $cardHand;
    }

    /**
     * method drawing Card from CardHand in hands without a bet
     */
    public function drawWithoutBet(
        ProjDeckOfCards $deck
    ): void {
        $start = $this->getCountOfHands() - 1;
        for ($i=$start; $i >= 0; $i--) {
            $this->hands[$i]->add($deck);
        }
    }

    /**
     * method to hold CardHand
     */
    public function hold(): void
    {
        $start = $this->getCountOfHands() - 1;
        for ($i=$start; $i >= 0; $i--) {
            if ($this->hands[$i]->active) {
                $this->hands[$i]->hold();
                break;
            }
        }
    }

    /**
     * method splitting activehand. Adds a new CardHand at active position and pops Card from splitted CardHand. Popped Card is inserted into the new CardHand
     * @return void
     */
    public function splitPlayerHand(
        int $idx
    ): void {
        $activeHand = $this->hands[$idx];
        $first = $activeHand->getCards()[0];
        $second = $activeHand->getCards()[1];
        $this->hands[$idx]->resetHand();
        $this->hands[$idx]->setCard($first);
        $this->addHand($activeHand->bet, $second);
        $lastHand = array_pop($this->hands);
        array_splice($this->hands, $idx, 0, [$lastHand]);
    }

    /**
     * method getting sum of values in CardHand
     */
    public function getPlayerHandSum(
        CardHand $cardHand
    ): int {
        return $cardHand->getProjHandSum();
    }

    /**
     * method getting bet of CardHand
     * @return int
     */
    public function getCardHandBet(
        CardHand $cardHand
    ): int {
        return $cardHand->getBet();
    }

    /**
     * method returning CardHand as array of strings, the sum of Cards, the bets in CardHand and if the CardHand is splitable
     * @return array<int <0, max>, array <string, mixed>>
     */
    public function getHandsAsStringAndSumAndBet(): array
    {
        $res = [];

        foreach ($this->hands as $hand) {
            $res[] = [
                "handAsString" => $hand->getHandAsString(),
                "handAsSum" => $this->getPlayerHandSum($hand),
                "handBet" => $hand->getBet() ?? null,
                "splitable" => $hand->isSplitable()
            ];
        }

        return $res;
    }

    /**
     * method returning sums of CardHands in hands in an array.
     * @return array<int>
     */
    public function getHandSums(): array
    {
        $res = [];

        foreach ($this->hands as $hand) {
            $res[] = $hand->getProjHandSum();
        }

        return $res;
    }

    /**
     * method returning sum of all hands. Calculates sum of house hands.
     */
    public function getTotalHandSums(): int
    {
        $res = 0;

        foreach ($this->hands as $hand) {
            $res += $hand->getProjHandSum();
        }

        return $res;
    }

    /**
     * method returning count of CardHands in hands
     * @return int
     */
    public function getCountOfHands(): int
    {
        return count($this->hands);
    }
}
