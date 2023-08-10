<?php

namespace App\Proj;

use App\Entity\Item;
use App\Entity\Room;

use PHPUnit\Framework\TestCase;
use Exception;


/**
 * Test cases for Map class.
 */
class MapTest extends TestCase
{
    public function testConstructionAndGetRooms()
    {
        $rooms = [ 
            $this->createMock(Room::class),
            $this->createMock(Room::class)
        ];

        $map = new Map($rooms);

        $this->assertInstanceOf("\App\Proj\Map", $map);
    }

    public function testGetCurrentRoom()
    {
        $rooms = [ 
            $this->createMock(Room::class)
        ];

        $map = new Map($rooms);

        $res = $map->getCurrentRoom();

        $this->assertEquals($rooms[0], $res);
    }

    public function testMove()
    {
        $rooms = [
            $this->createMock(Room::class),
            $this->createMock(Room::class)
        ];
        
        $map = new Map($rooms);
        
        $currentRoom = $map->getCurrentRoom();
        $allRooms = $map->getRooms();
        
        $filteredRooms = array_filter($allRooms, function($room) use ($currentRoom) {
            return $room !== $currentRoom;
        });

        $otherRoom = array_values($filteredRooms)[0];

        $currentRoom->method('getDoors')->willReturn(['north' => $otherRoom]);

        $map->move('north');

        $nextCurrentRoom = $map->getCurrentRoom();

        $this->assertEquals($otherRoom, $nextCurrentRoom);
    }

    public function testGetRooms()
    {
        $rooms = [ 
            $this->createMock(Room::class),
            $this->createMock(Room::class)
        ];

        $map = new Map($rooms);

        $res = $map->getRooms();

        $this->assertEquals($rooms, $res);
    }

    public function testGetGrid()
    {
        $rooms = [ 
            $this->createMock(Room::class),
            $this->createMock(Room::class),
            $this->createMock(Room::class),
            $this->createMock(Room::class)
        ];

        $map = new Map($rooms);

        $res = $map->getGrid();

        $exp = [
            [ $rooms[0], $rooms[1] ],
            [ $rooms[2], $rooms[3] ]
        ];

        $this->assertEquals($exp, $res);

        
    }

}
