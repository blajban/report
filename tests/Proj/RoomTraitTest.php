<?php

namespace App\Proj;

use App\Entity\Room;
use App\Entity\Item;

use PHPUnit\Framework\TestCase;

/**
 * Test cases for Room Trait.
 */
class RoomTraitTest extends TestCase
{
    public function testAddDoorAndGetDoors(): void
    {
        $room = new Room();
        $otherRoom = $this->createMock(Room::class);

        $room->addDoor('north', $otherRoom);

        $res = $room->getDoors();
        $exp = [
            'north' => $otherRoom,
            'south' => null,
            'east' => null,
            'west' => null
        ];

        $this->assertEquals($exp, $res);
    }

    public function testAddItemAndGetItems(): void
    {
        $room = new Room();
        $item = $this->createMock(Item::class);
        $item->method('getId')->willReturn(1);

        $room->addItem($item);

        $res = $room->getItems()[$item->getId()];
        $this->assertEquals($item, $res);
    }

    public function testTakeItem(): void
    {
        $room = new Room();
        $item = $this->createMock(Item::class);
        $item->method('getId')->willReturn(1);

        $room->addItem($item);

        $res = $room->takeItem(1);
        $this->assertEquals($item, $res);
    }

    public function testTakeItemIfNull(): void
    {
        $room = new Room();

        $res = $room->takeItem(1);
        $this->assertNull($res);
    }

    public function testContainsItemIfTrue(): void
    {
        $room = new Room();
        $item = $this->createMock(Item::class);
        $item->method('getId')->willReturn(1);

        $room->addItem($item);

        $res = $room->containsItem($item);
        $this->assertTrue($res);
    }

    public function testContainsItemIfFalse(): void
    {
        $room = new Room();
        $item = $this->createMock(Item::class);
        $item->method('getId')->willReturn(1);

        $res = $room->containsItem($item);
        $this->assertFalse($res);
    }

}
