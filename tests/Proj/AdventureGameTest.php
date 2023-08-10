<?php

namespace App\Proj;

use App\Entity\Item;
use App\Entity\Room;

use PHPUnit\Framework\TestCase;
use Exception;

class AdventureGameMock extends AdventureGame
{
    public function changeMapObject($newMapObject)
    {
        $this->map = $newMapObject;
    }

    public function changePlayerObject($newPlayerObject)
    {
        $this->player = $newPlayerObject;
    }

    public function changeQuestHandlerObject($newQuestHandlerObject)
    {
        $this->questHandler = $newQuestHandlerObject;
    }
}

/**
 * Test cases for AdventureGame class.
 */
class AdventureGameTest extends TestCase
{
    public function testConstructionAndState()
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

    public function testMove()
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

    public function testTakeItem()
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

    public function testDropItem()
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
        
        $rooms[0]->expects($this->once())->method('addItem')->with($items[0]);


        $adventureGame = new AdventureGameMock($rooms, $items, "testName", 1);
        $adventureGame->changeMapObject($mockedMap);
        $adventureGame->changePlayerObject($mockedPlayer);

        $adventureGame->dropItem($itemId);

    }

    public function testPlayerWins()
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

    public function testUpdateQuests()
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

}
