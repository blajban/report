<?php

namespace App\CardGame;

use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use ReflectionClass;
use Exception;

/**
 * Test cases for class Bank.
 */
class GameTest extends TestCase
{
    /**
     * Verify that Game object is constructed correctly and that game state is returned correctly.
     */
    public function testConstructGameAndGetGameState()
    {
        $sessionMock = $this->createMock(SessionInterface::class);

        $game = new Game($sessionMock);

        $exp = [
            'player' => [
                'name' => 'Player name not defined',
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
     * Verify that session method is called when setting players name.
     */
    public function testSetPlayerName()
    {
        $sessionMock = $this->createMock(SessionInterface::class);

        $sessionMock->expects($this->once())
                 ->method('set');

        $game = new Game($sessionMock);

        $game->setPlayerName("Erik");

    }

    /**
     * Verify that game state with hand as string is returned correctly.
     */
    public function testGetGameStateJson()
    {
        $sessionMock = $this->createMock(SessionInterface::class);

        $game = new Game($sessionMock);

        $game->playerDraw();

        $exp = 1;

        $res = count($game->getGameStateJson()['player']['handAsString']);

        $this->assertEquals($exp, $res);
    }

    /**
     * Verify that the isFull method returns true/false correctly.
     */
    public function testIsFull()
    {
        $sessionMock = $this->createMock(SessionInterface::class);
        $game = new Game($sessionMock);

        $reflection = new ReflectionClass(Game::class);
        $gameStateProperty = $reflection->getProperty('gameState');
        $gameStateProperty->setAccessible(true);

        $gameState = $gameStateProperty->getValue($game);
        $gameState['player']['score'] = 21;
        $gameStateProperty->setValue($game, $gameState);

        $res = $game->isFull();

        $this->assertFalse($res);

        $gameState['player']['score'] = 22;
        $gameStateProperty->setValue($game, $gameState);

        $res = $game->isFull();

        $this->assertTrue($res);
    }

    /**
     * Verify that exception is thrown if deck is empty when drawing.
     */
    public function testPlayerDrawException()
    {
        $sessionMock = $this->createMock(SessionInterface::class);
        $deckMock = $this->createMock(Deck::class);

        $deckMock->expects($this->once())
                 ->method('remainingCards')
                 ->willReturn(0);

        $game = new GameClassMock($sessionMock, $deckMock);

        $this->expectException(Exception::class);
        $game->playerDraw();
    }

    /**
     * Verify that players hand is updated in gamestate when drawing a card.
     */
    public function testPlayerDrawsCardAndGameStateUpdates()
    {
        $sessionMock = $this->createMock(SessionInterface::class);

        $game = new Game($sessionMock);

        $exp = [
            'player' => [
                'name' => 'Player name not defined',
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

}
