<?php

namespace App\CardGame;

use App\CardGame\Card;

trait CardHandTrait
{
    /**
     * @var array<Card> $hand
     */
    private array $hand = [];

    public function addCard(Card $card)
    {
        $this->hand[] = $card;
    }

    public function getHand(): array
    {
        return $this->hand;
    }

    public function discardHand()
    {
        $this->hand = [];
    }
}
