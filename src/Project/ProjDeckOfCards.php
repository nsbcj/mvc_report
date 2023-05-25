<?php

namespace App\Project;

use App\Card\DeckOfCards;

class ProjDeckOfCards extends DeckOfCards
{
    public int $countOfDecks;

    /**
     * Constructor method creating deck for project. Deck is constructed based on DeckOfCards class.
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
    * Method initiating a ProjDeckOfCards with countOfDecks DeckOfCards
    */
    public function init(int $countOfDecks = 6): void
    {
        while ($countOfDecks > 0) {
            foreach ($this->types as $type) {
                for ($j=1; $j <= $this->countbytype; $j++) {
                    $this->addCard($type, $j);
                }
            }
            $countOfDecks--;
        }
    }
}
