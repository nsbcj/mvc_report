<?php

namespace App\Project;

use App\Project\ProjDeckOfCards;
use App\Project\ProjPlayer;
use App\CardGame\HousePlayer;
use App\Card\CardHand;

class ProjGame
{
    public ?object $player;
    public ?object $house;
    public ?object $deck;
    /**
     * @var array<string, bool|float|int>
     */
    public ?array $winners;
    public bool $start;
    public bool $done;

    /**
     * Constructor method creating game for project.
     */
    public function __construct()
    {
        $this->player = null;
        $this->house = null;
        $this->deck = null;
        $this->winners = null;
        $this->start = false;
        $this->done = false;
    }

    /**
    * Method initiating a Game
    */
    public function init(): void
    {
        $this->player = new ProjPlayer();
        $this->house = new ProjPlayer();
        $this->deck = new ProjDeckOfCards();

        $this->deck->init();
        $this->deck->shuffle();
    }

    /**
     * Method setting game as started
     */
    public function start(): void
    {
        $this->start = true;
    }

    /**
     * Method setting game as stopped
     */
     public function stop(): void
     {
         $this->start = false;
     }

     /**
      * Method setting player game as done
      */
      public function setDone(): void
      {
          $this->done = true;
      }

      /**
       * Method setting player game as undone
       */
       public function setUnDone(): void
       {
           $this->done = false;
       }

       /**
        * autoPlay method for CardHand
        */
        public function autoPlay(): void
        {
            $sum = 0;

            while($sum < 17) {
                $this->house->drawWithoutBet($this->deck);

                $sum = $this->house->getTotalHandSums();
            }
        }

        /**
         * return if cardHand is winner
         * @return array<string, bool|float|int> res
         */
         public function checkWinner(
             CardHand $cardHand
         ): array {
             $res = [
                 "winner" => false,
                 "return" => 0,
                 "tie" => false
             ];
             $playerHandSum = $cardHand->getProjHandSum();
             $houseHandSum = $this->house->getTotalHandSums();
             $playerUnder = ($playerHandSum <= 21);
             $houseUnder = ($houseHandSum <= 21);
             $HandLengthIsTwo = (count($cardHand->getHandAsString()) == 2);
             switch ($cardHand) {
                 case !$playerUnder:
                     $res["winner"] = false;
                     break;
                 case ($HandLengthIsTwo && $playerHandSum == 21 && $houseHandSum != 21):
                     $res["winner"]= true;
                     $res["return"] = $cardHand->bet * 2.5;
                     break;
                 case !$houseUnder:
                     $res["winner"] = true;
                     $res["return"] = $cardHand->bet * 2;
                     break;
                 case ($playerHandSum > $houseHandSum):
                     $res["winner"] = true;
                     $res["return"] = $cardHand->bet * 2;
                     break;
                 case ($playerHandSum < $houseHandSum):
                     $res["winner"] = false;
                     break;
                 default:
                     $res["tie"] = true;
                     $res["return"] = $cardHand->bet;
                     break;
             }
             return $res;
         }

         /**
          * return winners for each hand
          */
          public function setWinners(): void
          {
              foreach ($this->player->hands as $hand) {
                  $this->winners[] = $this->checkWinner($hand);
                  $this->player->wallet->setBalance($this->checkWinner($hand)["return"]);
              }
          }
}
