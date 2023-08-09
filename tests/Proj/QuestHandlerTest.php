<?php

namespace App\Proj;

use App\Entity\Room;
use App\Entity\Item;

use PHPUnit\Framework\TestCase;
use Exception;

    

/**
 * To be able to test quest completions correctly
 */
class QuestHandlerMock extends QuestHandler
{
    public function setQuests($quests)
    {
        $this->quests = $quests;
    }
}

/**
 * Test cases for QuestHandler class.
 */
class QuestHandlerTest extends TestCase
{
    public function testGenerateQuests()
    {
        $rooms = [ 
            $this->createMock(Room::class),
            $this->createMock(Room::class),
            $this->createMock(Room::class)
        ];

        $items = [ 
            $this->createMock(Item::class),
            $this->createMock(Item::class),
            $this->createMock(Item::class)
        ];

        $questHandler = new QuestHandler();

        $questHandler->generateQuests($rooms, $items, 3);

        $res = count($questHandler->getQuests());
        $exp = 3;

        $this->assertEquals($exp, $res);
    }

    public function testGenerateQuestsException()
    {
        $rooms = [ 
            $this->createMock(Room::class),
            $this->createMock(Room::class)
        ];

        $items = [ 
            $this->createMock(Item::class),
            $this->createMock(Item::class)
        ];

        $questHandler = new QuestHandler();

        $this->expectException(Exception::class);
        $questHandler->generateQuests($rooms, $items, 5);
    }

    public function testShowHintIfNotNull()
    {
        $rooms = [ 
            $this->createMock(Room::class),
            $this->createMock(Room::class)
        ];

        $items = [ 
            $this->createMock(Item::class),
            $this->createMock(Item::class)
        ];

        $questHandler = new QuestHandler();
        $questHandler->generateQuests($rooms, $items, 1);

        $quest = $questHandler->getQuests()[0];

        $res = $questHandler->showHint($quest->getId());

        $this->assertSame($quest, $res);
    }

    public function testShowHintIfNull()
    {
        $questHandler = new QuestHandler();

        $res = $questHandler->showHint(1);

        $this->assertNull($res);
    }

    public function testUpdateQuestCompletion()
    {
        $roomWithItem = $this->createMock(Room::class);
        $roomWithoutItem = $this->createMock(Room::class);
        $targetItem = $this->createMock(Item::class);

        $completedQuest = $this->createPartialMock(Quest::class, ['completeQuest', 'getTargetItem', 'getTargetRoom']);
        $incompleteQuest = $this->createPartialMock(Quest::class, ['completeQuest', 'getTargetItem', 'getTargetRoom']);

        $roomWithItem->method('getItems')->willReturn([$targetItem]);
        $roomWithoutItem->method('getItems')->willReturn([]);

        $completedQuest->method('getTargetItem')->willReturn($targetItem);
        $completedQuest->method('getTargetRoom')->willReturn($roomWithItem);
        $completedQuest->expects($this->once())->method('completeQuest');

        $incompleteQuest->method('getTargetItem')->willReturn($targetItem);
        $incompleteQuest->method('getTargetRoom')->willReturn($roomWithoutItem);
        $incompleteQuest->expects($this->never())->method('completeQuest');

        $questHandler = new QuestHandlerMock();
        $questHandler->setQuests([$completedQuest, $incompleteQuest]);

        $questHandler->updateQuestCompletion();
    }

    public function testAllQuestsCompleted()
    {
        $roomWithItem = $this->createMock(Room::class);
        $targetItem = $this->createMock(Item::class);

        $completedQuest = $this->createPartialMock(Quest::class, ['isComplete']);

        $completedQuest->method('isComplete')->willReturn(true);

        $questHandler = new QuestHandlerMock();
        $questHandler->setQuests([$completedQuest]);

        $res = $questHandler->allQuestsCompleted();
        $this->assertTrue($res);
    }

    public function testAllQuestsCompletedFalse()
    {
        $completedQuest = $this->createPartialMock(Quest::class, ['isComplete']);

        $completedQuest->method('isComplete')->willReturn(false);

        $questHandler = new QuestHandlerMock();
        $questHandler->setQuests([$completedQuest]);

        $res = $questHandler->allQuestsCompleted();
        $this->assertFalse($res);
    }


   
}
