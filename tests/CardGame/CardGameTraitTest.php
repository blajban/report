<?php

namespace App\CardGame;

use PHPUnit\Framework\TestCase;

use Symfony\Component\HttpFoundation\Session\SessionInterface;

class GameClassMock extends Game
{
    public function __construct(Deck $deck)
    {
        parent::__construct('test');
        $this->deck = $deck;
    }
}


/**
 * Test cases for class Bank.
 */
class CardGameTraitTest extends TestCase
{
    /**
     * Verify that a deck array of Cards is returned.
     * @return void
     */
    public function testGetDeck()
    {
        $deckMock = $this->createMock(Deck::class);

        $deckMock->expects($this->once())
                 ->method('getDeck')
                 ->willReturn([]);

        $game = new GameClassMock($deckMock);

        $this->assertEquals([], $game->getDeck());
    }

    /**
     * Verify that an array of cards as string is returned.
     * @return void
     */
    public function testGetJsonDeck()
    {
        $cardMock1 = $this->createMock(Card::class);
        $cardMock1->method('toArray')
                  ->willReturn(['value' => 1, 'color' => 'hearts']);

        $cardMock2 = $this->createMock(Card::class);
        $cardMock2->method('toArray')
                  ->willReturn(['value' => 2, 'color' => 'clubs']);

        $deckMock = $this->createMock(Deck::class);
        $deckMock->expects($this->once())
                 ->method('getDeck')
                 ->willReturn([$cardMock1, $cardMock2]);

        $game = new GameClassMock($deckMock);

        $exp = [
            ['value' => 1, 'color' => 'hearts'],
            ['value' => 2, 'color' => 'clubs'],
        ];

        $this->assertEquals($exp, $game->getJsonDeck());
    }

    /**
     * Verify that remainingCards method in Deck is called once.
     * @return void
     */
    public function testRemainingCards()
    {
        $deckMock = $this->createMock(Deck::class);

        $deckMock->expects($this->once())
                 ->method('remainingCards')
                 ->willReturn(52);

        $game = new GameClassMock($deckMock);

        $this->assertEquals(52, $game->remainingCards());
    }

}
