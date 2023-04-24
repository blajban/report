<?php

namespace App\CardGame;

use App\CardGame\CardGameInterface;
use App\CardGame\CardGameTrait;
use App\CardGame\Player;
use App\CardGame\Deck;
use Symfony\Component\HttpFoundation\Session\SessionInterface;


/*
$gameState = [
    'player' => [
        'name' => $name,
        'score' => $points,
        'hand' => []
    ],
    'bank' => [
        'score' => $points,
        'hand' => []
    ],
    'remaining_cards' => $cardGame->remainingCards()
];
*/

class Bank
{

}

class Game implements CardGameInterface
{
    use CardGameTrait;

    private const MAXPOINTS = 21;
    private const DECK_SESSIONNAME = '21deck';
    private const PLAYERNAME_SESSIONNAME = '21player_name';
    private const PLAYER_SESSIONNAME = '21player';

    private Player $player;
    //private Bank $bank;
    
    private array $gameState = [
        'player' => [
            'name' => 'spelaren',
            'score' => 0,
            'hand' => []
        ],
        'bank' => [
            'name' => 'banken',
            'score' => 0,
            'hand' => []
        ],
        'remaining_cards' => 0
    ];

    public function __construct(SessionInterface $session)
    {
        $this->session = $session;
        $this->updateGameState();
        
    }

    private function updateGameState()
    {

        $this->deck = $this->session->get(Game::DECK_SESSIONNAME) ?? new Deck();
        $this->gameState['remaining_cards'] = $this->deck->remainingCards();

        $playerName = $this->session->get(Game::PLAYERNAME_SESSIONNAME) ?? "Player";
        $this->player = $this->session->get(Game::PLAYER_SESSIONNAME) ?? new Player($playerName);
        $this->gameState['player']['hand'] = $this->player->getHand();
    }

    public function getGameState(): array
    {
        return $this->gameState;
    }

    public function shuffle()
    {
        $this->deck = new Deck();
        $this->deck->shuffleDeck();
        $this->session->set(Game::DECK_SESSIONNAME, $this->deck);
        $this->updateGameState();
    }

    public function calculatePoints()
    {

    }

    public function isFull()
    {
        
    }

    public function playerDraw()
    {

    }

    public function bankDraw()
    {

    }

    public function bankContinue()
    {
        
    }

    public function determineWinner()
    {
        
    }

    public function reset()
    {

    }
}
