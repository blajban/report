<?php

namespace App\CardGame;

use PHPUnit\Framework\TestCase;

/**
 * Test cases for class Bank.
 */
class BankTest extends TestCase
{
    /**
     * Verify willContinue method returns false when score is high.
     * @return void
     */
    public function testWillContinueHighScore()
    {
        $bank = new Bank();
        $this->assertInstanceOf("\App\CardGame\Bank", $bank);

        $score = 18;
        $res = $bank->willContinue($score);

        $this->assertFalse($res);
    }

    /**
     * Verify willContinue method returns true when score is low.
     * @return void
     */
    public function testWillContinueLowScore()
    {
        $bank = new Bank();

        $score = 17;
        $res = $bank->willContinue($score);

        $this->assertTrue($res);
    }

}
