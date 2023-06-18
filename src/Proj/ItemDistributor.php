<?php

namespace App\Proj;
use Exception;



class ItemDistributor
{
    private array $items = [];

    public function __construct($items)
    {
        $this->items = $items;
    }

    public function distributeItems($rooms)
    {
        foreach ($this->items as $item) {
            $roomNo = random_int(0, count($rooms) - 1);
            $rooms[$roomNo]->addItem($item);
        }
    }
}
