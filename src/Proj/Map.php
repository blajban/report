<?php

namespace App\Proj;

use App\Entity\Room;
use App\Entity\Item;
use Exception;

class Map
{
    /**
     * @var array<Room> $rooms
     */
    private array $rooms = [];

    /**
     * @var Room[][]
     */
    private array $grid = [];
    private Room $activeRoom;
    private int $width = 0;
    private int $height = 0;

    /**
     * @param array<Room> $rooms
     */
    public function __construct(array $rooms)
    {
        $this->rooms = $rooms;
        $this->setWidthAndHeight();
        $this->generateGrid();
        $doorGenerator = new DoorGenerator($this->grid, $this->width, $this->height);
        $doorGenerator->generateRandomDoors();
        $this->setStartingRoom();
    }

    /**
     * @return void
     */
    private function setWidthAndHeight()
    {
        $numRooms = count($this->rooms);
        $this->width = (int) floor(sqrt($numRooms));
        $this->height = (int) ceil($numRooms / $this->width);
    }

    /**
     * @return void
     */
    private function generateGrid()
    {
        $col = 0;
        $row = 0;
        foreach ($this->rooms as $room) {
            if ($col >= $this->width) {
                $row++;
                $col = 0;
                continue;
            }

            $this->grid[$row][] = $room;
            $col++;
        }
    }

    /**
     * @return void
     */
    private function setStartingRoom()
    {
        /** @phpstan-ignore-next-line */
        $row = random_int(0, count($this->grid) - 1);
        /** @phpstan-ignore-next-line */
        $col = random_int(0, count($this->grid[$row]) - 1);
        $this->activeRoom = $this->grid[$row][$col];
    }

    public function getCurrentRoom(): Room
    {
        return $this->activeRoom;
    }

    /**
     * @return void
     */
    public function move(string $direction)
    {
        $doors = $this->activeRoom->getDoors();
        $nextRoom = $doors[$direction];
        $this->activeRoom = $nextRoom;
    }

    /**
     * @return array<Room>
     */
    public function getRooms(): array
    {
        return $this->rooms;
    }

    /**
     * @return Room[][]
     */
    public function getGrid(): array
    {
        return $this->grid;
    }
}
