<?php

namespace App\CardGame;

use App\CardGame\Card;

interface CardHandInterface
{
    /**
     * @param Card $card
     * @return void
     */
    public function addCard(Card $card);

    /**
     * @return array<Card>
     */
    public function getHand(): array;

    /**
     * @return void
     */
    public function discardHand();
}
