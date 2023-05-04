<?php

namespace App\CardGame;

use PHPUnit\Framework\TestCase;

/**
 * Test cases for class CardGame.
 */
class CardGameStatsTest extends TestCase
{
    /**
     * Construct object and verify that the object has the expected
     * properties, use no arguments.
     */
    public function testCreateCardGameStatsNoArguments()
    {
        $gameStats = new GameStats();
        $this->assertInstanceOf("\App\CardGame\GameStats", $gameStats);
    }

    /**
     * Test get player draw percentage
     */
    public function testGetPlayerPercentage()
    {
        $game = new CardGame();
        $gameStats = new GameStats();

        $game->init();

        $game->drawCard($game->deck, $game->player);

        $gameStats->setDeckStats($game->deck);

        $percentage = $gameStats->getPlayerDrawPercentage($game->deck, $game->player->hand);

        $this->assertGreaterThan(0, $percentage);
    }

    /**
     * Test get player deckstat as string
     */
    public function testGetGameStatsAsString()
    {
        $game = new CardGame();
        $gameStats = new GameStats();

        $game->init();

        $game->drawCard($game->deck, $game->player);

        $gameStats->setDeckStats($game->deck);

        $percentage = $gameStats->getDeckStatsAsString($game->deck);

        $lengthPercentage = count($percentage);

        $this->assertEquals(13, $lengthPercentage);
    }

    /**
     * Test get DeckStats
     */
    public function testSetDeckStats()
    {
        $game = new CardGame();
        $gameStats = new GameStats();

        $game->init();

        $game->drawCard($game->deck, $game->player);

        $gameStats->setDeckStats($game->deck);

        $gameStats = $gameStats->getDeckStats();

        $count = count($gameStats);

        $this->assertEquals(13, $count);
    }
}
