<?php

namespace App\CardGame;

use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use ReflectionClass;
use Exception;

/**
 * Test cases for class Bank.
 * @SuppressWarnings(PHPMD.TooManyPublicMethods)
 */
class GameTest extends TestCase
{
    /**
     * Verify that Game object is constructed correctly and that game state is returned correctly.
     * @return void
     */
    public function testConstructGameAndGetGameState()
    {
        $game = new Game('test');

        $exp = [
            'player' => [
                'name' => 'test',
                'score' => 0,
                'hand' => []
            ],
            'bank' => [
                'name' => 'Bank',
                'score' => 0,
                'hand' => []
            ],
            'remaining_cards' => 52,
            'winner' => ''
        ];

        $res = $game->getGameState();

        $this->assertEquals($exp, $res);
    }

    /**
     * Verify that game state with hand as string is returned correctly.
     * @return void
     */
    public function testGetGameStateJson()
    {
        $game = new Game('test');

        $game->playerDraw();

        $exp = 1;

        /** @phpstan-ignore-next-line */
        $res = count($game->getGameStateJson()['player']['handAsString']);

        $this->assertEquals($exp, $res);
    }

    /**
     * Verify that the deck shuffles correctly.
     * @return void
     */
    public function testShuffle()
    {
        $game = new Game('test');

        $oldDeck = $game->getDeck();

        $game->shuffle();

        $newDeck = $game->getDeck();

        $this->assertNotEquals($oldDeck, $newDeck);
    }

    /**
     * Verify that the isFull method returns true/false correctly.
     * @return void
     */
    public function testIsFull()
    {
        $game = new Game('test');

        $reflection = new ReflectionClass(Game::class);
        $gameStateProperty = $reflection->getProperty('gameState');
        $gameStateProperty->setAccessible(true);

        $gameState = $gameStateProperty->getValue($game);
        /** @phpstan-ignore-next-line */
        $gameState->setPlayerScore(21);
        $gameStateProperty->setValue($game, $gameState);

        $res = $game->isFull();

        $this->assertFalse($res);

        /** @phpstan-ignore-next-line */
        $gameState->setPlayerScore(22);
        $gameStateProperty->setValue($game, $gameState);

        $res = $game->isFull();

        $this->assertTrue($res);
    }

    /**
     * Verify that exception is thrown if deck is empty when drawing.
     * @return void
     */
    public function testPlayerDrawException()
    {
        $deckMock = $this->createMock(Deck::class);

        $deckMock->expects($this->once())
                 ->method('remainingCards')
                 ->willReturn(0);

        $game = new GameClassMock($deckMock);

        $this->expectException(Exception::class);
        $game->playerDraw();
    }

    /**
     * Verify that card is drawn by player.
     * @return void
     */
    public function testPlayerDrawsCard()
    {
        $deckMock = $this->createMock(Deck::class);

        $deckMock->expects($this->once())
                 ->method('drawCard');

        $deckMock->method('remainingCards')
                 ->willReturn(52);

        $game = new GameClassMock($deckMock);

        $game->playerDraw();

    }

    /**
     * Verify that exception is thrown if deck is empty when bank drawing.
     * @return void
     */
    public function testBankDrawException()
    {
        $deckMock = $this->createMock(Deck::class);

        $deckMock->expects($this->once())
                 ->method('remainingCards')
                 ->willReturn(0);

        $game = new GameClassMock($deckMock);

        $this->expectException(Exception::class);
        $game->bankDraw();
    }

    /**
     * Verify that bank draws cards correctly.
     * @return void
     */
    public function testBankDrawsCard()
    {
        $deckMock = $this->createMock(Deck::class);

        $deckMock->expects($this->once())
                 ->method('drawCard');

        $deckMock->method('remainingCards')
                 ->willReturn(52);

        $game = new GameClassMock($deckMock);

        $game->playerDraw();

    }

    /**
     * Verify that the correct winner is determined (player over 21).
     * @return void
     */
    public function testDetermineWinnerPlayerOver21()
    {
        $game = new Game('test');

        $reflection = new ReflectionClass(Game::class);
        $gameStateProperty = $reflection->getProperty('gameState');
        $gameStateProperty->setAccessible(true);

        $gameState = $gameStateProperty->getValue($game);
        /** @phpstan-ignore-next-line */
        $gameState->setPlayerScore(22);
        $gameStateProperty->setValue($game, $gameState);

        $game->determineWinner();

        $res = $game->getGameState()['winner'];
        $exp = 'bank';

        $this->assertEquals($exp, $res);
    }

    /**
     * Verify that the correct winner is determined (player less than 21, bank over 21).
     * @return void
     */
    public function testDetermineWinnerPlayerLessThan21BankOver21()
    {
        $game = new Game('test');

        $reflection = new ReflectionClass(Game::class);
        $gameStateProperty = $reflection->getProperty('gameState');
        $gameStateProperty->setAccessible(true);

        $gameState = $gameStateProperty->getValue($game);
        /** @phpstan-ignore-next-line */
        $gameState->setPlayerScore(20);
        /** @phpstan-ignore-next-line */
        $gameState->setBankScore(22);
        $gameStateProperty->setValue($game, $gameState);

        $game->determineWinner();

        $res = $game->getGameState()['winner'];
        $exp = 'player';

        $this->assertEquals($exp, $res);
    }

    /**
     * Verify that the correct winner is determined (equal score).
     * @return void
     */
    public function testDetermineWinnerEqualScore()
    {
        $game = new Game('test');

        $reflection = new ReflectionClass(Game::class);
        $gameStateProperty = $reflection->getProperty('gameState');
        $gameStateProperty->setAccessible(true);

        $gameState = $gameStateProperty->getValue($game);
        /** @phpstan-ignore-next-line */
        $gameState->setPlayerScore(20);
        /** @phpstan-ignore-next-line */
        $gameState->setBankScore(20);
        $gameStateProperty->setValue($game, $gameState);

        $game->determineWinner();

        $res = $game->getGameState()['winner'];
        $exp = 'bank';

        $this->assertEquals($exp, $res);
    }

    /**
     * Verify that the correct winner is determined (player highest score).
     * @return void
     */
    public function testDetermineWinnerPlayerHighestScore()
    {
        $game = new Game('test');

        $reflection = new ReflectionClass(Game::class);
        $gameStateProperty = $reflection->getProperty('gameState');
        $gameStateProperty->setAccessible(true);

        $gameState = $gameStateProperty->getValue($game);
        /** @phpstan-ignore-next-line */
        $gameState->setPlayerScore(21);
        /** @phpstan-ignore-next-line */
        $gameState->setBankScore(20);
        $gameStateProperty->setValue($game, $gameState);

        $game->determineWinner();

        $res = $game->getGameState()['winner'];
        $exp = 'player';

        $this->assertEquals($exp, $res);
    }

}
