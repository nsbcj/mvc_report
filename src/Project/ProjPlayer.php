<?php

namespace App\Project;

use App\Card\CardHand;
use App\Card\CardGraphic;
use App\Project\ProjDeckOfCards;
use App\Project\ProjWallet;

class ProjPlayer
{
    public string|null $name;
    /**
     * @var array<object>
     */
    public array $hands;
    public object $wallet;

    public function __construct()
    {
        $this->name = null;
        $this->hands = [];
        $this->wallet = new ProjWallet();
    }

    public function setPlayer(
        string $name = "Player 1",
        int $amount = 100
    ): void {
        $this->name = $name;
        $this->wallet->addBalance($amount);
    }

    public function resetPlayerHands(): void
    {
        $this->hands = [];
    }

    /**
     * @return array<object>
     */
    public function getHands(): array
    {
        return $this->hands;
    }

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

    public function getActiveHandIndex(): ?int
    {
        $countActiveHands = count($this->getActiveHands());
        if ($countActiveHands > 0) {
            return $countActiveHands - 1;
        }
        return -1;
    }

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

    public function addHandWithoutBet(): void
    {
        $cardHand = new CardHand();
        $this->hands[] = $cardHand;
    }

    public function drawWithoutBet(
        ProjDeckOfCards $deck
    ): void {
        $start = $this->getCountOfHands() - 1;
        for ($i=$start; $i >= 0; $i--) {
            $this->hands[$i]->add($deck);
        }
    }

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

    public function getPlayerHandSum(
        CardHand $cardHand
    ): int {
        return $cardHand->getProjHandSum();
    }

    /**
     * @return int
     */
    public function getCardHandBet(
        CardHand $cardHand
    ): int {
        return $cardHand->getBet();
    }

    /**
     * @return array<int<0, max>, array<string, mixed>>
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

    public function getTotalHandSums(): int
    {
        $res = 0;

        foreach ($this->hands as $hand) {
            $res += $hand->getProjHandSum();
        }

        return $res;
    }

    /**
     * @return int
     */
    public function getCountOfHands(): int
    {
        return count($this->hands);
    }
}
