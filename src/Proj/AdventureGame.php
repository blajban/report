<?php

namespace App\Proj;

use App\CardGame\CardGameInterface;
use App\CardGame\CardGameTrait;
use App\CardGame\Player;
use App\CardGame\Bank;
use App\CardGame\Deck;
use App\CardGame\GameState;
use Exception;

use App\Proj\Map;
use App\Proj\Room;


class AdventureGame
{
    private Map $map;
    //private array $rooms;

    public function __construct($roomInfos, $items)
    {
        $rooms = [];
        foreach ($roomInfos as $roomInfo) {
            $room = new Room($roomInfo->getId(), $roomInfo->getName(), $roomInfo->getDescription());
            $rooms[] = $room;
            
        }

        $itemDistributor = new ItemDistributor($items);

        $itemDistributor->distributeItems($rooms);

        $this->map = new Map($rooms, $items);
    }

    public function move($direction)
    {
        $this->map->move($direction);
    }

    public function getState(): array
    {
        return [
            'currentRoom' => $this->map->getCurrentRoom(),
            'rooms' => $this->map->getRooms(),
            'grid' => $this->map->getGrid()
        ];
    }


}
