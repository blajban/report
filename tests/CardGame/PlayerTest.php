<?php

namespace App\CardGame;

use PHPUnit\Framework\TestCase;

/**
 * Test cases for class Bank.
 */
class PlayerTest extends TestCase
{
    /**
     * Verify that object is created with correct name.
     * @return void
     */
    public function testConstructPlayer()
    {
        $player = new Player("Test");
        $this->assertInstanceOf("\App\CardGame\Player", $player);

        $res = $player->getName();
        $exp = "Test";
        $this->assertEquals($exp, $res);
    }

}
