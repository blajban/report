<?php

namespace App\Proj;

use App\Entity\Room;
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

            $this->quests[] = new Quest($i, $room, $item);
        }
    }

    public function getQuests(): array
    {
        return $this->quests;
    }

    private function getQuestWithId($questId): Quest
    {
        foreach ($this->quests as $quest) {
            if ($quest->getId() == $questId) {
                return $quest;
            }
        } 

        return null;
    }

    public function getRoomWithQuest($questId): Room|null
    {
        $quest = $this->getQuestWithId($questId);

        if ($quest) {
            return $quest->getTargetRoom();
        }

        return null;
    }

    public function getRoomWithQuestItem($questId, $rooms): Room|null
    {
        $targetQuest = $this->getQuestWithId($questId);
        $targetItem = $targetQuest->getTargetItem();

        // Nåt fel här
        foreach ($rooms as $room) {
            $items = $room->getItems();
            
            foreach ($items as $item) {
                if ($item->getId() == $targetItem->getId()) {
                    return $room;
                }
            }
        }

        return null;
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
