<?php

namespace App\Proj;

use App\Proj\Map;
use App\Proj\Player;
use App\Proj\Quest;
use App\Entity\Room;
use App\Entity\Item;

class AdventureGame
{
    private string $debug = 'Debug';
    private int $moves = 0;
    private Map $map;
    private Player $player;
    private QuestHandler $questHandler;
    private Quest|null $hintedQuest = null;

    /**
     * @param array<Room> $rooms
     * @param array<Item> $items
     */
    public function __construct($rooms, $items, string $playerName, int $numberOfQuests)
    {
        $this->player = new Player($playerName);

        $itemDistributor = new ItemDistributor($items);
        $itemDistributor->distributeItems($rooms);

        $this->questHandler = new QuestHandler();
        $this->questHandler->generateQuests($rooms, $items, $numberOfQuests);

        $this->map = new Map($rooms);
    }

    /**
     * @return void
     */
    public function move(string $direction)
    {
        $this->map->move($direction);
        $this->moves++;
    }

    /**
     * @return void
     */
    public function takeItem(int $itemId)
    {
        $currentRoom = $this->map->getCurrentRoom();
        $item = $currentRoom->takeItem($itemId);
        $this->player->addToInventory($item);
    }

    /**
     * @return void
     */
    public function dropItem(int $itemId)
    {
        $currentRoom = $this->map->getCurrentRoom();
        $item = $this->player->dropFromInventory($itemId);
        $currentRoom->addItem($item);
    }

    public function playerWins(): bool
    {
        return $this->questHandler->allQuestsCompleted();
    }

    /**
     * @return void
     */
    public function updateQuests()
    {
        $this->questHandler->updateQuestCompletion();
    }

    /**
     * @return void
     */
    public function showHint(int $questId)
    {
        $this->hintedQuest = $this->questHandler->showHint($questId);
    }

    /**
     * @return void
     */
    public function hideHint()
    {
        //$this->hintedRoom = null;
        //$this->hintedItem = null;
    }

    /**
     * @return array{
     *     currentRoom: Room,
     *     rooms: array<Room>,
     *     grid: Room[][],
     *     player: Player,
     *     quests: array<Quest>,
     *     hint: Quest|null,
     *     moves: int,
     *     debug: string
     * }
     */
    public function getState(): array
    {
        $this->questHandler->updateQuestCompletion();

        return [
            'currentRoom' => $this->map->getCurrentRoom(),
            'rooms' => $this->map->getRooms(),
            'grid' => $this->map->getGrid(),
            'player' => $this->player,
            'quests' => $this->questHandler->getQuests(),
            'hint' => $this->hintedQuest,
            'moves' => $this->moves,
            'debug' => $this->debug
        ];
    }

    /**
     * @return void
     */
    public function setDebugText(string $text)
    {
        $this->debug = $text;
    }


}
