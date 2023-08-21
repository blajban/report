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

    public function generateRandomDoors(): void
    {
        // 2d array to check which rooms have been visited
        $visited = [];
        $rowCount = count($this->grid);
        $colCount = count($this->grid[0]);

        for ($row = 0; $row < $rowCount; $row++) {
            for ($col = 0; $col < $colCount; $col++) {
                $visited[$row][$col] = false;
            }
        }

        $rowIndex = (int) array_rand($this->grid);
        $colIndex = (int) array_rand($this->grid[$rowIndex]);
        $this->generateRandomDoorsRecursively($rowIndex, $colIndex, $visited);
    }

    /**
     * Depth-first search algorithm. Basically starts in one room,
     * chooses a random neighbor, if the neighbor has not been visited before,
     * create doors and then keep going from that room. When it reaches a room
     * with no unvisited neighbors, it goes back in the chain until it encounters
     * an unvisited neighbor, and keeps going from there to make sure all rooms
     * are accessible.
     * 
     * @param array<array<bool>> $visited
     */
    private function generateRandomDoorsRecursively(int $row, int $col, &$visited): void
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

    /**
     * @param array<array<bool>> $visited
     * @return array<int, array{room: Room, row: int, col: int}>
     */
    private function getUnvisitedNeighbors(array $visited, int $row, int $col): array
    {
        $neighbors = [];
        $directions = [
            'north' => [-1, 0],
            'south' => [1, 0],
            'west' => [0, -1],
            'east' => [0, 1]
        ];

        foreach ($directions as $offset) {
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

    private function createDoors(Room $currentRoom, int $rowOffset, int $colOffset, Room $nextRoom): void
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
