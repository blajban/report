<?php

namespace App\Proj;

use App\Entity\Item;
use App\Entity\Room;

use PHPUnit\Framework\TestCase;
use Exception;

class AdventureGameMock extends AdventureGame
{
    /**
     * @param Map $newMapObject
     */
    public function changeMapObject($newMapObject): void
    {
        $this->map = $newMapObject;
    }

    /**
     * @param Player $newPlayerObject
     */
    public function changePlayerObject($newPlayerObject): void
    {
        $this->player = $newPlayerObject;
    }

    /**
     * @param QuestHandler $newQHandlerObject
     */
    public function changeQuestHandlerObject($newQHandlerObject): void
    {
        $this->questHandler = $newQHandlerObject;
    }

    /**
     * @param Quest $newQuest
     */
    public function changeHintedQuest($newQuest): void
    {
        $this->hintedQuest = $newQuest;
    }
}


/**
 * Test cases for AdventureGame class.
 */
class AdventureGameTest extends TestCase
{
    public function testConstructionAndState(): void
    {
        $items = [
            $this->createMock(Item::class),
            $this->createMock(Item::class)
        ];

        $rooms = [
            $this->createMock(Room::class),
            $this->createMock(Room::class)
        ];

        $adventureGame = new AdventureGame($rooms, $items, "testName", 1);

        $this->assertInstanceOf("\App\Proj\AdventureGame", $adventureGame);

        $state = $adventureGame->getState();

        $this->assertEquals($rooms, $state['rooms']);
        $this->assertEquals(1, count($state['quests']));
    }

    public function testMove(): void
    {
        $mockedMap = $this->createMock(Map::class);
        $mockedMap->method('move')->willReturn(null);

        $rooms = [
            $this->createMock(Room::class),
            $this->createMock(Room::class)
        ];

        $adventureGame = new AdventureGameMock($rooms, [ $this->createMock(Item::class) ], "testName", 1);
        $adventureGame->changeMapObject($mockedMap);

        $adventureGame->move('west');

        $moves = $adventureGame->getState()['moves'];

        $this->assertEquals(1, $moves);
    }

    public function testTakeItem(): void
    {
        $rooms = [
            $this->createMock(Room::class),
            $this->createMock(Room::class)
        ];

        $items = [ $this->createMock(Item::class) ];

        $itemId = 123;

        $mockedMap = $this->createMock(Map::class);
        $mockedMap->method('getCurrentRoom')->willReturn($rooms[0]);

        $rooms[0]->method('takeItem')->with($itemId)->willReturn($items[0]);

        $mockedPlayer = $this->createMock(Player::class);
        $mockedPlayer->expects($this->once())->method('addToInventory')->with($items[0]);


        $adventureGame = new AdventureGameMock($rooms, $items, "testName", 1);
        $adventureGame->changeMapObject($mockedMap);
        $adventureGame->changePlayerObject($mockedPlayer);

        $adventureGame->takeItem($itemId);

    }

    public function testDropItem(): void
    {
        $rooms = [
            $this->createMock(Room::class),
            $this->createMock(Room::class)
        ];

        $items = [ $this->createMock(Item::class) ];

        $itemId = 123;

        $mockedMap = $this->createMock(Map::class);
        $mockedMap->method('getCurrentRoom')->willReturn($rooms[0]);

        $mockedPlayer = $this->createMock(Player::class);
        $mockedPlayer->method('dropFromInventory')->with($itemId)->willReturn($items[0]);

        $mockedPlayer->expects($this->once())->method('dropFromInventory');


        $adventureGame = new AdventureGameMock($rooms, $items, "testName", 1);
        $adventureGame->changeMapObject($mockedMap);
        $adventureGame->changePlayerObject($mockedPlayer);

        $adventureGame->dropItem($itemId);

    }

    public function testPlayerWins(): void
    {
        $rooms = [
            $this->createMock(Room::class),
            $this->createMock(Room::class)
        ];

        $items = [ $this->createMock(Item::class) ];

        $mockedQuestHandler = $this->createMock(QuestHandler::class);
        $mockedQuestHandler->method('allQuestsCompleted')->willReturn(true);


        $adventureGame = new AdventureGameMock($rooms, $items, "testName", 1);
        $adventureGame->changeQuestHandlerObject($mockedQuestHandler);

        $res = $adventureGame->playerWins();

        $this->assertTrue($res);

    }

    public function testUpdateQuests(): void
    {
        $rooms = [
            $this->createMock(Room::class),
            $this->createMock(Room::class)
        ];

        $items = [ $this->createMock(Item::class) ];

        $mockedQuestHandler = $this->createMock(QuestHandler::class);
        $mockedQuestHandler->expects($this->once())->method('updateQuestCompletion');


        $adventureGame = new AdventureGameMock($rooms, $items, "testName", 1);
        $adventureGame->changeQuestHandlerObject($mockedQuestHandler);

        $adventureGame->updateQuests();

    }

    public function testShowHint(): void
    {
        $questId = 123;

        $rooms = [
            $this->createMock(Room::class),
            $this->createMock(Room::class)
        ];

        $items = [ $this->createMock(Item::class) ];

        $mockedQuestHandler = $this->createMock(QuestHandler::class);
        $mockedQuest = $this->createMock(Quest::class);

        $mockedQuestHandler->expects($this->once())->method('showHint')->with($questId)->willReturn($mockedQuest);

        $adventureGame = new AdventureGameMock($rooms, $items, "testName", 1);
        $adventureGame->changeQuestHandlerObject($mockedQuestHandler);

        $adventureGame->showHint($questId);
    }

    public function testShowHintWhenHinted(): void
    {
        $questId = 123;

        $rooms = [
            $this->createMock(Room::class),
            $this->createMock(Room::class)
        ];

        $items = [ $this->createMock(Item::class) ];

        $mockedQuestHandler = $this->createMock(QuestHandler::class);
        $mockedQuest = $this->createMock(Quest::class);
        $mockedQuest->expects($this->once())->method('hideHint');

        $adventureGame = new AdventureGameMock($rooms, $items, "testName", 1);
        $adventureGame->changeQuestHandlerObject($mockedQuestHandler);
        $adventureGame->changeHintedQuest($mockedQuest);

        $adventureGame->showHint($questId);
    }

    public function testHideHint(): void
    {

        $rooms = [
            $this->createMock(Room::class),
            $this->createMock(Room::class)
        ];

        $items = [ $this->createMock(Item::class) ];

        $mockedQuestHandler = $this->createMock(QuestHandler::class);
        $mockedQuest = $this->createMock(Quest::class);
        $mockedQuest->expects($this->once())->method('hideHint');

        $adventureGame = new AdventureGameMock($rooms, $items, "testName", 1);
        $adventureGame->changeQuestHandlerObject($mockedQuestHandler);
        $adventureGame->changeHintedQuest($mockedQuest);

        $adventureGame->hideHint();
    }

    public function testSetDebugText(): void
    {
        $items = [
            $this->createMock(Item::class),
            $this->createMock(Item::class)
        ];

        $rooms = [
            $this->createMock(Room::class),
            $this->createMock(Room::class)
        ];

        $adventureGame = new AdventureGame($rooms, $items, "testName", 1);

        $debugText = "test";

        $adventureGame->setDebugText($debugText);

        $state = $adventureGame->getState();

        $this->assertEquals($debugText, $state['debug']);
    }

}
