<?php

namespace App\Proj;

use App\Entity\Item;
use PHPUnit\Framework\TestCase;

/**
 * Test cases for Player class.
 */
class PlayerTest extends TestCase
{
    public function testConstructPlayer()
    {
        $player = new Player("Test");
        $this->assertInstanceOf("\App\Proj\Player", $player);

        $res = $player->getName();
        $exp = "Test";
        $this->assertEquals($exp, $res);
    }

    public function testAddToInventoryAndGetInventory()
    {
        $player = new Player("Test");
        
        $item = $this->createMock(Item::class);
        $item->method('getId')->willReturn(1);

        $player->addToInventory($item);

        $res = $player->getInventory()[$item->getId()];
        $this->assertEquals($item, $res);
    }

    public function testDropFromInventory()
    {
        $player = new Player("Test");
        
        $item = $this->createMock(Item::class);
        $item->method('getId')->willReturn(1);

        $player->addToInventory($item);

        $res = $player->dropFromInventory($item->getId());

        $this->assertEquals($item, $res);
    }

    public function testDropFromInentoryIfIdDontExist()
    {
        $player = new Player("Test");

        $res = $player->dropFromInventory(4);

        $this->assertNull($res);
    }
}
