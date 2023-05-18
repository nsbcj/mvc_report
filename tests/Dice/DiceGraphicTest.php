<?php

namespace App\Dice;

use PHPUnit\Framework\TestCase;

/**
 * Test cases for class Guess.
 */
class DiceGraphicTest extends TestCase
{
    /**
     * Constructs an object an returns a string with representation of value.
     */
    public function testReturnDiceAsString()
    {
        $dice = new DiceGraphic();
        $dice->roll();
        $diceGraphic = $dice->getAsString();
        $this->assertIsString($diceGraphic);
    }
}
