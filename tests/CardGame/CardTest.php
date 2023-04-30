<?php

namespace App\CardGame;

use PHPUnit\Framework\TestCase;

/**
 * Test cases for class Card.
 */
class CardTest extends TestCase
{
    /**
     * Verify construct object no joker.
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
     */
    public function testConstructObjectJoker()
    {
        $value = 3;
        $color = 1;
        $card = new Card($value, $color, true);

        $res = $card->isJoker();
        $this->assertTrue($res);
    }

}
