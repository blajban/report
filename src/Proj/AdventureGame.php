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

const ROOMS = [
    [
        'name' => 'Ett rum',
        'description' => 'Det här är ett rum'
    ],
    [
        'name' => 'Ett annat rum',
        'description' => 'Det här är ett annat rum'
    ],
    [
        'name' => 'Ett tredje rum',
        'description' => 'Det här är ett tredje rum'
    ],
    [
        'name' => 'Ett fjärde rum',
        'description' => 'Det här är ett fjärde rum'
    ],
    [
        'name' => 'Ett femte rum',
        'description' => 'Det här är ett femte rum'
    ],
    [
        'name' => 'Ett annat rum',
        'description' => 'Det här är ett annat rum'
    ],
    [
        'name' => 'Ett tredje rum',
        'description' => 'Det här är ett tredje rum'
    ],
    [
        'name' => 'Ett fjärde rum',
        'description' => 'Det här är ett fjärde rum'
    ],
    [
        'name' => 'Ett femte rum',
        'description' => 'Det här är ett femte rum'
    ],
    [
        'name' => 'Ett annat rum',
        'description' => 'Det här är ett annat rum'
    ],
    [
        'name' => 'Ett tredje rum',
        'description' => 'Det här är ett tredje rum'
    ],
    [
        'name' => 'Ett fjärde rum',
        'description' => 'Det här är ett fjärde rum'
    ],
    [
        'name' => 'Ett femte rum',
        'description' => 'Det här är ett femte rum'
    ],
    [
        'name' => 'Ett annat rum',
        'description' => 'Det här är ett annat rum'
    ],
    [
        'name' => 'Ett tredje rum',
        'description' => 'Det här är ett tredje rum'
    ],
    [
        'name' => 'Ett fjärde rum',
        'description' => 'Det här är ett fjärde rum'
    ],
    [
        'name' => 'Ett femte rum',
        'description' => 'Det här är ett femte rum'
    ],
    [
        'name' => 'Ett annat rum',
        'description' => 'Det här är ett annat rum'
    ],
    [
        'name' => 'Ett tredje rum',
        'description' => 'Det här är ett tredje rum'
    ],
    [
        'name' => 'Ett fjärde rum',
        'description' => 'Det här är ett fjärde rum'
    ],
    [
        'name' => 'Ett femte rum',
        'description' => 'Det här är ett femte rum'
    ]
];

const ITEMS = [
    [
        'name' => 'Ett item',
        'description' => 'Det här är ett item'
    ],
    [
        'name' => 'Ett annat item',
        'description' => 'Det här är ett annat item'
    ],
    [
        'name' => 'Ett tredje item',
        'description' => 'Det här är tredje ett item'
    ]
];

class AdventureGame
{
    private Map $map;
    private array $rooms;

    public function __construct()
    {
        foreach (ROOMS as $roomInfo) {
            $room = new Room($roomInfo['name'], $roomInfo['description']);
            $room->addItem(ITEMS[0]);
            $this->rooms[] = $room;
            
        }
        $this->map = new Map($this->rooms);
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
