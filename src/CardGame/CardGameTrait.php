<?php

namespace App\CardGame;

trait CardGameTrait
{
    /**
     * @var Deck $deck
     */
    protected $deck;

    /**
     * @var SessionInterface $session
     */
    protected $session;

    public function getDeck(): array
    {
        return $this->deck->getDeck();
    }

    public function getJsonDeck(): array
    {
        $jsonDeck = [];

        foreach ($this->deck->getDeck() as $card) {
            $jsonDeck[] = $card->toArray();
        }

        return $jsonDeck;

    }

    public function remainingCards(): int
    {
        return $this->deck->remainingCards();
    }

}
