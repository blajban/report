<?php

namespace App\Proj;

use App\Entity\Room;
use App\Entity\Item;
use Exception;

class QuestHandler
{
    /**
     * @var array<Quest> $quests
     */
    protected array $quests = [];

    public function __construct()
    {

    }

    /**
     * @param array<Room> $rooms
     * @param array<Item> $items
     * @return void
     */
    public function generateQuests($rooms, $items, int $numberOfQuests)
    {
        $copiedItems = $items;

        if ($numberOfQuests > count($items) || $numberOfQuests > count($rooms)) {
            $numberOfQuests = count($items);
        }

        for ($i = 0; $i < $numberOfQuests; $i++) {
            $randomRoomIndex = array_rand($rooms);
            $room = $rooms[$randomRoomIndex];

            $randomItemIndex = array_rand($copiedItems);
            $item = $copiedItems[$randomItemIndex];
            unset($copiedItems[$randomItemIndex]);

            while($room->containsItem($item)) {
                $randomRoomIndex = array_rand($rooms);
                $room = $rooms[$randomRoomIndex];
            }

            $quest = new Quest($i, $room, $item);
            $item->setQuest($quest);
            $this->quests[] = $quest;
        }
    }

    /**
     * @return array<Quest>
     */
    public function getQuests(): array
    {
        return $this->quests;
    }

    public function showHint(int $questId): Quest|null
    {
        $quest = $this->getQuestWithId($questId);
        if ($quest !== null) {
            $quest->showHint();
        }

        return $quest;
    }

    public function hideHint(int $questId)
    {
        $quest = $this->getQuestWithId($questId);
        if ($quest !== null) {
            $quest->hideHint();
        }

        return $quest;
    }

    private function getQuestWithId(int $questId): Quest|null
    {
        foreach ($this->quests as $quest) {
            if ($quest->getId() == $questId) {
                return $quest;
            }
        }

        return null;
    }

    /**
     * @return void
     */
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

    /**
     * @param array<Item> $roomItems
     */
    private function checkItemInRoom(Item $targetItem, $roomItems): bool
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
