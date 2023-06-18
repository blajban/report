<?php

namespace App\Proj;
use Exception;

class Quest
{
    private string $name;
    private Room $room;
    private array $item;
    private bool $completed = false;

    public function __construct($room, $item)
    {
        $this->room = $room;
        $this->item = $item;
        $this->name = "Fetch the {$this->item['name']} for room {$this->room->getName()}";
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getTargetRoom(): Room
    {
        return $this->room;
    }

    public function getTargetItem(): array
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

