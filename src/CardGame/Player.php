<?php

namespace App\CardGame;

use App\CardGame\Card;

interface CardHandInterface
{
    public function addCard(Card $card);
    public function getHand(): array;
    public function discardHand();
}

trait CardHandTrait
{
    private $hand = [];

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


class Player implements CardHandInterface
{
    use CardHandTrait;

    private $name;

    public function __construct(string $playerName)
    {
        $this->name = $playerName;
    }

    public function getName(): string
    {
        return $this->name;
    }
}
