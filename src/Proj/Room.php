<?php

namespace App\Proj;

/**
 * @SuppressWarnings(PHPMD.ShortVariable)
 */
class Room
{
    private int $id;
    private string $name;
    private string $description;
    private array $doors;
    private array $items;

    public function __construct($id, $name, $description) {
        $this->items = [];
        $this->id = $id;
        $this->name = $name;
        $this->description = $description;
        $this->doors = [
            'north' => null,
            'south' => null,
            'east' => null,
            'west' => null
        ];
    }

    public function addDoor($direction, $room) {
        $this->doors[$direction] = $room;
    }

    public function getDoors(): array
    {
        return $this->doors;
    }

    public function addItem($item)
    {
        $this->items[$item['id']] = $item;
    }

    public function getItems(): array
    {
        return $this->items;
    }

    public function takeItem($itemId) {
        if (array_key_exists($itemId, $this->items)) {
            $item = $this->items[$itemId];
            unset($this->items[$itemId]);
            return $item;
        }

        return null;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getDescription(): string
    {
        return $this->description;
    }
}
