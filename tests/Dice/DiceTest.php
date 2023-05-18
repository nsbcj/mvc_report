<?php

namespace App\Dice;

use PHPUnit\Framework\TestCase;

/**
 * Test cases for class Guess.
 */
class DiceTest extends TestCase
{
    /**
     * Construct object and verify that the object has the expected
     * properties, use no arguments.
     */
    public function testCreateDiceNoArguments()
    {
        $dice = new Dice();
        $this->assertInstanceOf("\App\Dice\Dice", $dice);
    }

    /**
     * Test rolling a Dice
     */
    public function testRollDiceAndGetValue()
    {
        $dice = new Dice();

        $dice->roll();

        $diceValue = $dice->getValue();

        $this->assertLessThan(7, $diceValue);

        $this->assertGreaterThan(0, $diceValue);
    }
}
