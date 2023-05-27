<?php

namespace App\Card;

use PHPUnit\Framework\TestCase;

/**
 * Test cases for class Guess.
 */
class CardHandTest extends TestCase
{
    /**
     * Construct object and verify that the object has the expected
     * properties, use no arguments.
     */
    public function testCreateCardHandNoArguments()
    {
        $hand = new CardHand();
        $this->assertInstanceOf("\App\Card\CardHand", $hand);
    }

    /**
     * Test adding card to hand
     */
    public function testAddCardToCardHand()
    {
        $hand = new CardHand();

        $deck = new DeckOfCards();

        $deck->init();

        $hand->add($deck);

        $hand = $hand->getHandAsString();

        $card = $hand[0];

        $this->assertEquals("spades-13", $card);
    }

    /**
     * Test reset hand
     */
    public function testResetCardHand()
    {
        $hand = new CardHand();

        $deck = new DeckOfCards();

        $deck->init();

        $hand->add($deck);

        $hand->resetHand();

        $hand = $hand->getHandAsString();

        $handLength = count($hand);

        $this->assertEquals($handLength, 0);
    }

    /**
     * Test calculating CardHand
     */
    public function testSumOfCardHand()
    {
        $hand = new CardHand();

        $deck = new DeckOfCards();

        $deck->init();

        $hand->add($deck);

        $hand->add($deck);

        $handSum = $hand->getHandSum();

        $this->assertEquals($handSum, 25);

        // test sum if CardHand reseted

        $hand->resetHand();

        $handSum = $hand->getHandSum();

        $this->assertEquals($handSum, 0);
    }

    /**
     * Test getting HandValues CardHand
     */
    public function testArrayOfValuesOfCardHand()
    {
        $hand = new CardHand();

        $deck = new DeckOfCards();

        $deck->init();

        $hand->add($deck);

        $hand->add($deck);

        $handValues = $hand->getHandValues();

        $this->assertEquals($handValues, [13, 12]);

        // test sum if CardHand reseted

        $hand->resetHand();

        $handValues = $hand->getHandValues();

        $this->assertEquals($handValues, []);
    }

    /**
     * Test getting HandValues CardHand
     */
    public function testStringOfCardsOfCardHand()
    {
        $hand = new CardHand();

        $deck = new DeckOfCards();

        $deck->init();

        $hand->add($deck);

        $hand->add($deck);

        $handAsString = $hand->getHandAsString();

        $this->assertEquals($handAsString, ["spades-13", "spades-12"]);

        // test sum if CardHand reseted

        $hand->resetHand();

        $handAsString = $hand->getHandAsString();

        $this->assertEquals($handAsString, []);
    }

    /**
     * Test double bet
     */
    public function testDoubleBetOfCardHand()
    {
        $hand = new CardHand();

        $deck = new DeckOfCards();

        $deck->init();

        $hand->add($deck);

        $hand->add($deck);

        $hand->setBet(10);

        $hand->doubleBet();

        $this->assertEquals(20, $hand->bet);
    }
}
