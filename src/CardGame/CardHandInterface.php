<?php

namespace App\CardGame;

use App\CardGame\Card;

/**
 * Cardhand interface.
 */
interface CardHandInterface
{
    /**
     * Add card to hand.
     * @param Card $card
     * @return void
     */
    public function addCard(Card $card);

    /**
     * Get current hand.
     * @return array<Card>
     */
    public function getHand(): array;

    /**
     * Discard hand.
     * @return void
     */
    public function discardHand();
}
