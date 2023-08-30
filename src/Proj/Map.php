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

    /**
     * @param array<Room> $rooms
     */
    public function __construct(array $rooms)
    {
        $this->rooms = $rooms;
        $this->setWidthAndHeight();
        $this->generateGrid();
        $doorGenerator = new DoorGenerator($this->grid);
        $doorGenerator->generateRandomDoors();
        $this->setStartingRoom();
    }

    private function setWidthAndHeight(): void
    {
        $numRooms = count($this->rooms);

        $this->width = (int) ceil(sqrt($numRooms));
    }

    private function generateGrid(): void
    {
        $shuffledRooms = $this->rooms;
        shuffle($shuffledRooms);

        $col = 0;
        $row = 0;
        foreach ($shuffledRooms as $room) {
            $this->grid[$row][$col] = $room;
            $col++;

            if ($col >= $this->width) {
                $row++;
                $col = 0;
            }
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
        if ($nextRoom) {
            $this->activeRoom = $nextRoom;
        }
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
