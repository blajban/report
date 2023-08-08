<?php

namespace App\Proj;

use App\Entity\Item;
use Exception;

class Player
{
    private string $name;

    /**
     * @var array<int|string, Item> $inventory
     */
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

    /**
     * @return void
     */
    public function addToInventory(Item $item)
    {
        $this->inventory[$item->getId()] = $item;
    }

    public function dropFromInventory(int $itemId): Item|null
    {
        if (array_key_exists($itemId, $this->inventory)) {
            $item = $this->inventory[$itemId];
            unset($this->inventory[$itemId]);
            return $item;
        }

        return null;
    }

    /**
     * @return array<int|string, Item>
     */
    public function getInventory(): array
    {
        return $this->inventory;
    }
}
