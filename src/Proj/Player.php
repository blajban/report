<?php

namespace App\Proj;
use Exception;



class Player
{
    private string $name;
    private array $inventory;

    public function __construct(string $playerName)
    {
        $this->inventory = [];
        $this->name = $playerName;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function addToInventory($item)
    {
        $this->inventory[$item['id']] = $item;
    }

    public function getInventory(): array
    {
        return $this->inventory;
    }
}
