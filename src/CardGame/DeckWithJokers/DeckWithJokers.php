<?php

namespace App\CardGame\DeckWithJokers;

use App\CardGame\Deck\Deck;
use App\CardGame\Card\Card;

class DeckWithJokers extends Deck
{
    public function __construct()
    {
        parent::__construct();
        $this->deck[] = new Card(0, Card::JOKER, true);
        $this->deck[] = new Card(0, Card::JOKER, true);
    }
}
