<?php

namespace App\CardGame;

use App\CardGame\CardGameInterface;
use App\CardGame\CardGameTrait;
use App\CardGame\Player;
use App\CardGame\Bank;
use App\CardGame\Deck;
use Exception;
use Symfony\Component\HttpFoundation\Session\SessionInterface;


class Game implements CardGameInterface
{
    use CardGameTrait;

    private const MAX_POINTS = 21;
    private const DECK_SESSION_NAME = '21deck';
    private const PLAYER_SESSION_NAME = '21player';
    private const PLAYER_SCORE_SESSION_NAME = '21player_score';
    private const PLAYERNAME_SESSION_NAME = '21playername';
    private const BANK_SESSION_NAME = '21bank';
    private const BANK_SCORE_SESSION_NAME = '21bank_score';
    

    private Player $player;
    private Bank $bank;
    
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

        $playerName = $this->session->get(Game::PLAYERNAME_SESSION_NAME) ?? 'Player name not defined';
        $this->player = $this->session->get(Game::PLAYER_SESSION_NAME) ?? new Player($playerName);
        $this->gameState['player']['name'] = $this->player->getName();
        $this->gameState['player']['hand'] = $this->player->getHand();

        $this->gameState['player']['score'] = $this->session->get(GAME::PLAYER_SCORE_SESSION_NAME) ?? 0;

        $this->bank = $this->session->get(Game::BANK_SESSION_NAME) ?? new Bank();
        $this->gameState['bank']['hand'] = $this->bank->getHand();

        $this->gameState['bank']['score'] = $this->session->get(GAME::BANK_SCORE_SESSION_NAME) ?? 0;

    }

    private function setGameStateSession()
    {
        $this->session->set(Game::DECK_SESSION_NAME, $this->deck);
        $this->session->set(Game::PLAYER_SESSION_NAME, $this->player);
        $this->session->set(Game::PLAYER_SCORE_SESSION_NAME, $this->gameState['player']['score']);
        $this->session->set(Game::BANK_SESSION_NAME, $this->bank);
        $this->session->set(Game::BANK_SCORE_SESSION_NAME, $this->gameState['bank']['score']);
    }

    private function resetGameStateSession()
    {
        $this->session->remove(Game::DECK_SESSION_NAME);
        $this->session->remove(Game::PLAYER_SESSION_NAME);
        $this->session->remove(Game::PLAYER_SCORE_SESSION_NAME);
        $this->session->remove(Game::BANK_SESSION_NAME);
        $this->session->remove(Game::BANK_SCORE_SESSION_NAME);
    }

    private function calculatePoints($hand): int
    {
        $points = 0;
        
        foreach ($hand as $card) {
            $points += $card->getValue(); // fix ace
        }

        return $points;
    }

    public function setPlayerName($name)
    {
        $this->session->set(Game::PLAYERNAME_SESSION_NAME, $name);
    }

    public function getGameState(): array
    {
        return $this->gameState;
    }

    public function getGameStateJson(): array
    {
        foreach ($this->gameState['player']['hand'] as $card) {
            $this->gameState['player']['handAsString'][] = $card->toArray();
        }

        foreach ($this->gameState['bank']['hand'] as $card) {
            $this->gameState['bank']['handAsString'][] = $card->toArray();
        }

        return $this->gameState;
    }

    public function shuffle()
    {
        $this->resetGameStateSession();
        $this->getGameStateSession();
        $this->deck->shuffleDeck();
        $this->setGameStateSession();
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
        $this->gameState['player']['handAsString'][] = $card->toArray();

        $this->gameState['player']['score'] = $this->calculatePoints($this->player->getHand());

        $this->setGameStateSession();
    }

    public function bankDraw()
    {
        while ($this->bank->willContinue($this->gameState['bank']['score'])) {
            $card = $this->deck->drawCard();
            $this->bank->addCard($card);
            $this->gameState['bank']['score'] = $this->calculatePoints($this->bank->getHand());
        }

        $this->setGameStateSession();
    }


    public function determineWinner()
    {
        
    }

    
}
