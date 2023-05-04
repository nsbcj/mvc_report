<?php

namespace App\CardGame;

use PHPUnit\Framework\TestCase;

/**
 * Test cases for class CardGame.
 */
class PlayerTest extends TestCase
{
    /**
     * Construct object and verify that the object has the expected
     * properties, use no arguments.
     */
    public function testCreatePlayerNoArguments()
    {
        $player = new Player();
        $this->assertInstanceOf("\App\CardGame\Player", $player);
    }

    /**
     * Test set Player name.
     */
    public function testPlayerName()
    {
        $player = new Player();

        $player->setPlayer("Player 2");

        $this->assertEquals("Player 2", $player->name);
    }

    /**
     * Test draw Player card.
     */
    public function testPlayerDrawCard()
    {
        $game = new CardGame();

        $player = new Player();

        $game->init();

        $player->draw($game->deck);

        $this->assertGreaterThan(0, $player->getPlayerSum());
    }

    /**
     * Test get Player Hand as string.
     */
    public function testPlayerHandAsString()
    {
        $game = new CardGame();

        $player = new Player();

        $game->init();

        $player->draw($game->deck);

        $playerHand = $player->getHandAsString();

        $count = count($playerHand);

        $this->assertEquals(1, $count);
    }
}
