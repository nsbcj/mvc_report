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
}
