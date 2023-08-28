<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

const ITEM_INFO = [
    [
        "name" => "Vintage Pocket Watch",
        "description" => "An antique timepiece with intricate engravings."
    ],
    [
        "name" => "Faded Diary",
        "description" => "A weathered diary filled with mysterious entries."
    ],
    [
        "name" => "Creaky Key",
        "description" => "A rusted key with an eerie design, emitting a faint glow."
    ],
    [
        "name" => "Enchanted Hourglass",
        "description" => "A mystical hourglass that seems to defy the laws of time."
    ]
]

class ItemFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        // $product = new Product();
        // $manager->persist($product);

        $manager->flush();
    }
}
