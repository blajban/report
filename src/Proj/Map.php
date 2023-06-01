<?php

namespace App\Proj;
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
        $this->generateDoors();
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

    private function generateDoors()
    {
        for ($row = 0; $row < $this->height; $row++) {
            for ($col = 0; $col < $this->width; $col++) {
                $this->generateWestDoor($row, $col);
                $this->generateEastDoor($row, $col);
                $this->generateNorthDoor($row, $col);
                $this->generateSouthDoor($row, $col);
                $this->generateExtraDoors($row, $col);
            }
        }

        $this->checkAccessibility();
    }

    private function generateWestDoor($row, $col)
    {
        try {
            $current = $this->grid[$row][$col];
            $west = $this->grid[$row][$col - 1];
            if ($west->getDoors()['east']) {
                $current->addDoor('west', $west);
            }
        } catch (Exception $e) {
            return;
        }
    }

    private function generateEastDoor($row, $col)
    {
        try {
            $current = $this->grid[$row][$col];
            $east = $this->grid[$row][$col + 1];
            if (random_int(0, 1) > 0) {
                $current->addDoor('east', $east);
            }
        } catch (Exception $e) {
            return;
        }
    }

    private function generateNorthDoor($row, $col)
    {
        try {
            $current = $this->grid[$row][$col];
            $north = $this->grid[$row - 1][$col];
            if ($north->getDoors()['south']) {
                $current->addDoor('north', $north);
            }
        } catch (Exception $e) {
            return;
        }
    }

    private function generateSouthDoor($row, $col)
    {
        try {
            $current = $this->grid[$row][$col];
            $south = $this->grid[$row + 1][$col];
            if (random_int(0, 1) > 0) {
                $current->addDoor('south', $south);
            }
        } catch (Exception $e) {
            return;
        }
    }
    private function generateExtraDoors($row, $col)
    {
        try {
            $current = $this->grid[$row][$col];
            $doors = $current->getDoors();
            $doorCount = 0;
            foreach ($doors as $door) {
                if ($door) {
                    $doorCount++;
                }
            }
            if ($doorCount < 2) {
                if (!$doors['south']) {
                    $south = $this->grid[$row + 1][$col];
                    $current->addDoor('south', $south);
                }
                if (!$doors['east']) {
                    $east = $this->grid[$row][$col + 1];
                    $current->addDoor('east', $east);
                }
            }
        } catch (Exception $e) {
            return;
        }
    }

    private function checkAccessibility()
    {

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
