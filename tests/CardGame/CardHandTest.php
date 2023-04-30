<?php

namespace App\CardGame;

use PHPUnit\Framework\TestCase;

/**
 * Test cases for class Bank.
 */
class CardHandTest extends TestCase
{
    /**
     * Verify that a card is added to hand.
     */
    public function testAddCard()
    {
        $cardMock = $this->createMock(Card::class);

        $player = new Player("Erik");

        $player->addCard($cardMock);

        $this->assertSame([$cardMock], $player->getHand());
    }

    /**
     * Verify that the hand can be discarded.
     */
    public function testDiscardHand()
    {
        $cardMock = $this->createMock(Card::class);

        $player = new Player("Erik");

        $player->addCard($cardMock);

        $this->assertSame([$cardMock], $player->getHand());

        $player->discardHand();

        $this->assertSame([], $player->getHand());

    }

}
