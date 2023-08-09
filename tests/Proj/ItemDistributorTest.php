<?php

namespace App\Proj;

use App\Entity\Item;
use App\Entity\Room;

use PHPUnit\Framework\TestCase;
use Exception;


/**
 * Test cases for ItemDistributor class.
 */
class ItemDistributorTest extends TestCase
{
    public function testConstruction()
    {
        $items = [ 
            $this->createMock(Item::class),
            $this->createMock(Item::class)
        ];

        $itemDistributor = new ItemDistributor($items);

        $this->assertInstanceOf("\App\Proj\ItemDistributor", $itemDistributor);
    }

    public function testDistributeItems()
    {

        $items = [ $this->createMock(Item::class) ];

        $itemDistributor = new ItemDistributor($items);

        $room = $this->createPartialMock(Room::class, ['addItem']);
        $room->expects($this->once())->method('addItem');
        
        $itemDistributor->distributeItems([$room]);


    }
}
