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
    private const WINNER_SESSION_NAME = '21winner';


    private Player $player;
    private Bank $bank;

    /**
     * @var array{
     *   player: array{name: string, score: int, hand: array<Card>},
     *   bank: array{name: string, score: int, hand: array<Card>},
     *   remaining_cards: int,
     *   winner: string
     * }
     */
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
        'remaining_cards' => 0,
        'winner' => ''
    ];

    public function __construct(SessionInterface $session)
    {
        $this->session = $session;
        $this->getGameStateSession();
    }

    /**
     * @return void
     */
    private function getGameStateSession()
    {
        /** @phpstan-ignore-next-line */
        $this->deck = $this->session->get(Game::DECK_SESSION_NAME) ?? new Deck();
        /** @phpstan-ignore-next-line */
        $this->gameState['remaining_cards'] = $this->deck->remainingCards();

        /** @var string $playerName */
        $playerName = $this->session->get(Game::PLAYERNAME_SESSION_NAME) ?? 'Player name not defined';
        /** @phpstan-ignore-next-line */
        $this->player = $this->session->get(Game::PLAYER_SESSION_NAME) ?? new Player($playerName);
        /** @phpstan-ignore-next-line */
        $this->gameState['player']['name'] = $this->player->getName();
        /** @phpstan-ignore-next-line */
        $this->gameState['player']['hand'] = $this->player->getHand();

        /** @phpstan-ignore-next-line */
        $this->gameState['player']['score'] = $this->session->get(Game::PLAYER_SCORE_SESSION_NAME) ?? 0;

        /** @phpstan-ignore-next-line */
        $this->bank = $this->session->get(Game::BANK_SESSION_NAME) ?? new Bank();
        /** @phpstan-ignore-next-line */
        $this->gameState['bank']['hand'] = $this->bank->getHand();

        /** @phpstan-ignore-next-line */
        $this->gameState['bank']['score'] = $this->session->get(Game::BANK_SCORE_SESSION_NAME) ?? 0;

        /** @phpstan-ignore-next-line */
        $this->gameState['winner'] = $this->session->get(Game::WINNER_SESSION_NAME) ?? '';

    }

    /**
     * @return void
     */
    private function setGameStateSession()
    {
        $this->session->set(Game::DECK_SESSION_NAME, $this->deck);
        $this->session->set(Game::PLAYER_SESSION_NAME, $this->player);
        $this->session->set(Game::PLAYER_SCORE_SESSION_NAME, $this->gameState['player']['score']);
        $this->session->set(Game::BANK_SESSION_NAME, $this->bank);
        $this->session->set(Game::BANK_SCORE_SESSION_NAME, $this->gameState['bank']['score']);
        $this->session->set(Game::WINNER_SESSION_NAME, $this->gameState['winner']);
    }

    /**
     * @return void
     */
    private function resetGameStateSession()
    {
        $this->session->remove(Game::DECK_SESSION_NAME);
        $this->session->remove(Game::PLAYER_SESSION_NAME);
        $this->session->remove(Game::PLAYER_SCORE_SESSION_NAME);
        $this->session->remove(Game::BANK_SESSION_NAME);
        $this->session->remove(Game::BANK_SCORE_SESSION_NAME);
    }


    /**
     * @param array<Card> $hand
     */
    private function calculateHand(array $hand): int
    {
        $points = 0;

        foreach ($hand as $card) {
            $points += $card->getValue();
        }

        return $points;
    }

    /**
     * @param array<Card> $hand
     */
    private function calculatePoints(array $hand): int
    {
        $aceLow = 1;
        $aceHigh = 14;

        foreach ($hand as $card) {
            if ($card->isAce() && $card->getValue() == $aceHigh) {
                $card->changeAceValue();
            }
        }

        $points = $this->calculateHand($hand);

        foreach ($hand as $card) {
            if ($card->isAce() && ($points + $aceHigh - $aceLow <= Game::MAX_POINTS)) {
                $card->changeAceValue();
                $points = $this->calculateHand($hand);
            }
        }

        return $points;
    }

    /**
     * @return void
     */
    public function setPlayerName(string $name)
    {
        $this->session->set(Game::PLAYERNAME_SESSION_NAME, $name);
    }

    /**
     * @return array{
     *   player: array{name: string, score: int, hand: array<Card>},
     *   bank: array{name: string, score: int, hand: array<Card>},
     *   remaining_cards: int,
     *   winner: string
     * }
     */
    public function getGameState(): array
    {
        return $this->gameState;
    }

    /**
     * @return array{
     *   player: array{name: string, score: int, hand: array<Card>, handAsString?: array<array<string, mixed>>},
     *   bank: array{name: string, score: int, hand: array<Card>, handAsString?: array<array<string, mixed>>},
     *   remaining_cards: int,
     *   winner: string
     * }
     */
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

    /**
     * @return void
     */
    public function shuffle()
    {
        $this->resetGameStateSession();
        $this->getGameStateSession();
        $this->deck->shuffleDeck();
        $this->setGameStateSession();
    }


    public function isFull(): bool
    {
        if ($this->gameState['player']['score'] > Game::MAX_POINTS) {
            return true;
        }

        return false;
    }

    /**
     * @return void
     */
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

    /**
     * @return void
     */
    public function bankDraw()
    {
        while ($this->bank->willContinue($this->gameState['bank']['score']) && $this->gameState['bank']['score'] <= Game::MAX_POINTS) {
            if ($this->deck->remainingCards() < 1) {
                throw new Exception('Deck empty');
            }
            $card = $this->deck->drawCard();
            $this->bank->addCard($card);
            $this->gameState['bank']['score'] = $this->calculatePoints($this->bank->getHand());
        }

        $this->setGameStateSession();
    }

    /**
     * @return void
     */
    private function setWinner()
    {
        $playerScore = $this->gameState['player']['score'];
        $bankScore = $this->gameState['bank']['score'];

        if ($playerScore > Game::MAX_POINTS) {
            $this->gameState['winner'] = "bank";
            return;
        }

        if ($bankScore > Game::MAX_POINTS) {
            $this->gameState['winner'] = "player";
            return;
        }

        if ($bankScore >= $playerScore) {
            $this->gameState['winner'] = "bank";
            return;
        }

        $this->gameState['winner'] = "player";
    }

    /**
     * @return void
     */
    public function determineWinner()
    {
        $this->setWinner();

        $this->setGameStateSession();
    }


}
