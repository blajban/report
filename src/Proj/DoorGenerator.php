<?php

namespace App\Proj;

use App\Entity\Room;
use Exception;

class DoorGenerator
{
    /**
     * @var Room[][]
     */
    private array $grid = [];

    /**
     * @param Room[][] $roomGrid
     */
    public function __construct(array $roomGrid)
    {
        $this->grid = $roomGrid;
    }

    private function generateRandomDoorsRecursively($row, $col, &$visited)
    {
        $visited[$row][$col] = true;
        $currentRoom = $this->grid[$row][$col];

        $neighbors = $this->getUnvisitedNeighbors($visited, $row, $col);
        shuffle($neighbors);

        foreach ($neighbors as $neighbor) {
            $nextRow = $neighbor['row'];
            $nextCol = $neighbor['col'];
            $nextRoom = $neighbor['room'];

            if (!$visited[$nextRow][$nextCol]) {
                $this->createDoors($currentRoom, $nextRow - $row, $nextCol - $col, $nextRoom);
                $this->generateRandomDoorsRecursively($nextRow, $nextCol, $visited);
            }
        }
    }

    private function getUnvisitedNeighbors($visited, $row, $col): array
    {
        $neighbors = [];
        $directions = [
            'north' => [-1, 0],
            'south' => [1, 0],
            'west' => [0, -1],
            'east' => [0, 1]
        ];

        foreach ($directions as $direction => $offset) {
            $newRow = $row + $offset[0];
            $newCol = $col + $offset[1];
            if (isset($this->grid[$newRow][$newCol]) && !$visited[$newRow][$newCol]) {
                $neighbors[] = [
                    'room' => $this->grid[$newRow][$newCol],
                    'row' => $newRow,
                    'col' => $newCol
                ];
            }
        }

        return $neighbors;
    }


    public function generateRandomDoors()
    {
        $visited = array_fill(0, count($this->grid), array_fill(0, count($this->grid[0]), false));
        $rowIndex = array_rand($this->grid);
        $colIndex = array_rand($this->grid[$rowIndex]);
        $this->generateRandomDoorsRecursively($rowIndex, $colIndex, $visited);
    }

    private function createDoors($currentRoom, $rowOffset, $colOffset, $nextRoom)
    {
        $directions = [
            'north' => [-1, 0],
            'south' => [1, 0],
            'west' => [0, -1],
            'east' => [0, 1]
        ];

        $oppositeDirections = [
            'north' => 'south',
            'south' => 'north',
            'west' => 'east',
            'east' => 'west'
        ];

        foreach ($directions as $direction => $offset) {
            if ($offset[0] == $rowOffset && $offset[1] == $colOffset) {
                $currentRoom->addDoor($direction, $nextRoom);
                $nextRoom->addDoor($oppositeDirections[$direction], $currentRoom);
                break;
            }
        }
    }
}
