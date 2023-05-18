<?php

namespace App\Dice;

use PHPUnit\Framework\TestCase;

/**
 * Test cases for class Guess.
 */
class DiceHandTest extends TestCase
{
    /**
     * Construct object and verify that the object has the expected
     * properties, use no arguments.
     */
    public function testCreateDiceHandNoArguments()
    {
        $diceHand = new DiceHand();
        $this->assertInstanceOf("\App\Dice\DiceHand", $diceHand);
    }

    /**
     * Test add a Dice to DiceHand and get number of Dices in DiceHand
     */
    public function testAddDiceToDiceHand()
    {
        $diceHand = new DiceHand();

        $dice = new Dice();

        $diceHand->add($dice);

        $diceCount = $diceHand->getNumberOfDices();

        $this->assertEquals($diceCount, 1);
    }

    /**
     * Test roll a Dices in DiceHand
     */
    public function testRollDiceInDiceHandAndGetSum()
    {
        $diceHand = new DiceHand();

        $dice1 = new Dice();

        $dice2 = new Dice();

        $diceHand->add($dice1);

        $diceHand->add($dice2);

        $diceHand->roll();

        $diceHandValues = $diceHand->getValues();

        $diceHandValuesSum = array_sum($diceHandValues);

        $this->assertLessThan(13, $diceHandValuesSum);

        $this->assertGreaterThan(1, $diceHandValuesSum);
    }

    /**
     * Test roll a Dices in DiceHand
     */
    public function testRollDiceInDiceHandAndGetAsString()
    {
        $diceHand = new DiceHand();

        $dice1 = new DiceGraphic();

        $dice2 = new DiceGraphic();

        $diceHand->add($dice1);

        $diceHand->add($dice2);

        $diceHand->roll();

        $diceHandValuesAsString = $diceHand->getString();

        $diceHandCount = $diceHand->getNumberOfDices();

        $this->assertIsString($diceHandValuesAsString[0]);

        $this->assertEquals(2, $diceHandCount);
    }
}
