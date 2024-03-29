<?php

namespace App\CardGame;

use Symfony\Component\HttpFoundation\Session\SessionInterface;

interface CardGameInterface
{
    /**
     * @return array<Card>
     */
    public function getDeck(): array;

    /**
     * @return array<Mixed>
     */
    public function getJsonDeck(): array;

    public function remainingCards(): int;


}
