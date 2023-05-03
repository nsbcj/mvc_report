<?php

namespace App\Card;

use PHPUnit\Framework\TestCase;

/**
 * Test cases for class Guess.
 */
class CardGraphicTest extends TestCase
{
    /**
     * Construct object and verify that the object has the expected
     * properties, use no arguments.
     */
    public function testCreateCardGraphicNoArguments()
    {
        $guess = new CardGraphic();
        $this->assertInstanceOf("\App\Card\CardGraphic", $guess);
    }

    /**
     * Test setting type and value of card
     */
    public function testSetGetCardGraphicTypeAndValue()
    {
        $guess = new CardGraphic();

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
    public function testSetGetCardGraphicValue()
    {
        $guess = new CardGraphic();

        $guess->setCard("spades", 10);

        $card = $guess->getCardValue();

        $this->assertEquals(10, $card);
    }

    /**
     * Test getting string representation of CardGraphic
     */
    public function testSetGetCardGraphicAsString()
    {
        $guess = new CardGraphic();

        $guess->setCard("spades", 10);

        $card = $guess->getAsString();

        $this->assertEquals("spades-10", $card);
    }
}
