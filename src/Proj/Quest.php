<?php

namespace App\Proj;

use App\Entity\Item;
use App\Entity\Room;
use Exception;

class Quest
{
    private int $questId;
    private string $name;
    private Room $room;
    private Item $item;
    private bool $completed = false;
    private bool $hintShown = false;

    public function __construct(int $questId, Room $room, Item $item)
    {
        $this->questId = $questId;
        $this->room = $room;
        $this->item = $item;
        $this->name = "Fetch the {$this->item->getName()} for room {$this->room->getName()}";
    }

    public function getId(): int
    {
        return $this->questId;
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

    /**
     * @return void
     */
    public function completeQuest()
    {
        $this->completed = true;
    }

    public function isComplete(): bool
    {
        return $this->completed;
    }

    public function showHint(): void
    {
        $this->hintShown = true;
    }

    public function hideHint(): void
    {
        $this->hintShown = false;
    }

    public function isHintShown(): bool
    {
        return $this->hintShown;
    }
}
