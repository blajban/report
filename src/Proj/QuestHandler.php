<?php

namespace App\Proj;
use Exception;


class QuestHandler
{
    private array $quests = [];

    public function __construct()
    {

    }

    public function generateQuests($rooms, $items, $numberOfQuests)
    {
        $copiedItems = $items;

        for ($i = 0; $i < $numberOfQuests; $i++) {
            $randomRoomIndex = array_rand($rooms);
            $room = $rooms[$randomRoomIndex];

            $randomItemIndex = array_rand($copiedItems);
            $item = $copiedItems[$randomItemIndex];
            unset($copiedItems[$randomItemIndex]);

            $this->quests[] = new Quest($room, $item);
        }
    }

    public function getQuests(): array
    {
        return $this->quests;
    }

    public function updateQuestCompletion()
    {
        foreach ($this->quests as $quest) {
            $targetItem = $quest->getTargetItem();
            $targetRoom = $quest->getTargetRoom();

            $roomItems = $targetRoom->getItems();
            
            $complete = $this->checkItemInRoom($targetItem, $roomItems);

            if ($complete) {
                $quest->completeQuest();
            }
        }
    }

    private function checkItemInRoom($targetItem, $roomItems): bool
    {
        foreach ($roomItems as $roomItem) {
            if ($targetItem->getId() == $roomItem->getId()) {
                return true;
            }
        }

        return false;
    }

    public function allQuestsCompleted(): bool
    {
        foreach ($this->quests as $quest) {
            if (!$quest->isComplete()) {
                return false;
            }
        }

        return true;
    }
}
