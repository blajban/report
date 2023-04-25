<?php

namespace App\CardGame;

use App\CardGame\CardHandInterface;
use App\CardGame\CardHandTrait;


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
