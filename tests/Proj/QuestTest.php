<?php

namespace App\Proj;

use App\Entity\Room;
use App\Entity\Item;

use PHPUnit\Framework\TestCase;

/**
 * Test cases for Quest class.
 */
class QuestTest extends TestCase
{
    public function testConstructQuestAndGetters()
    {
        $room = $this->createMock(Room::class);
        $room->method('getName')->willReturn('ROOM');
        $item = $this->createMock(Item::class);
        $item->method('getName')->willReturn('ITEM');

        $quest = new Quest(1, $room, $item);

        $res = $quest->getId();
        $exp = 1;
        $this->assertEquals($exp, $res);

        $res = $quest->getTargetRoom();
        $this->assertEquals($room, $res);

        $res = $quest->getTargetItem();
        $this->assertEquals($item, $res);

        $res = $quest->getName();
        $exp = "Fetch the ITEM for room ROOM";
        $this->assertEquals($exp, $res);
    }

    public function testCompleteQuest()
    {
        $room = $this->createMock(Room::class);
        $item = $this->createMock(Item::class);

        $quest = new Quest(1, $room, $item);

        $res = $quest->isComplete();
        $this->assertFalse($res);

        $quest->completeQuest();

        $res = $quest->isComplete();
        $this->assertTrue($res);
    }

    public function testShowHideHint()
    {
        $room = $this->createMock(Room::class);
        $item = $this->createMock(Item::class);

        $quest = new Quest(1, $room, $item);

        $res = $quest->isHintShown();
        $this->assertFalse($res);

        $quest->showHint();
        $res = $quest->isHintShown();
        $this->assertTrue($res);

        $quest->hideHint();
        $res = $quest->isHintShown();
        $this->assertFalse($res);
    }

}
