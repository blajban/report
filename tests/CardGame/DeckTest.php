<?php

namespace App\CardGame;

use PHPUnit\Framework\TestCase;
use Exception;

/**
 * Test cases for class Deck.
 */
class DeckTest extends TestCase
{
    /**
     * Verify that deck is constructed in the correct way.
     */
    public function testConstructDeck()
    {
        $deck = new Deck();
        $this->assertInstanceOf("\App\CardGame\Deck", $deck);

        $res = count($deck->getDeck());
        $exp = 52;
        $this->assertEquals($exp, $res);
    }

    /**
     * Verify that the deck is an array of Cards.
     */
    public function testGetDeck()
    {
        $deck = new Deck();
        $this->assertInstanceOf("\App\CardGame\Deck", $deck);

        $res = $deck->getDeck();
        $this->assertContainsOnlyInstancesOf(Card::class, $res);
    }

    /**
     * Verify that a shuffled deck can be sorted.
     */
    public function testSortDeck()
    {
        $deck = new Deck();
        $deck->shuffleDeck();

        $deck->sortDeck();

        $res = $deck->getDeck();

        $exp0 = 1;
        $exp1 = 2;
        $exp2 = 3;
        $exp3 = 4;

        $this->assertEquals($exp0, $res[0]->getValue());
        $this->assertEquals($exp1, $res[1]->getValue());
        $this->assertEquals($exp2, $res[2]->getValue());
        $this->assertEquals($exp3, $res[3]->getValue());
        
    }

    /**
     * Verify that an empty deck reports being empty.
     */
    public function testIsEmpty()
    {
        $deck = new Deck();

        $res = $deck->isEmpty();
        $this->assertFalse($res);

        for ($i = 0; $i < 52; $i++) {
            $deck->drawCard();
        }

        $res = $deck->isEmpty();
        $this->assertTrue($res);
    }

    /**
     * Verify that remainingCards returns the correct amount of remaining cards.
     */
    public function testRemainingCards()
    {
        $deck = new Deck();

        $res = $deck->remainingCards();
        $exp = 52;
        $this->assertEquals($exp, $res);

        $deck->drawCard();
        $deck->drawCard();

        $res = $deck->remainingCards();
        $exp = 50;
        $this->assertEquals($exp, $res);

    }

    /**
     * Verify drawCard returns a Card and removes a card from deck.
     */
    public function testDrawCard()
    {
        $deck = new Deck();

        $res = $deck->drawCard();
        $this->assertInstanceOf(Card::class, $res);

        $res = $deck->remainingCards();
        $exp = 51;
        $this->assertEquals($exp, $res);
    }

    /**
     * Verify peek returns a Card and throws error if empty.
     */
    public function testPeek()
    {
        $deck = new Deck();

        $res = $deck->peek();
        $this->assertInstanceOf(Card::class, $res);

        $res = $deck->remainingCards();
        $exp = 52;
        $this->assertEquals($exp, $res);

        for ($i = 0; $i < 52; $i++) {
            $deck->drawCard();
        }

        $this->expectException(Exception::class);
        $res = $deck->peek();
    }

    /**
     * Verify drawCard returns a Card and removes a card from deck.
     */
    public function testShuffle()
    {
        $deck = new Deck();
        $deck->sortDeck();

        $sortedDeck = $deck->getDeck();

        $deck->shuffleDeck();
        $shuffledDeck = $deck->getDeck();

        $this->assertNotEquals($sortedDeck, $shuffledDeck);
    }

}
