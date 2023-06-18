<?php

namespace App\Proj;
use Exception;



class DoorGenerator
{
    private array $grid = [];
    private int $width = 0;
    private int $height = 0;


    public function __construct(array $roomGrid, int $width, int $height)
    {
        $this->grid = $roomGrid;
        $this->width = $width;
        $this->height = $height;
    }

    public function generateDoors()
    {
        for ($row = 0; $row < $this->height; $row++) {
            for ($col = 0; $col < $this->width; $col++) {
                $this->generateAllDoors($row, $col);
            }
        }
    }

    private function generateAllDoors($row, $col)
    {
        // TODO
    }

    public function generateRandomDoors()
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

}
