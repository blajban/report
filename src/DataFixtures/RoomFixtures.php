<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Room;
use App\Services\UtilityService;

const ROOM_INFO = [
    [
        "name" => "Quantum Laboratory",
        "description" => "You step into a sprawling quantum laboratory where shimmering energy fields surround advanced scientific equipment. Holographic displays flicker with complex equations, while scientists in futuristic attire work diligently on cutting-edge experiments that bend the very fabric of reality.",
        "path" => "/assets/content/proj-assets/1_quantum_lab.png"
    ],
    [
        "name" => "The Enigmatic Study",
        "description" => "Step into the grandeur of The Enigmatic Study, a room that embodies the opulence of Victorian elegance. Adorned with rich mahogany bookshelves that reach from floor to ceiling, this sanctuary of knowledge houses a vast collection of leather-bound tomes, their spines embellished with intricate golden lettering.",
        "path" => "/assets/content/proj-assets/2_enigmatic_study.png"
    ],
    [
        "name" => "Time Chamber",
        "description" => "You venture into a chamber bathed in a soft ethereal glow, pulsating with temporal energies. Mysterious devices hum with power, each meticulously calibrated to manipulate the flow of time. In this room, clocks tick in perfect unison, and ancient hourglasses hold the secrets of past and future.",
        "path" => "/assets/content/proj-assets/3_time_chamber.png"
    ],
    [
        "name" => "Memory Archive",
        "description" => "You enter a chamber adorned with rows of luminescent memory pods, each encapsulating fragments of bygone eras. As you traverse the room, holographic projections spring to life, forming vivid images and capturing the essence of distant memories. It's a sanctuary where the past intertwines with the present.",
        "path" => "/assets/content/proj-assets/4_memory_archive.png"
    ],
    [
        "name" => "Astral Observatory",
        "description" => "You ascend to an observatory nestled high above, where a colossal telescope reaches toward the vast expanse of the cosmos. Here, holographic projections showcase distant galaxies and celestial wonders. As you gaze through the glass, you witness the beauty of unseen worlds and the mysteries that lie beyond.",
        "path" => "/assets/content/proj-assets/5_astral_observatory.png"
    ],
    [
        "name" => "Temporal Garden",
        "description" => "You step into a verdant sanctuary alive with vibrant flora from across the temporal spectrum. Luminous petals bloom with hues that shift and change, echoing the passing of time. The fragrant air carries whispers of ancient wisdom, and the tranquil atmosphere invites contemplation and introspection.",
        "path" => "/assets/content/proj-assets/6_temporal_garden.png"
    ],
    [
        "name" => "Techno-Arcade",
        "description" => "You immerse yourself in a pulsating techno-arcade, where neon lights flicker and energetic music fills the air. Futuristic gaming consoles and virtual reality stations beckon you to explore captivating digital realms. Amongst the electrifying ambiance, skilled players engage in thrilling competitions of skill and strategy.",
        "path" => "/assets/content/proj-assets/7_techno_arcade.png"
    ],
    [
        "name" => "Cybernetics Lab",
        "description" => "You enter a sleek cybernetics lab where scientists in lab coats and augmented individuals collaborate on the cutting edge of human-machine integration. Advanced robotic arms dance with precision, while computer terminals hum with streams of data. The air crackles with anticipation as the boundaries between flesh and technology blur.",
        "path" => "/assets/content/proj-assets/8_cybernetics_lab.png"
    ],
    [
        "name"=> "Echo Chamber",
        "description" => "You step into an enigmatic echo chamber, its walls adorned with intricate sound amplification devices. Within this space, whispers from ages past linger, echoing through time. The air is charged with an otherworldly energy as the chamber's soundwaves intertwine, revealing cryptic messages and long-forgotten secrets.",
        "path" => "/assets/content/proj-assets/9_echo_chamber.png"
    ],
    [
        "name" => "Dimensional Gallery",
        "description" => "You wander through a captivating dimensional gallery, where masterful paintings and captivating sculptures transport you to parallel realities. Each artwork portrays vistas and beings from realms beyond imagination. As you explore, you feel the veil between dimensions thinning, offering glimpses into the infinite possibilities of existence.",
        "path" => "/assets/content/proj-assets/10_dimensional_gallery.png"
    ],
    [
        "name" => "Timeless Ballroom",
        "description" => "You step into a resplendent ballroom frozen in an eternal moment. Crystal chandeliers cast a warm glow upon the opulent decor, as ghostly echoes of waltzing couples resonate through the air. The faded elegance of this timeless space evokes a sense of nostalgia, where memories of grand celebrations and hidden stories intertwine.",
        "path" => "/assets/content/proj-assets/11_timeless_ballroom.png"
    ]
];

class RoomFixtures extends Fixture
{
    private UtilityService $utilityService;

    public function __construct(UtilityService $utilityService)
    {
        $this->utilityService = $utilityService;
    }

    public function load(ObjectManager $manager): void
    {
        foreach (ROOM_INFO as $roomInfo) {
            $room = new Room();
            $room->setName($roomInfo['name']);
            $room->setDescription($roomInfo['description']);

            $img = $this->utilityService->generatePictureDataFromFile($roomInfo['path']);
            $room->setImg($img);

            $manager->persist($room);
        }

        $manager->flush();
    }
}
