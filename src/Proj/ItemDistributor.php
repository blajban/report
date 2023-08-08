<?php

namespace App\Proj;
use App\Entity\Item;
use App\Entity\Room;
use Exception;

class ItemDistributor
{
    /**
     * @var array<Item> $items
     */
    private array $items = [];

    /**
     * @param array<Item> $items
     */
    public function __construct($items)
    {
        $this->items = $items;
    }

    /**
     * @return void
     * @param array<Room> $rooms
     */
    public function distributeItems($rooms)
    {
        foreach ($this->items as $item) {
            /** @phpstan-ignore-next-line */
            $roomNo = random_int(0, count($rooms) - 1);
            $rooms[$roomNo]->addItem($item);
        }
    }
}
