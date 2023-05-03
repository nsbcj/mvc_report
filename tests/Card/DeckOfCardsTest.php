<?php

namespace App\Card;

use PHPUnit\Framework\TestCase;

/**
 * Test cases for class Guess.
 */
class DeckOfCardsTest extends TestCase
{
    /**
     * Construct object and verify that the object has the expected
     * properties, use no arguments.
     */
    public function testCreateDeckNoArguments()
    {
        $deck = new DeckOfCards();
        $this->assertInstanceOf("\App\Card\DeckOfCards", $deck);
    }

    /**
     * Test init DeckOfCards
     */
    public function testInitDeckOfCards()
    {
        $deck = new DeckOfCards();

        $deck->init();

        $card = $deck->draw();

        $this->assertInstanceOf("\App\Card\CardGraphic", $card);
    }

    /**
     * Test init and shuffle DeckOfCards
     */
    public function testInitAndShuffleDeckOfCards()
    {
        $deck = new DeckOfCards();

        $deck->init();

        $deck->shuffle();

        $card = $deck->draw();

        $this->assertInstanceOf("\App\Card\CardGraphic", $card);
    }

    /**
     * Test draw card from DeckOfCards
     */
    public function testDrawCardFromDeckOfCards()
    {
        $deck = new DeckOfCards();

        $deck->init();

        $card = $deck->draw();

        $card = $card->getAsString();

        $this->assertEquals("spades-13", $card);
    }

    /**
     * Test get DeckOfCards
     */
    public function testGetDeckOfCards()
    {
        $deck = new DeckOfCards();

        $deck->init();

        $deck = $deck->getDeck();

        $deckLength = count($deck);

        $this->assertEquals(52, $deckLength);
    }

    /**
     * Test return length of DeckOfCards
     */
    public function testReturnLengthOfDeckOfCards()
    {
        $deck = new DeckOfCards();

        $deck->init();

        $deckLength = $deck->getDeckLength();

        $this->assertEquals(52, $deckLength);

        $deck->draw();

        $deckLength = $deck->getDeckLength();

        $this->assertEquals(51, $deckLength);
    }

    /**
     * Test get Card values of DeckOfCards
     */
    public function testGetCardValuesOfDeckOfCards()
    {
        $deck = new DeckOfCards();

        $deck->init();

        $deckValues = $deck->getDeckValues();

        $test = array_merge(...array_fill(0, 4, range(1, 13)));

        $this->assertEquals($test, $deckValues);
    }

    /**
     * Test get Card values of DeckOfCards
     */
    public function testGetDeckAsStringFromDeckOfCards()
    {
        $deck = new DeckOfCards();

        $deck->init();

        $deckAsString = $deck->getDeckAsString();

        $types = [
            "hearts",
            "diamonds",
            "clubs",
            "spades"
        ];

        $test = [];

        foreach ($types as $type) {
            foreach (range(1, 13) as $value) {
                $test[] = "${type}-${value}";
            }
        }

        $this->assertEquals($test, $deckAsString);
    }

}
