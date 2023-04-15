<?php

namespace App\CardGame\Deck;

use App\CardGame\Card\Card;

interface DeckInterface
{
    public function __construct();
    public function getDeck(): array;
    public function sortDeck();
    public function resetDeck();
    public function isEmpty(): bool;
    public function remainingCards(): int;
    public function drawCard(): Card;
    public function peek(): Card;
    public function shuffleDeck();
}

class Deck implements DeckInterface
{
    protected $deck = [];

    public function __construct()
    {
        $this->addCardsToDeck(Card::HEARTS);
        $this->addCardsToDeck(Card::TILES);
        $this->addCardsToDeck(Card::SPADES);
        $this->addCardsToDeck(Card::CLUBS);
    }

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

    public function sortDeck()
    {
        // TODO
    }

    public function resetDeck()
    {
        // TODO
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

    public function drawCard(): Card
    {
        $cardToDraw = $this->peek();
        array_pop($this->deck);
        return $cardToDraw;
    }

    public function peek(): Card
    {
        return end($this->deck);
    }

    public function shuffleDeck()
    {
        shuffle($this->deck);
    }
}
