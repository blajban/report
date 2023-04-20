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


class Player implements CardHandInterface
{
    use CardHandTrait;

    private string $name;

    public function __construct(string $playerName)
    {
        $this->name = $playerName;
    }

    public function getName(): string
    {
        return $this->name;
    }
}
