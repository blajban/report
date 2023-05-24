<?php

namespace App\CardGame;

use App\CardGame\CardGameInterface;
use App\CardGame\CardGameTrait;
use App\CardGame\Player;
use App\CardGame\Bank;
use App\CardGame\Deck;
use App\CardGame\GameState;
use Exception;

/**
 * Game class.
 */
class Game implements CardGameInterface
{
    use CardGameTrait;

    private const MAX_POINTS = 21;


    private Player $player;
    private Bank $bank;
    private GameState $gameState;

    /**
     * Constructor.
     * @param string $playerName
     */
    public function __construct(string $playerName)
    {
        $this->deck = new Deck();
        $this->player = new Player($playerName);
        $this->bank = new Bank();
        $this->gameState = new GameState();

        $this->gameState->update($this->deck, $this->player, $this->bank);
    }


    /**
     * Calculate total points of a hand of cards.
     * @param array<Card> $hand
     * @return int
     */
    private function calculateHand(array $hand): int
    {
        $points = 0;

        foreach ($hand as $card) {
            $points += $card->getValue();
        }

        return $points;
    }

    private function changeAceValueIfHigh(Card $card, int $aceHigh): void
    {
        
        if ($card->isAce() && $card->getValue() == $aceHigh) {
            $card->changeAceValue();
        }
    }

    private function changeAceValueIfFull(Card $card, int $aceLow, int $aceHigh, int $currentPoints): bool
    {
        if ($card->isAce() && ($currentPoints + $aceHigh - $aceLow <= Game::MAX_POINTS)) {
            $card->changeAceValue();
            return true;
        }

        return false;
    }

    /**
     * Calculate the total points of a hand of cards considering aces.
     * @param array<Card> $hand
     * @return int
     */
    private function calculatePoints(array $hand): int
    {
        $aceLow = 1;
        $aceHigh = 14;

        foreach ($hand as $card) {
            $this->changeAceValueIfHigh($card, $aceHigh);
        }

        $points = $this->calculateHand($hand);

        foreach ($hand as $card) {
            if ($this->changeAceValueIfFull($card, $aceLow, $aceHigh, $points)) {
                $points = $this->calculateHand($hand);
            }
        }

        return $points;
    }

    /**
     * Get current game state.
     * @return array{
     *   player: array{name: string, score: int, hand: array<Card>},
     *   bank: array{name: string, score: int, hand: array<Card>},
     *   remaining_cards: int,
     *   winner: string
     * }
     */
    public function getGameState(): array
    {
        return $this->gameState->get();
    }

    /**
     * Get current game state prepared for json.
     * @return array{
     *   player: array{name: string, score: int, hand: array<Card>, handAsString?: array<array<string, mixed>>},
     *   bank: array{name: string, score: int, hand: array<Card>, handAsString?: array<array<string, mixed>>},
     *   remaining_cards: int,
     *   winner: string
     * }
     */
    public function getGameStateJson(): array
    {
        return $this->gameState->getJson();
    }

    /**
     * Shuffle deck and reset game.
     * @return void
     */
    public function shuffle()
    {
        $this->deck->shuffleDeck();
        $this->player->discardHand();
        $this->bank->discardHand();

        $this->gameState->reset();
        $this->gameState->update($this->deck, $this->player, $this->bank);

    }

    /**
     * Check if players score is above max points.
     * @return bool
     */
    public function isFull(): bool
    {
        if ($this->gameState->getPlayerScore() > Game::MAX_POINTS) {
            return true;
        }

        return false;
    }

    /**
     * Draw a card for player.
     * @return void
     */
    public function playerDraw()
    {
        if ($this->deck->remainingCards() < 1) {
            throw new Exception('Deck empty');
        }

        $card = $this->deck->drawCard();
        $this->player->addCard($card);
        //$this->gameState['player']['handAsString'][] = $card->toArray();

        $score = $this->calculatePoints($this->player->getHand());
        $this->gameState->setPlayerScore($score);

        $this->gameState->update($this->deck, $this->player, $this->bank);
    }

    /**
     * Draw cards for bank.
     * @return void
     */
    public function bankDraw()
    {
        while ($this->bank->willContinue($this->gameState->getBankScore()) && $this->gameState->getBankScore() <= Game::MAX_POINTS) {
            if ($this->deck->remainingCards() < 1) {
                throw new Exception('Deck empty');
            }
            $card = $this->deck->drawCard();
            $this->bank->addCard($card);

            $score = $this->calculatePoints($this->bank->getHand());
            $this->gameState->setBankScore($score);
        }

        $this->gameState->update($this->deck, $this->player, $this->bank);
    }

    /**
     * Check and set winner.
     * @return void
     */
    private function setWinner()
    {
        $playerScore = $this->gameState->getPlayerScore();
        $bankScore = $this->gameState->getBankScore();

        if ($playerScore > Game::MAX_POINTS) {
            $this->gameState->setWinner('bank');
            return;
        }

        if ($bankScore > Game::MAX_POINTS) {
            $this->gameState->setWinner('player');
            return;
        }

        if ($bankScore >= $playerScore) {
            $this->gameState->setWinner('bank');
            return;
        }

        $this->gameState->setWinner('player');
    }

    /**
     * Determine winner and update game state.
     * @return void
     */
    public function determineWinner()
    {
        $this->setWinner();

        $this->gameState->update($this->deck, $this->player, $this->bank);;
    }


}
