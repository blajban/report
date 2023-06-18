<?php

namespace App\Proj;


use Exception;

use App\Proj\Map;
use App\Proj\Player;
use App\Proj\Room;


class AdventureGame
{
    private string $debug = 'Debug';
    private Map $map;
    private Player $player;
    private QuestHandler $questHandler;
    //private array $rooms;

    public function __construct($roomInfos, $items)
    {
        $this->player = new Player('Erik');

        $rooms = [];
        foreach ($roomInfos as $roomInfo) {
            $room = new Room($roomInfo->getId(), $roomInfo->getName(), $roomInfo->getDescription());
            $rooms[] = $room;
            
        }

        $itemDistributor = new ItemDistributor($items);
        $itemDistributor->distributeItems($rooms);

        $this->questHandler = new QuestHandler($rooms, $items);

        $this->map = new Map($rooms, $items);
    }

    public function move($direction)
    {
        $this->map->move($direction);
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

    public function updateQuests()
    {
        // TODO
    }

    public function setDebugText($text)
    {
        $this->debug = $text;
    }

    public function getState(): array
    {
        return [
            'currentRoom' => $this->map->getCurrentRoom(),
            'rooms' => $this->map->getRooms(),
            'grid' => $this->map->getGrid(),
            'player' => $this->player,
            'debug' => $this->debug
        ];
    }


}
