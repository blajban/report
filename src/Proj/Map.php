<?php

namespace App\Proj;

use App\Entity\Room;
use Exception;




class Map
{
    private array $rooms = [];
    private array $grid = [];
    private Room $activeRoom;
    private int $width = 0;
    private int $height = 0;

    public function __construct(array $rooms)
    {
        $this->rooms = $rooms;
        $this->setWidthAndHeight();
        $this->generateGrid();
        $doorGenerator = new DoorGenerator($this->grid, $this->width, $this->height);
        $doorGenerator->generateRandomDoors();
        $this->setStartingRoom();
    }



    private function setWidthAndHeight()
    {
        $numRooms = count($this->rooms);
        $this->width = floor(sqrt($numRooms));
        $this->height = ceil($numRooms / $this->width);
    }

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

    private function setStartingRoom()
    {
        $row = random_int(0, count($this->grid) - 1);
        $col = random_int(0, count($this->grid[$row]) - 1);
        $this->activeRoom = $this->grid[$row][$col];
    }

    public function getCurrentRoom(): Room
    {
        return $this->activeRoom;
    }

    public function move($direction)
    {
        $doors = $this->activeRoom->getDoors();
        $nextRoom = $doors[$direction];
        $this->activeRoom = $nextRoom;
    }

    public function getRooms(): array
    {
        return $this->rooms;
    }

    public function getGrid(): array
    {
        return $this->grid;
    }

}
