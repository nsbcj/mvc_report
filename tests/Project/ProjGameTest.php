<?php

namespace App\Project;

use PHPUnit\Framework\TestCase;
use App\Card\CardGraphic;

/**
 * Test cases for class in ProjPlayer.
 */
class ProjGameTest extends TestCase
{
    /**
     * Construct object and verify that the object has the expected
     * properties, use no arguments.
     */
    public function testCreateProjGameNoArguments()
    {
        $game = new ProjGame();
        $this->assertInstanceOf("\App\Project\ProjGame", $game);
    }

    /**
     * Test initiating game
     */
    public function testInitProjGame()
    {
        $game = new ProjGame();
        $game->init();

        $this->assertInstanceOf("\App\Project\ProjPlayer", $game->player);

        $this->assertInstanceOf("\App\Project\ProjPlayer", $game->house);

        $this->assertInstanceOf("\App\Project\ProjDeckOfCards", $game->deck);
    }

    /**
     * Test start game
     */
    public function testStartProjGame()
    {
        $game = new ProjGame();
        $game->init();

        $game->start();

        $this->assertEquals(true, $game->start);
    }

    /**
     * Test start and stop game
     */
    public function testStartStopProjGame()
    {
        $game = new ProjGame();
        $game->init();

        $game->start();
        $game->stop();

        $this->assertEquals(false, $game->start);
    }

    /**
     * Test set game as Done
     */
    public function testSetDoneProjGame()
    {
        $game = new ProjGame();
        $game->init();

        $game->setDone();

        $this->assertEquals(true, $game->done);
    }

    /**
     * Test set game as Done
     */
    public function testSetUnDoneProjGame()
    {
        $game = new ProjGame();
        $game->init();

        $game->setDone();

        $game->setUnDone();

        $this->assertEquals(false, $game->done);
    }

    /**
     * Test autoPlay
     */
    public function testAutoPlayProjGame()
    {
        $game = new ProjGame();
        $game->init();

        $game->house->setPlayer();

        $game->house->addHandWithoutBet();

        $game->autoPlay();

        $total = $game->house->getTotalHandSums();

        $this->assertGreaterThan(17, $total);
    }

    /**
     * Test check winner if player is over 21
     */
    public function testCheckWinnerPlayerNotUnderProjGame()
    {
        $game = new ProjGame();
        $game->init();

        $card = new CardGraphic();

        $cardThird = new CardGraphic();

        $card->setCard("spades", 8);

        $cardThird->setCard("spades", 1);

        $game->house->setPlayer();

        $game->player->setPlayer();

        $game->house->addHandWithoutBet();

        $game->player->addHand(10, $card);

        $game->player->hands[0]->setCard($card);

        $game->player->hands[0]->setCard($card);

        $game->house->hands[0]->setCard($card);

        $game->house->hands[0]->setCard($cardThird);

        $res = $game->checkWinner($game->player->hands[0]);

        $this->assertEquals(false, $res["winner"]);

        $this->assertEquals(0, $res["return"]);

        $this->assertEquals(false, $res["tie"]);
    }

    /**
     * Test check winner if house is over 21
     */
    public function testCheckWinnerHouseNotUnderProjGame()
    {
        $game = new ProjGame();
        $game->init();

        $card = new CardGraphic();

        $card->setCard("spades", 8);

        $game->house->setPlayer();

        $game->player->setPlayer();

        $game->house->addHandWithoutBet();

        $game->player->addHand(10, $card);

        $game->player->hands[0]->setCard($card);

        $game->house->hands[0]->setCard($card);

        $game->house->hands[0]->setCard($card);

        $game->house->hands[0]->setCard($card);

        $res = $game->checkWinner($game->player->hands[0]);

        $this->assertEquals(true, $res["winner"]);

        $this->assertEquals(20, $res["return"]);

        $this->assertEquals(false, $res["tie"]);
    }

    /**
     * Test check winner if player has 21 and house not
     */
    public function testCheckWinnerPlayer21ProjGame()
    {
        $game = new ProjGame();
        $game->init();

        $card = new CardGraphic();

        $cardSecond = new CardGraphic();

        $cardThird = new CardGraphic();

        $card->setCard("spades", 8);

        $cardSecond->setCard("spades", 12);

        $cardThird->setCard("spades", 1);

        $game->house->setPlayer();

        $game->player->setPlayer();

        $game->house->addHandWithoutBet();

        $game->player->addHand(10, $cardSecond);

        $game->player->hands[0]->setCard($cardThird);

        $game->house->hands[0]->setCard($card);

        $game->house->hands[0]->setCard($cardThird);

        $res = $game->checkWinner($game->player->hands[0]);

        $this->assertEquals(true, $res["winner"]);

        $this->assertEquals(25, $res["return"]);

        $this->assertEquals(false, $res["tie"]);

        $game->house->hands[0]->setCard($card);

        $game->house->hands[0]->setCard($card);

        $res = $game->checkWinner($game->player->hands[0]);

        $this->assertEquals(true, $res["winner"]);

        $this->assertEquals(25, $res["return"]);

        $this->assertEquals(false, $res["tie"]);
    }

    /**
     * Test check winner if player/house under 21 and more than player/house
     */
    public function testCheckWinnerPlayerOrHouseGreaterProjGame()
    {
        $game = new ProjGame();
        $game->init();

        $card = new CardGraphic();

        $cardSecond = new CardGraphic();

        $cardThird = new CardGraphic();

        $card->setCard("spades", 8);

        $cardSecond->setCard("spades", 12);

        $cardThird->setCard("spades", 1);

        $game->house->setPlayer();

        $game->player->setPlayer();

        $game->house->addHandWithoutBet();

        $game->player->addHand(10, $cardSecond);

        $game->player->hands[0]->setCard($cardSecond);

        $game->house->hands[0]->setCard($card);

        $game->house->hands[0]->setCard($cardSecond);

        $res = $game->checkWinner($game->player->hands[0]);

        $this->assertEquals(true, $res["winner"]);

        $this->assertEquals(20, $res["return"]);

        $this->assertEquals(false, $res["tie"]);

        $game->house->hands[0]->setCard($cardThird);

        $game->house->hands[0]->setCard($cardThird);

        $game->house->hands[0]->setCard($cardThird);

        $res = $game->checkWinner($game->player->hands[0]);

        $this->assertEquals(false, $res["winner"]);

        $this->assertEquals(0, $res["return"]);

        $this->assertEquals(21, $game->house->hands[0]->getProjHandSum());

        $this->assertEquals(20, $game->player->hands[0]->getProjHandSum());

        $this->assertEquals(false, $res["tie"]);
    }

    /**
     * Test check winner if tie
     */
    public function testCheckWinnerPlayerAndHouseTied()
    {
        $game = new ProjGame();
        $game->init();

        $card = new CardGraphic();

        $cardSecond = new CardGraphic();

        $cardThird = new CardGraphic();

        $card->setCard("spades", 8);

        $cardSecond->setCard("spades", 12);

        $cardThird->setCard("spades", 1);

        $game->house->setPlayer();

        $game->player->setPlayer();

        $game->house->addHandWithoutBet();

        $game->player->addHand(10, $cardSecond);

        $game->player->hands[0]->setCard($cardSecond);

        $game->house->hands[0]->setCard($cardSecond);

        $game->house->hands[0]->setCard($cardSecond);

        $res = $game->checkWinner($game->player->hands[0]);

        $this->assertEquals(false, $res["winner"]);

        $this->assertEquals(10, $res["return"]);

        $this->assertEquals(true, $res["tie"]);
    }

    /**
     * Test set winner
     */
    public function testSetWinnerProj()
    {
        $game = new ProjGame();
        $game->init();

        $card = new CardGraphic();

        $cardSecond = new CardGraphic();

        $card->setCard("spades", 8);

        $cardSecond->setCard("spades", 12);

        $game->house->setPlayer();

        $game->player->setPlayer();

        $game->house->addHandWithoutBet();

        $game->player->addHand(10, $cardSecond);

        $game->player->wallet->withdrawBalance(10);

        $game->player->hands[0]->setCard($cardSecond);

        $game->house->hands[0]->setCard($cardSecond);

        $game->house->hands[0]->setCard($card);

        $game->setWinners();

        $this->assertIsArray($game->winners);

        $this->assertEquals(110, $game->player->wallet->getBalance());
    }
}
