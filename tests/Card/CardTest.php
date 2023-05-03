<?php

namespace App\Card;

use PHPUnit\Framework\TestCase;

/**
 * Test cases for class Guess.
 */
class CardTest extends TestCase
{
    /**
     * Construct object and verify that the object has the expected
     * properties, use no arguments.
     */
    public function testCreateCardNoArguments()
    {
        $guess = new Card();
        $this->assertInstanceOf("\App\Card\Card", $guess);
    }

    /**
     * Test setting type and value of card
     */
    public function testSetGetCardTypeAndValue()
    {
        $guess = new Card();

        $guess->setCard("spades", 10);

        $card = $guess->getCard();

        $this->assertEquals([
            "type" => "spades",
            "value" => 10
        ], $card);
    }

    /**
     * Test getting only card value
     */
    public function testSetGetCardValue()
    {
        $guess = new Card();

        $guess->setCard("spades", 10);

        $card = $guess->getCardValue();

        $this->assertEquals(10, $card);
    }
}
