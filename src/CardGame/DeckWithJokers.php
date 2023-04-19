<?php

namespace App\CardGame;

use App\CardGame\Deck;
use App\CardGame\Card;

class DeckWithJokers extends Deck
{
    public function __construct()
    {
        parent::__construct();
        $this->deck[] = new Card(0, Card::JOKER, true);
        $this->deck[] = new Card(0, Card::JOKER, true);
    }
}
