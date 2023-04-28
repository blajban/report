<?php

namespace App\CardGame;

use Symfony\Component\HttpFoundation\Session\SessionInterface;
use App\CardGame\Deck;
use App\CardGame\DeckWithJokers;

trait CardGameTrait
{
    protected Deck|DeckWithJokers $deck;
    protected SessionInterface $session;

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
