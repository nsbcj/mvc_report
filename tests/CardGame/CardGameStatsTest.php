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
}
