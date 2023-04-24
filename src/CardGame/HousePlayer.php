<?php

namespace App\CardGame;

use App\Card\CardHand;

class HousePlayer extends Player
{
    public function __construct()
    {
        parent::__construct();
    }

    public function setHousePlayer(
        string $name = "House"
    ): void {
        $this->name = $name;
    }
}
