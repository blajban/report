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

    #[Route("/proj/test", name: "proj/test")]
    public function test(): Response
    {
        $game = new AdventureGame();
        return $this->render('proj/proj_test.html.twig', [
            'title' => "Proj",
            'heading' => "Proj",
            'gameState' => $game->getState(),
            'rooms' => $game->getMap()->getRooms(),
            'grid' => $game->getMap()->getGrid()
        ]);
    }

    #[Route("/proj", name: "proj", methods: ['GET'])]
    public function landing(SessionInterface $session): Response
    {
        $game = new AdventureGame();
        
        $session->set('proj_session', $game);

        return $this->redirectToRoute('proj/play');
    }

    #[Route("/proj/play", name: "proj/play", methods: ['GET'])]
    public function play(SessionInterface $session): Response
    {
        //$game = new AdventureGame();
        $game = $session->get('proj_session');

        $session->set('proj_session', $game);
        return $this->render('proj/proj_play.html.twig', [
            'title' => "Proj",
            'heading' => "Proj",
            'gameState' => $game->getState(),
            'rooms' => $game->getMap()->getRooms(),
            'grid' => $game->getMap()->getGrid()
        ]);
    }

    #[Route('/proj/play', name: 'proj/play_move_callback', methods: ['POST'])]
    public function move(SessionInterface $session, Request $request): Response
    {
        $game = $session->get('proj_session');

        $session->set('proj_session', $game);
        if ($request->request->has('move')) {
            $direction = $request->request->get('move');
        }
        return $this->redirectToRoute('proj/play');
    }

}
