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
        $card = new Card();
        $this->assertInstanceOf("\App\Card\Card", $card);
    }

    /**
     * Test setting type and value of card
     */
    public function testSetGetCardTypeAndValue()
    {
        $card = new Card();

        $card->setCard("spades", 10);

        $card = $card->getCard();

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
        $card = new Card();

        $card->setCard("spades", 10);

        $card = $card->getCardValue();

        $this->assertEquals(10, $card);
    }
}
