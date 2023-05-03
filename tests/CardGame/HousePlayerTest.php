<?php

namespace App\CardGame;

use PHPUnit\Framework\TestCase;

/**
 * Test cases for class CardGame.
 */
class HousePlayerTest extends TestCase
{
    /**
     * Construct object and verify that the object has the expected
     * properties, use no arguments.
     */
    public function testCreateHousePlayerNoArguments()
    {
        $housePlayer = new HousePlayer();
        $this->assertInstanceOf("\App\CardGame\HousePlayer", $housePlayer);
    }
}
