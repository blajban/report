<?php

namespace App\Controller;

use App\CardGame\Game;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Exception;


use App\Services\UtilityService;

class GameController extends AbstractController
{
    private UtilityService $utilityService;

    public function __construct(UtilityService $utilityService)
    {
        $this->utilityService = $utilityService;
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

    #[Route("/game", name: "game", methods: ['GET'])]
    public function game(): Response
    {
        return $this->render('game_start.html.twig', [
            'title' => "Spela 21",
            'heading' => "Spela 21",
            'content' => $this->utilityService->parseMarkdown('game.md')
        ]);
    }

    #[Route("/game", name: "game_init", methods: ['POST'])]
    public function initCallback(SessionInterface $session): Response
    {
        // Handle player name

        $game = new Game($session);
        $game->shuffle();

        return $this->redirectToRoute('game/play');
    }

    #[Route("/game/draw", name: "game_draw", methods: ['POST'])]
    public function playerTakesCard(SessionInterface $session): Response
    {
        // CREATE Game object
        // CALL Game:: player draws card

        // CALL Game:: check if player is full
        // IF player is full THEN
           // RETURN redirect to end screen

        // RETURN redirect to playing field

        $game = new Game($session);

        try {
            $game->playerDraw();
        } catch (Exception $e) {
            $this->addFlash(
                'warning',
                $e->getMessage()
            );
        }


        if ($game->isFull()) {
            return $this->redirectToRoute('game/end');
        }

        return $this->redirectToRoute('game/play');
    }

    #[Route("/game/stop", name: "game_stop", methods: ['POST'])]
    public function banksTurn(SessionInterface $session): Response
    {
        $game = new Game($session);
        $game->bankDraw();

        return $this->redirectToRoute('game/end');
    }

    #[Route("/game/play", name: "game/play")]
    public function play(SessionInterface $session): Response
    {
        $game = new Game($session);

        return $this->render('game_play.html.twig', [
            'title' => "Play",
            'heading' => "Play",
            'gameState' => $game->getGameState()
        ]);
    }

    #[Route("/game/end", name: "game/end")]
    public function end(SessionInterface $session): Response
    {
        // FIX
        $game = new Game($session);

        $game->determineWinner();

        return $this->render('game_end.html.twig', [
            'title' => "Play",
            'heading' => "Play",
            'gameState' => $game->getGameState()
        ]);
    }

    #[Route("/api/game")]
    public function gameJson(SessionInterface $session): Response
    {
        $game = new Game($session);
        $gameState = $game->getGameStateJson();

        return $this->utilityService->jsonResponse($gameState);
    }


}
