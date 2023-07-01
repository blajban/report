<?php

namespace App\Proj;

trait RoomTrait
{
    private array $doors = [
        'north' => null,
        'south' => null,
        'east' => null,
        'west' => null
    ];
    private array $items = [];


    public function addDoor($direction, $room) {
        $this->doors[$direction] = $room;
    }

    public function getDoors(): array
    {
        return $this->doors;
    }

    public function addItem($item)
    {
        $this->items[$item->getId()] = $item;
    }

    public function getItems(): array
    {
        return $this->items;
    }

    public function takeItem($itemId) {
        if (array_key_exists($itemId, $this->items)) {
            $item = $this->items[$itemId];
            unset($this->items[$itemId]);
            return $item;
        }

        return null;
    }

    public function containsItem($targetItem)
    {
        foreach ($this->items as $item) {
            if ($item->getId() == $targetItem->getId()) {
                return true;
            }
        }
    
        return false;
    }
}
