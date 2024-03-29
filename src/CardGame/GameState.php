<?php

namespace App\CardGame;

use App\CardGame\Player;
use App\CardGame\Bank;
use App\CardGame\Deck;

/**
 * Game class.
 */
class GameState
{
    /**
     * @var array{
     *   player: array{name: string, score: int, hand: array<Card>},
     *   bank: array{name: string, score: int, hand: array<Card>},
     *   remaining_cards: int,
     *   winner: string
     * }
     */
    private array $gameState;

    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->reset();
    }

    /**
     * Update game state.
     * @return void
     */
    public function update(Deck $deck, Player $player, Bank $bank)
    {
        $this->gameState['player']['name'] = $player->getName();
        $this->gameState['remaining_cards'] = $deck->remainingCards();
        $this->gameState['player']['hand'] = $player->getHand();
        $this->gameState['bank']['hand'] = $bank->getHand();
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
    public function get(): array
    {
        return $this->gameState;
    }

    /**
     * Get current game state prepared for json with cards as string.
     * @return array{
     *   player: array{name: string, score: int, hand: array<Card>, handAsString?: array<array<string, mixed>>},
     *   bank: array{name: string, score: int, hand: array<Card>, handAsString?: array<array<string, mixed>>},
     *   remaining_cards: int,
     *   winner: string
     * }
     */
    public function getJson(): array
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
     * Reset game state.
     * @return void
     */
    public function reset()
    {
        $this->gameState = [
            'player' => [
                'name' => '',
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
    }

    public function getPlayerScore(): int
    {
        return $this->gameState['player']['score'];
    }

    /**
     * @return void
     */
    public function setPlayerScore(int $score)
    {
        $this->gameState['player']['score'] = $score;
    }

    public function getBankScore(): int
    {
        return $this->gameState['bank']['score'];
    }

    /**
     * @return void
     */
    public function setBankScore(int $score)
    {
        $this->gameState['bank']['score'] = $score;
    }

    /**
     * @return void
     */
    public function setWinner(string $winner)
    {
        $this->gameState['winner'] = $winner;
    }


}
