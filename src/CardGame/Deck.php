<?php

namespace App\CardGame;

use App\CardGame\Card;
use Exception;

/**
 * Deck interface
 */
interface DeckInterface
{
    /**
     * Constructor
     * @return void
     */
    public function __construct();

    /**
     * Get the deck of cards as an array.
     * @return array<Card>
     */
    public function getDeck(): array;

    /**
     * Sort the deck by color and value.
     * @return void
     */
    public function sortDeck();

    /**
     * Check if deck is empty.
     * @return bool
     */
    public function isEmpty(): bool;

    /**
     * Get the number of cards left in deck.cards
     */ 
    public function drawCard(): Card|false;

    /**
     * Look at the top card of deck without removing it.
     * @return Card|false
     */
    public function peek(): Card|false;

    /**
     * Shuffle deck.
     * @return void
     */
    public function shuffleDeck();
}

/**
 * Deck class
 */
class Deck implements DeckInterface
{
    /**
     * @var array<Card> $deck
     */
    protected $deck = [];

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->addCardsToDeck(Card::HEARTS);
        $this->addCardsToDeck(Card::TILES);
        $this->addCardsToDeck(Card::SPADES);
        $this->addCardsToDeck(Card::CLUBS);
    }

    /**
     * Add cards with a specific color.
     * @param int $color number representing the color of the cards to add.
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

    /**
     * Compare two cards based on their values.
     * @param Card $card1
     * @param Card $card2
     * @return int
     */
    private function compareCards(Card $card1, Card $card2): int
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

    public function drawCard(): Card
    {
        $cardToDraw = $this->peek();
        array_pop($this->deck);
        return $cardToDraw;
    }

    public function peek(): Card
    {
        if (empty($this->deck)) {
            throw new Exception('Deck empty');
        }

        /** @var Card $cardToPeek */
        $cardToPeek = end($this->deck);

        return $cardToPeek;
    }

    public function shuffleDeck()
    {
        shuffle($this->deck);
    }
}
