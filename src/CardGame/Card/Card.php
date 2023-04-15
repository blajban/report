<?php

namespace App\CardGame\Card;


interface FrenchEnglishCardInterface
{
    const HEARTS = 1;
    const SPADES = 2;
    const CLUBS = 3;
    const TILES = 4;
    const JOKER = 5;

    const CARDNAMES = [
        0 => 'Joker',
        1 => 'Ess',
        2 => 'Två',
        3 => 'Tre',
        4 => 'Fyra',
        5 => 'Fem',
        6 => 'Sex',
        7 => 'Sju',
        8 => 'Åtta',
        9 => 'Nio',
        10 => 'Tio',
        11 => 'Knekt',
        12 => 'Dam',
        13 => 'Kung',
        14 => 'Ess'
    ];
    const COLORNAMES = [
        1 => "Hjärter",
        2 => "Spader",
        3 => "Klöver",
        4 => "Ruter",
        5 => "Joker"
    ];
    const CSSCOLORS = [
        1 => "hearts",
        2 => "spades",
        3 => "clubs",
        4 => "tiles",
        5 => "joker"
    ];

    public function __construct(int $value, int $colorEnum);
    public function asString(): string;
    public function isAce(): bool;
    public function changeAceValue();
    public function getValue(): int;
    public function getCssColor(): string;
}

interface JokerInterface
{
    public function __construct(int $value, int $colorEnum, $isJoker = false);
    public function isJoker(): bool;
    public function changeJokerColorAndValue(int $color, int $value);
}


class Card implements FrenchEnglishCardInterface, JokerInterface
{
    private $value;
    private $color;
    private $joker;

    public function __construct(int $value, int $colorEnum, $isJoker = false)
    {
        $this->value = $value;
        $this->color = $colorEnum;
        $this->joker = $isJoker;
    }

    public function asString(): string
    {
        
        if ($this->isJoker()) {
            $color = Card::COLORNAMES[Card::JOKER];
            $name = Card::CARDNAMES[Card::JOKER];
            return "{$color} {$name} ({$this->value} poäng)";
        }

        $color = Card::COLORNAMES[$this->color];
        $name = Card::CARDNAMES[$this->value];

        if ($this->isAce()) {
            $otherValue = 14;
            if ($this->value === $otherValue) {
                $otherValue = 1;
            }
            return "{$color} {$name} ({$this->value}/{$otherValue} poäng)";
        }

        return "{$color} {$name} ({$this->value} poäng)";
    }

    public function isAce(): bool
    {
        switch ($this->value) {
            case 1: return true; break;
            case 14: return true; break;
            default: return false; break;
        }
    }

    public function isJoker(): bool
    {
        return $this->joker;
    }

    public function changeJokerColorAndValue(int $color, int $value)
    {
        if ($this->isJoker()) {
            $this->color = $color;
            $this->value = $value;
        }
    }

    public function changeAceValue()
    {
        switch ($this->value) {
            case 1: $this->value = 14; break;
            case 14: $this->value = 1; break;
            default: break;
        }
    }

    public function getValue(): int
    {
        return $this->value;
    }

    public function getCssColor(): string {
        if ($this->isJoker()) {
            return Card::CSSCOLORS[Card::JOKER];
        }
        return Card::CSSCOLORS[$this->color];
    }
}
