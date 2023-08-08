<?php

namespace App\Entity;

use App\Proj\RoomTrait;
use App\Repository\RoomRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

/**
 * @SuppressWarnings(PHPMD.ShortVariable)
 */
#[ORM\Entity(repositoryClass: RoomRepository::class)]
class Room
{
    use RoomTrait;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(length: 1000)]
    private ?string $description = null;

    #[ORM\Column(type: Types::BLOB)]
    private $img = null; /** @phpstan-ignore-line */

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    /** @phpstan-ignore-next-line */
    public function getImg()
    {
        return $this->img;
    }

    /** @phpstan-ignore-next-line */
    public function setImg($img): self
    {
        $this->img = $img;

        return $this;
    }
}
