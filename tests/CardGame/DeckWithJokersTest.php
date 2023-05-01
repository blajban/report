<?php

namespace App\CardGame;

use PHPUnit\Framework\TestCase;

/**
 * Test cases for class Deck.
 */
class DeckWithJokersTest extends TestCase
{
    /**
     * Verify that deck is constructed in the correct way.
     * @return void
     */
    public function testConstructDeck()
    {
        $deck = new DeckWithJokers();
        $this->assertInstanceOf("\App\CardGame\DeckWithJokers", $deck);

        $res = count($deck->getDeck());
        $exp = 54;
        $this->assertEquals($exp, $res);
    }

}
