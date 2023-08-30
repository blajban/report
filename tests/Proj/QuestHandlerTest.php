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
    /**
     * @param array<Quest> $quests
     */
    public function setQuests(array $quests): void
    {
        $this->quests = $quests;
    }
}

/**
 * Test cases for QuestHandler class.
 */
class QuestHandlerTest extends TestCase
{
    public function testGenerateQuests(): void
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

    public function testGenerateQuestsIfNumberOfQuestsTooHigh(): void
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

        $questHandler->generateQuests($rooms, $items, 4);

        $res = count($questHandler->getQuests());
        $exp = 3;

        $this->assertEquals($exp, $res);
    }

    public function testGenerateQuestsWhenRoomContainsItem(): void
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

        $rooms[0]->method('containsItem')->with($items[0])->willReturn(true);

        $rooms[1]->method('containsItem')->willReturn(false);
        $rooms[2]->method('containsItem')->willReturn(false);

        $questHandler->generateQuests($rooms, $items, 3);

        $res = count($questHandler->getQuests());
        $exp = 3;

        $this->assertEquals($exp, $res);
    }


    public function testShowHintIfNotNull(): void
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

    public function testShowHintIfNull(): void
    {
        $questHandler = new QuestHandler();

        $res = $questHandler->showHint(1);

        $this->assertNull($res);
    }

    public function testHideHint(): void
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

        $res = $questHandler->hideHint($quest->getId());

        $this->assertSame($quest, $res);
    }

    public function testUpdateQuestCompletion(): void
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

    public function testAllQuestsCompleted(): void
    {
        $completedQuest = $this->createPartialMock(Quest::class, ['isComplete']);

        $completedQuest->method('isComplete')->willReturn(true);

        $questHandler = new QuestHandlerMock();
        $questHandler->setQuests([$completedQuest]);

        $res = $questHandler->allQuestsCompleted();
        $this->assertTrue($res);
    }

    public function testAllQuestsCompletedFalse(): void
    {
        $completedQuest = $this->createPartialMock(Quest::class, ['isComplete']);

        $completedQuest->method('isComplete')->willReturn(false);

        $questHandler = new QuestHandlerMock();
        $questHandler->setQuests([$completedQuest]);

        $res = $questHandler->allQuestsCompleted();
        $this->assertFalse($res);
    }



}
