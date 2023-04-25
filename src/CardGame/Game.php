<?php

namespace App\CardGame;

use App\CardGame\CardGameInterface;
use App\CardGame\CardGameTrait;
use App\CardGame\Player;
use App\CardGame\Deck;
use Exception;
use Symfony\Component\HttpFoundation\Session\SessionInterface;


class Bank
{

}

class Game implements CardGameInterface
{
    use CardGameTrait;

    private const MAX_POINTS = 21;
    private const DECK_SESSION_NAME = '21deck';
    private const PLAYER_SESSION_NAME = '21player';
    private const BANK_SESSION_NAME = '21bank';

    private Player $player;
    //private Bank $bank;
    
    private array $gameState = [
        'player' => [
            'name' => 'spelaren',
            'score' => 0,
            'hand' => []
        ],
        'bank' => [
            'name' => 'Bank',
            'score' => 0,
            'hand' => []
        ],
        'remaining_cards' => 0
    ];

    public function __construct(SessionInterface $session)
    {
        $this->session = $session;
        $this->getGameStateSession();
        
    }

    private function getGameStateSession()
    {
        $this->deck = $this->session->get(Game::DECK_SESSION_NAME) ?? new Deck();
        $this->gameState['remaining_cards'] = $this->deck->remainingCards();

        $this->player = $this->session->get(Game::PLAYER_SESSION_NAME) ?? new Player('spelare');
        $this->gameState['player']['hand'] = $this->player->getHand();

        // IF player score session THEN
        // SET gameState[player][score] = playerScore from session

        // IF bank session THEN
            // SET bank
        // ELSE
            // CREATE bank

        // SET gameState[bank][hand] = CALL Bank:: get hand

        // IF bank score session THEN
            // SET gameState[bank][score] = bankScore from session
        
    }

    private function setGameStateSession()
    {
        // SET deck session
        $this->session->set(Game::DECK_SESSION_NAME, $this->deck);
        // SET player session
        $this->session->set(Game::PLAYER_SESSION_NAME, $this->player);
        // SET player score session
        // SET bank session
        //$this->session->set(Game::BANK_SESSION_NAME, $this->bank);
        // SET bank score session
    }

    private function resetGameStateSession()
    {
        $this->session->remove(Game::DECK_SESSION_NAME);
        $this->session->remove(Game::PLAYER_SESSION_NAME);
        $this->session->remove(Game::BANK_SESSION_NAME);
    }

    public function getGameState(): array
    {
        return $this->gameState;
    }



    public function shuffle()
    {
        $this->resetGameStateSession();
        $this->getGameStateSession();
        $this->deck->shuffleDeck();
        $this->setGameStateSession();
    }

    private function calculatePoints($hand): int
    {
        return 10;
    }

    public function isFull()
    {
        return false;
    }

    public function playerDraw()
    {
        if ($this->deck->remainingCards() < 1) {
            throw new Exception('Deck empty');
        }

        $card = $this->deck->drawCard();
        $this->player->addCard($card);

        $this->gameState['player']['score'] = $this->calculatePoints($this->player->getHand());

        $this->setGameStateSession();
    }

    public function bankDraw()
    {
        // WHILE bankContinue
            // CALL Game:: bank draw
            // CALL Game:: check if bank is full
            // IF bank is full THEN
                // RETURN redirect to end screen
        $this->setGameStateSession();
    }


    public function determineWinner()
    {
        
    }

    
}
