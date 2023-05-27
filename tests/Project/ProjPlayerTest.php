<?php

namespace App\Project;

use PHPUnit\Framework\TestCase;
use App\Card\CardGraphic;

/**
 * Test cases for class in ProjPlayer.
 */
class ProjPlayerTest extends TestCase
{
    /**
     * Construct object and verify that the object has the expected
     * properties, use no arguments.
     */
    public function testCreateProjPlayerNoArguments()
    {
        $player = new ProjPlayer();
        $this->assertInstanceOf("\App\Project\ProjPlayer", $player);
    }

    /**
     * Test get set player with no arguments
     */
    public function testSetProjPlayerNoArguments()
    {
        $player = new ProjPlayer();
        $player->setPlayer();

        $name = $player->name;

        $balance = $player->wallet->getBalance();

        $this->assertEquals("Player 1", $name);

        $this->assertEquals(100, $balance);
    }

    /**
     * Test get set player with arguments
     */
    public function testSetProjPlayerArguments()
    {
        $player = new ProjPlayer();
        $player->setPlayer("Test", 150);

        $name = $player->name;

        $balance = $player->wallet->getBalance();

        $this->assertEquals("Test", $name);

        $this->assertEquals(150, $balance);
    }

    /**
     * Test get set CardHand in player Hands
     */
    public function testSetPlayerHand()
    {
        $player = new ProjPlayer();
        $player->setPlayer();

        $deck = new ProjDeckOfCards();

        $deck->init();

        $card = $deck->draw();

        $player->addHand(10, $card);

        $hands = $player->getHands();

        $handsLength = count($hands);

        $this->assertEquals(1, $handsLength);
    }

    /**
     * Test get set CardHand without bet in player Hands
     */
    public function testAddHandWithoutBet()
    {
        $player = new ProjPlayer();
        $player->setPlayer();

        $player->addHandWithoutBet();

        $hands = $player->getHands();

        $handsLength = count($hands);

        $this->assertEquals(1, $handsLength);
    }

    /**
     * Test draw Card to Hands without bet in player
     */
    public function testDrawCardWithoutBet()
    {
        $player = new ProjPlayer();
        $player->setPlayer();

        $deck = new ProjDeckOfCards();

        $deck->init();

        $player->addHandWithoutBet();

        $player->drawWithoutBet($deck);

        $hands = $player->getHands();

        $handLength = count($hands[0]->getHandAsString());

        $this->assertEquals(1, $handLength);
    }

    /**
     * Test get reset player Hands
     */
    public function testResetPlayerHand()
    {
        $player = new ProjPlayer();
        $player->setPlayer();

        $deck = new ProjDeckOfCards();

        $deck->init();

        $card = $deck->draw();

        $player->addHand(10, $card);

        $player->resetPlayerHands();

        $hands = $player->getHands();

        $handsLength = count($hands);

        $this->assertEquals(0, $handsLength);
    }

    /**
     * Test get active player Hands
     */
    public function testGetActivePlayerHand()
    {
        $player = new ProjPlayer();
        $player->setPlayer();

        $deck = new ProjDeckOfCards();

        $deck->init();

        $card = $deck->draw();

        $player->addHand(10, $card);

        $card = $deck->draw();

        $player->addHand(10, $card);

        $activeHands = $player->getActiveHands();

        $handsLength = count($activeHands);

        $this->assertEquals(2, $handsLength);
    }

    /**
     * Test get active player Hands
     */
    public function testGetActivePlayerHandIndex()
    {
        $player = new ProjPlayer();
        $player->setPlayer();

        $deck = new ProjDeckOfCards();

        $deck->init();

        $card = $deck->draw();

        $player->addHand(10, $card);

        $card = $deck->draw();

        $player->addHand(10, $card);

        $player->hold();

        $handIndex = $player->getActiveHandIndex();

        $this->assertEquals(0, $handIndex);
    }

    /**
     * Test get done status
     */
    public function testCheckPlayerDone()
    {
        $player = new ProjPlayer();
        $player->setPlayer();

        $deck = new ProjDeckOfCards();

        $deck->init();

        $card = $deck->draw();

        $player->addHand(10, $card);

        $card = $deck->draw();

        $player->addHand(10, $card);

        $player->hold();

        $done = $player->checkPlayerDone();

        $this->assertEquals(false, $done);

        $player->hold();

        $done = $player->checkPlayerDone();

        $this->assertEquals(true, $done);
    }

    /**
     * Test split player hand
     */
    public function testSplitPlayerHand()
    {
        $player = new ProjPlayer();
        $player->setPlayer();

        $deck = new ProjDeckOfCards();

        $deck->init();

        $card = $deck->draw();

        $player->addHand(10, $card);

        $player->draw($deck);

        $player->draw($deck);

        $player->splitPlayerHand(0);

        $hands = $player->getCountOfHands();

        $this->assertEquals(2, $hands);
    }

    /**
     * Test return hands as string, sum, bet and if splitable
     */
    public function testReturnAsStringAndSumAndBetPlayerHand()
    {
        $player = new ProjPlayer();
        $player->setPlayer();

        $deck = new ProjDeckOfCards();

        $deck->init();

        $card = $deck->draw();

        $player->addHand(10, $card);

        $player->addHand(10, $card);

        $player->draw($deck);

        $player->draw($deck);

        $res = $player->getHandsAsStringAndSumAndBet();

        $this->assertIsArray($res);
    }

    /**
     * Test get CardHand bet
     */
    public function testGetPlayerCardHandBet()
    {
        $player = new ProjPlayer();
        $player->setPlayer();

        $deck = new ProjDeckOfCards();

        $deck->init();

        $card = $deck->draw();

        $player->addHand(10, $card);

        $bet = $player->getCardHandBet($player->hands[0]);

        $this->assertEquals(10, $bet);
    }

    /**
     * Test sum of Player Hands
     */
    public function testSumPlayerHands()
    {
        $player = new ProjPlayer();
        $player->setPlayer();

        $deck = new ProjDeckOfCards();

        $deck->init();

        $card = new CardGraphic();

        $card->setCard("spades", 2);

        $player->addHand(10, $card);
        $player->addHand(10, $card);

        $sum = $player->getTotalHandSums();

        $this->assertEquals(4, $sum);
    }

    /**
     * Test Player Hand Sum
     */
    public function testSumsOfPlayerHands()
    {
        $player = new ProjPlayer();
        $player->setPlayer();

        $deck = new ProjDeckOfCards();

        $deck->init();

        $card = new CardGraphic();

        $card->setCard("spades", 2);

        $player->addHand(10, $card);
        $player->addHand(10, $card);

        $sums = $player->getHandSums();

        $this->assertIsArray($sums);
    }
}
