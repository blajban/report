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

    public function generateRandomDoors()
    {
        // 2d array to check which rooms have been visited
        $visited = [];
        for ($row = 0; $row < count($this->grid); $row++) {
            for ($col = 0; $col < count($this->grid[0]); $col++) {
                $visited[$row][$col] = false;
            }
        }

        $rowIndex = array_rand($this->grid);
        $colIndex = array_rand($this->grid[$rowIndex]);
        $this->generateRandomDoorsRecursively($rowIndex, $colIndex, $visited);
    }

    /**
     * Depth-first search algorithm. Basically starts in one room,
     * chooses a random neighbor, if the neighbor has not been visited before,
     * create doors and then keep going from that room. When it reaches a room
     * with no unvisited neighbors, it goes back in the chain until it encounters
     * an unvisited neighbor, and keeps going from there to make sure all rooms
     * are accessible.
     */
    private function generateRandomDoorsRecursively($row, $col, &$visited)
    {
        $visited[$row][$col] = true;
        $currentRoom = $this->grid[$row][$col];

        $neighbors = $this->getUnvisitedNeighbors($visited, $row, $col);
        
        // Shuffle to take a random path
        shuffle($neighbors);

        // If neighbor not visited, create doors and keep going from that room
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

            // Check that the row/col is valid and doesnt go outside the grid
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
