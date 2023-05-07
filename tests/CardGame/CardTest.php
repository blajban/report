<?php

namespace App\CardGame;

use PHPUnit\Framework\TestCase;

/**
 * Test cases for class Card.
 * @SuppressWarnings(PHPMD.TooManyPublicMethods)
 */
class CardTest extends TestCase
{
    /**
     * Verify construct object no joker.
     * @return void
     */
    public function testConstructObjectNoJoker()
    {
        $value = 3;
        $color = 1;
        $card = new Card($value, $color);
        $this->assertInstanceOf("\App\CardGame\Card", $card);

        $res = $card->getValue();
        $exp = $value;
        $this->assertEquals($exp, $res);

        $res = $card->getCssColor();
        $exp = 'hearts';
        $this->assertEquals($exp, $res);

        $res = $card->isJoker();
        $this->assertFalse($res);
    }

    /**
     * Verify construct object as joker.
     * @return void
     */
    public function testConstructObjectJoker()
    {
        $value = 3;
        $color = 1;
        $card = new Card($value, $color, true);

        $res = $card->isJoker();
        $this->assertTrue($res);
    }

    /**
     * Verify asString method (no joker, no ace).
     * @return void
     */
    public function testAsStringNoJokerNoAce()
    {
        $value = 3;
        $color = 1;
        $colorName = 'Hjärter';
        $cardName = 'Tre';

        $card = new Card($value, $color);

        $res = $card->asString();
        $exp = "{$colorName} {$cardName} ({$value} poäng)";

        $this->assertEquals($exp, $res);
    }

    /**
     * Verify asString method (ace).
     * @return void
     */
    public function testAsStringAce()
    {
        $value = 14;
        $otherValue = 1;
        $color = 1;
        $colorName = 'Hjärter';
        $cardName = 'Ess';

        $card = new Card($value, $color);

        $res = $card->asString();
        $exp = "{$colorName} {$cardName} ({$value}/{$otherValue} poäng)";

        $this->assertEquals($exp, $res);
    }

    /**
     * Verify asString method (joker).
     * @return void
     */
    public function testAsStringJoker()
    {
        $value = 3;
        $color = 1;
        $colorName = 'Joker';
        $cardName = 'Tre';

        $card = new Card($value, $color, true);

        $res = $card->asString();
        $exp = "{$colorName} {$cardName} ({$value} poäng)";

        $this->assertEquals($exp, $res);
    }

    /**
     * Verify isJoker method.
     * @return void
     */
    public function testIsJoker()
    {
        $value = 3;
        $color = 1;

        $card = new Card($value, $color, true);

        $res = $card->isJoker();
        $this->assertTrue($res);

        $card = new Card($value, $color);
        $res = $card->isJoker();
        $this->assertFalse($res);
    }

    /**
     * Verify that value of joker can be changed.
     * @return void
     */
    public function testchangeJokerColorAndValue()
    {
        $value = 3;
        $color = 1;

        $card = new Card($value, $color, true);

        $card->changeJokerColorAndValue(2, 5);

        $res = $card->getValue();
        $exp = 5;
        $this->assertEquals($exp, $res);

    }


    /**
     * Verify isAce and changeAceValue method.
     * @return void
     */
    public function testIsAceAndChangeAceValue()
    {
        $color = 1;
        $value = 1;

        $card = new Card($value, $color);

        $res = $card->isAce();
        $this->assertTrue($res);

        $card->changeAceValue();
        $res = $card->getValue();
        $exp = 14;
        $this->assertEquals($exp, $res);

        $res = $card->isAce();
        $this->assertTrue($res);

        $card->changeAceValue();
        $res = $card->getValue();
        $exp = 1;
        $this->assertEquals($exp, $res);

        $value = 10;
        $card = new Card($value, $color);

        $card->changeAceValue();
        $res = $card->getValue();
        $exp = 10;
        $this->assertEquals($exp, $res);
    }

    /**
     * Verify that getValue returns current card value.
     * @return void
     */
    public function testGetValue()
    {
        $color = 1;
        $value = 5;

        $card = new Card($value, $color);

        $res = $card->getValue();
        $exp = $value;
        $this->assertEquals($exp, $res);
        ;
    }

    /**
     * Verify that getCsscolor returns correct card color (no joker).
     * @return void
     */
    public function testGetCssColorNoJoker()
    {
        $color = 1;
        $value = 5;

        $card = new Card($value, $color);

        $res = $card->getCssColor();
        $exp = 'hearts';
        $this->assertEquals($exp, $res);
        ;
    }

    /**
     * Verify that getCsscolor returns correct card color (joker).
     * @return void
     */
    public function testGetCssColorJoker()
    {
        $color = 1;
        $value = 5;

        $card = new Card($value, $color, true);

        $res = $card->getCssColor();
        $exp = 'joker';
        $this->assertEquals($exp, $res);
        ;
    }

    /**
     * Verify that card information is returned as an array with toArray method.
     * @return void
     */
    public function testToArray()
    {
        $color = 1;
        $value = 5;

        $card = new Card($value, $color);

        $res = $card->toArray();

        $exp = [
            'value' => $value,
            'color' => 'Hjärter',
            'name' => 'Fem',
            'isAce' => false,
            'isJoker' => false
        ];

        $this->assertEquals($exp, $res);
        ;
    }

}
