<?php

namespace App\CardGame;

use App\CardGame\Card;

interface DeckInterface
{
    /**
     * @return void
     */
    public function __construct();

    /**
     * @return array<Card>
     */
    public function getDeck(): array;

    public function compareCards(Card $card1, Card $card2): int;

    /**
     * @return void
     */
    public function sortDeck();
    public function isEmpty(): bool;
    public function remainingCards(): int;
    public function drawCard(): Card|false;
    public function peek(): Card|false;

    /**
     * @return void
     */
    public function shuffleDeck();
}

class Deck implements DeckInterface
{
    /**
     * @var array<Card> $deck
     */
    protected $deck = [];

    public function __construct()
    {
        $this->addCardsToDeck(Card::HEARTS);
        $this->addCardsToDeck(Card::TILES);
        $this->addCardsToDeck(Card::SPADES);
        $this->addCardsToDeck(Card::CLUBS);
    }

    /**
     * @return void
     */
    private function addCardsToDeck(int $color)
    {
        $maxEachColor = 14;
        for ($i = 1; $i < $maxEachColor; $i++) {
            $this->deck[] = new Card($i, $color);
        }
    }

    public function getDeck(): array
    {
        return $this->deck;
    }

    public function compareCards(Card $card1, Card $card2): int
    {
        return $card1->getValue() - $card2->getValue();
    }

    public function sortDeck()
    {
        $colors = [
            "hearts" => [],
            "spades" => [],
            "tiles" => [],
            "clubs" => [],
            "joker" => []
        ];

        foreach ($this->deck as $card) {
            $colors[$card->getCssColor()][] = $card;
        }

        foreach ($colors as $color => $cards) {
            usort($cards, [$this, 'compareCards']);
            $colors[$color] = $cards;
        }

        $this->deck = [];

        foreach ($colors as $color => $cards) {
            foreach ($cards as $card) {
                $this->deck[] = $card;
            }
        }
    }

    public function isEmpty(): bool
    {
        if ($this->remainingCards() > 0) {
            return false;
        }

        return true;
    }

    public function remainingCards(): int
    {
        return count($this->deck);
    }

    public function drawCard(): Card|false
    {
        $cardToDraw = $this->peek();
        array_pop($this->deck);
        return $cardToDraw;
    }

    public function peek(): Card|false
    {
        return end($this->deck);
    }

    public function shuffleDeck()
    {
        shuffle($this->deck);
    }
}
