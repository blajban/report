<?php

namespace App\Controller;

use App\CardGame\CardGame;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\SessionInterface;


use App\Services\UtilityService;

class GameController extends AbstractController
{
    private UtilityService $utilityService;

    public function __construct(UtilityService $utilityService)
    {
        $this->utilityService = $utilityService;
    }

    #[Route("/game", name: "game")]
    public function game(): Response
    {
        return $this->render('1col_nohero.html.twig', [
            'title' => "Game",
            'heading' => "Game",
            'content' => $this->utilityService->parseMarkdown('game.md')
        ]);
    }

    #[Route("/game/doc", name: "game/doc")]
    public function gameDocs(): Response
    {
        return $this->render('1col_nohero.html.twig', [
            'title' => "Dokumentation",
            'heading' => "Dokumentation",
            'content' => $this->utilityService->parseMarkdown('gamedoc.md')
        ]);
    }

}
