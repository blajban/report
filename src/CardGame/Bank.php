<?php

namespace App\CardGame;

use App\CardGame\CardHandInterface;
use App\CardGame\CardHandTrait;


class Bank implements CardHandInterface
{
    use CardHandTrait;

    public function willContinue($score)
    {
        if ($score < 18) {
            return true;
        }

        return false;
    }


}
