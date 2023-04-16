<?php

namespace App\CardGame\CardGame;

use App\CardGame\Deck\Deck;
use App\CardGame\Card\Card;

interface CardGameInterface
{
    public function __construct($session);
    public function getDeck(): array;
    public function shuffle();
    public function draw($number): array;
    public function remainingCards(): int;
}

class CardGame implements CardGameInterface
{
    protected $deck;
    protected $session;

    public function __construct($session)
    {
        $this->session = $session;
    }

    public function getDeck(): array
    {
        $this->deck = $this->session->get("deck") ?? new Deck();
        return $this->deck->getDeck();
    }

    public function shuffle()
    {
        $this->deck = new Deck();
        $this->deck->shuffleDeck();
        $this->session->set("deck", $this->deck);
    }

    public function draw($number): array
    {
        $this->deck = $this->session->get("deck") ?? new Deck();
        $cardsDrawn = [];

        if ($this->deck->remainingCards() < $number) {
            $cardsDrawn = $this->session->get("cards_drawn");
            $this->session->set("deck", $this->deck);
            return $cardsDrawn;
        }

        for ($i = 0; $i < $number; $i++) {
            $cardsDrawn[] = $this->deck->drawCard();
        }

        $this->session->set("cards_drawn", $cardsDrawn);

        $this->session->set("deck", $this->deck);

        return $cardsDrawn;
    }

    public function remainingCards(): int
    {
        $this->deck = $this->session->get("deck") ?? new Deck();
        return $this->deck->remainingCards();
    }
}
