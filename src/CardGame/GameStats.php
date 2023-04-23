<?php

namespace App\CardGame;

use App\Card\CardHand;
use App\Card\DeckOfCards;

class GameStats
{
    /**
     * @var array<int<1, max>>
     */
    public array $deckStats;

    public function __construct()
    {
        $this->deckStats = [];
    }

    public function setDeckStats(
        DeckOfCards $deck
    ): void {
        $this->deckStats = array_count_values($deck->getDeckValues());
    }
    /**
     * @return array<int<0, max>, array<float>>
     */
    public function getDeckStatsAsString(
        DeckOfCards $deck
    ): array {
        $res = [];
        ksort($this->deckStats);
        foreach ($this->deckStats as $key => $value) {
            $percentage = round(($value / $deck->getDeckLength()) * 100, 1);
            array_push($res, [$key => $percentage]);
        }
        return $res;
    }

    public function getPlayerDrawPercentage(
        DeckOfCards $deck,
        CardHand $playerHand
    ): float|null {
        if ($deck->getDeckLength() == 0) {
            return null;
        }
        ksort($this->deckStats);
        $hand = $playerHand->getHandSum();
        if ($hand == 0) {
            return 100;
        }
        $max = 21;
        $diff = $max - $hand;
        $sum = 0;

        foreach ($this->deckStats as $key => $value) {
            $percentage = $value / $deck->getDeckLength();
            if ($key <= $diff) {
                $sum += $percentage;
            }
        }

        $sum = ($sum > 1) ? 1 : $sum;

        return round($sum * 100);
    }
}
