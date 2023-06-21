<?php

namespace App\Proj;

use App\Entity\Item;
use App\Entity\Room;
use Exception;

class Quest
{
    private string $name;
    private Room $room;
    private Item $item;
    private bool $completed = false;

    public function __construct($room, $item)
    {
        $this->room = $room;
        $this->item = $item;
        $this->name = "Fetch the {$this->item->getName()} for room {$this->room->getName()}";
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getTargetRoom(): Room
    {
        return $this->room;
    }

    public function getTargetItem(): Item
    {
        return $this->item;
    }

    public function completeQuest()
    {
        $this->completed = true;
    }

    public function isComplete(): bool
    {
        return $this->completed;
    }
}

