<?php

namespace App\Proj;

use App\Proj\Map;
use App\Proj\Player;
use App\Entity\Room;


class AdventureGame
{
    private string $debug = 'Debug';
    private int $moves = 0;
    private $hintedRoom = null;
    private $hintedItem = null;
    private Map $map;
    private Player $player;
    private QuestHandler $questHandler;

    public function __construct($rooms, $items, $playerName, $numberOfQuests)
    {
        $this->player = new Player($playerName);

        $itemDistributor = new ItemDistributor($items);
        $itemDistributor->distributeItems($rooms);

        $this->questHandler = new QuestHandler();
        $this->questHandler->generateQuests($rooms, $items, $numberOfQuests);

        $this->map = new Map($rooms);
    }

    public function move($direction)
    {
        $this->map->move($direction);
        $this->moves++;
    }

    public function takeItem($itemId)
    {
        $currentRoom = $this->map->getCurrentRoom();
        $item = $currentRoom->takeItem($itemId);
        $this->player->addToInventory($item);
    }

    public function dropItem($itemId)
    {
        $currentRoom = $this->map->getCurrentRoom();
        $item = $this->player->dropFromInventory($itemId);
        $currentRoom->addItem($item);
    }

    public function playerWins(): bool
    {
        return $this->questHandler->allQuestsCompleted();
    }

    public function updateQuests()
    {
        $this->questHandler->updateQuestCompletion();
    }

    public function showHint($questId)
    {
        $this->hintedRoom = $this->questHandler->getRoomWithQuest($questId);
        $this->hintedItem = $this->questHandler->getRoomWithQuestItem($questId, $this->map->getRooms());
    }

    public function hideHint()
    {
        $this->hintedRoom = null;
        $this->hintedItem = null;
    }

    public function getState(): array
    {
        $this->questHandler->updateQuestCompletion();

        return [
            'currentRoom' => $this->map->getCurrentRoom(),
            'rooms' => $this->map->getRooms(),
            'grid' => $this->map->getGrid(),
            'player' => $this->player,
            'quests' => $this->questHandler->getQuests(),
            'hint' => [
                'room' => $this->hintedRoom,
                'item' => $this->hintedItem
            ],
            'moves' => $this->moves,
            'debug' => $this->debug
        ];
    }

    public function setDebugText($text)
    {
        $this->debug = $text;
    }


}
