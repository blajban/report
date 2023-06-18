<?php

namespace App\Proj;
use Exception;


class QuestHandler
{
    private array $quests = [];

    public function __construct($rooms, $items)
    {
        $this->generateQuests($rooms, $items);
    }

    private function generateQuests($rooms, $items)
    {
        // TODO
        $this->quests[] = new Quest($rooms[0], $items[0]);
    }

    public function getQuests(): array
    {
        return $this->quests;
    }

    public function checkQuestCompletion()
    {
        foreach ($this->quests as $quest) {
            $targetItem = $quest->getTargetItem();
            $room = $quest->getTargetRoom();

            $roomItems = $room->getItems();
            
            $complete = $this->checkItemInRoom($targetItem, $roomItems);

            if ($complete) {
                $quest->completeQuest();
            }
        }
    }

    private function checkItemInRoom($targetItem, $roomItems): bool
    {
        foreach ($roomItems as $roomItem) {
            if ($targetItem['id'] == $roomItem['id']) {
                return true;
            }
        }

        return false;
    }
}
