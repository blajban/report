<?php

namespace App\CardGame;

use App\CardGame\CardGameInterface;
use App\CardGame\CardGameTrait;
use App\CardGame\Player;
use App\CardGame\Deck;
use Symfony\Component\HttpFoundation\Session\SessionInterface;



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


class Bank
{

}

class Game implements CardGameInterface
{
    use CardGameTrait;

    private Player $player;
    private Bank $bank;
    private const MAXPOINTS = 21;
    private array $gameState = [
        'player' => [
            'name' => '',
            'score' => 0,
            'hand' => []
        ],
        'bank' => [
            'score' => 0,
            'hand' => []
        ],
        'remaining_cards' => 0
    ];

    public function __construct(SessionInterface $session)
    {
        $this->session = $session;
        
    }

    private function updateGameState()
    {

        $this->deck = $this->session->get("21deck") ?? new Deck();
        $this->gameState['remaining_cards'] = $this->deck->remainingCards();

        $playerName = $this->session->get("21player_name") ?? "Player";
        $this->player = $this->session->get("21player") ?? new Player($playerName);
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
        $this->session->set("21deck", $this->deck);
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
}
