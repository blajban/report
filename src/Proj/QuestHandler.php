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
        $this->name = "Fetch the {$item->name} for room {$room->name}";
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getRoom(): Room
    {
        return $this->room;
    }

    public function getItem(): array
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

class QuestHandler
{
    private array $items = [];
    private array $rooms = [];
    private array $quests = [];

    public function __construct($rooms, $items)
    {
        $this->rooms = $rooms;
        $this->items = $items;
        $this->generateQuests();
    }

    private function generateQuests()
    {
        // TODO
    }
}
