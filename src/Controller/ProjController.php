<?php

namespace App\Controller;

use App\Proj\AdventureGame;
use App\Proj\Map;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Exception;
use Symfony\Component\HttpFoundation\Request;


use App\Services\UtilityService;

class ProjController extends AbstractController
{
    private UtilityService $utilityService;

    public function __construct(UtilityService $utilityService)
    {
        $this->utilityService = $utilityService;
    }

    #[Route("/proj", name: "proj")]
    public function landing(): Response
    {
        $game = new AdventureGame();
        return $this->render('proj/proj_start.html.twig', [
            'title' => "Proj",
            'heading' => "Proj",
            'gameState' => $game->getState(),
            'rooms' => $game->getMap()->getRooms(),
            'grid' => $game->getMap()->getGrid()
        ]);
    }

}
