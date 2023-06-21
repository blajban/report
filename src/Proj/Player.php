<?php

namespace App\Proj;

use App\Entity\Item;
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
        $this->inventory[$item->getId()] = $item;
    }

    public function dropFromInventory($itemId): Item
    {
        if (array_key_exists($itemId, $this->inventory)) {
            $item = $this->inventory[$itemId];
            unset($this->inventory[$itemId]);
            return $item;
        }

        return null;
    }

    public function getInventory(): array
    {
        return $this->inventory;
    }
}
