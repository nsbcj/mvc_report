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
        $cardGraphic = new CardGraphic();
        $this->assertInstanceOf("\App\Card\CardGraphic", $cardGraphic);
    }

    /**
     * Test setting type and value of card
     */
    public function testSetGetCardGraphicTypeAndValue()
    {
        $cardGraphic = new CardGraphic();

        $cardGraphic->setCard("spades", 10);

        $card = $cardGraphic->getCard();

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
        $cardGraphic = new CardGraphic();

        $cardGraphic->setCard("spades", 10);

        $card = $cardGraphic->getCardValue();

        $this->assertEquals(10, $card);
    }

    /**
     * Test getting string representation of CardGraphic
     */
    public function testSetGetCardGraphicAsString()
    {
        $cardGraphic = new CardGraphic();

        $cardGraphic->setCard("spades", 10);

        $card = $cardGraphic->getAsString();

        $this->assertEquals("spades-10", $card);
    }
}
