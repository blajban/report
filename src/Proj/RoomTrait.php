<?php

namespace App\Proj;

use App\Entity\Room;
use App\Entity\Item;

trait RoomTrait
{
    /**
     * @var array<string, Room|null> $doors
     */
    private array $doors = [
        'north' => null,
        'south' => null,
        'east' => null,
        'west' => null
    ];

    /**
     * @var array<int|string, Item> $items
     */
    private array $items = [];

    /**
     * @return void
     */
    public function addDoor(string $direction, Room $room)
    {
        $this->doors[$direction] = $room;
    }

    /**
     * @return array<string, Room|null>
     */
    public function getDoors(): array
    {
        return $this->doors;
    }

    /**
     * @return void
     */
    public function addItem(Item $item)
    {
        $this->items[$item->getId()] = $item;
    }

    /**
     * @return array<int|string, Item>
     */
    public function getItems(): array
    {
        return $this->items;
    }

    public function takeItem(int $itemId): Item|null
    {
        if (array_key_exists($itemId, $this->items)) {
            $item = $this->items[$itemId];
            unset($this->items[$itemId]);
            return $item;
        }

        return null;
    }

    public function containsItem(Item $targetItem): bool
    {
        foreach ($this->items as $item) {
            if ($item->getId() == $targetItem->getId()) {
                return true;
            }
        }

        return false;
    }
}
