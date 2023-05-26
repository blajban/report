<?php

namespace App\Controller;

use App\CardGame\Game;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Exception;
use Symfony\Component\HttpFoundation\Request;


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
    public function initCallback(SessionInterface $session, Request $request): Response
    {
        /**
         * @var string $playerName
         */
        $playerName = $session->get('game_playerName') ?? '';


        if ($request->request->has('playerName')) {
            /** @var string $playerName */
            $playerName = $request->request->get('playerName');
            $session->set('game_playerName', $playerName);
        }

        $game = new Game($playerName);
        $game->shuffle();
        $session->set('game_session', $game);


        return $this->redirectToRoute('game/play');
    }

    #[Route("/game/draw", name: "game_draw", methods: ['POST'])]
    public function playerTakesCard(SessionInterface $session): Response
    {
        /**
         * @var Game $game
         */
        $game = $session->get('game_session');

        try {
            $game->playerDraw();
        } catch (Exception $e) {
            $session->set('game_session', $game);
            return $this->redirectToRoute('game/play');
        }


        if ($game->isFull()) {
            $session->set('game_session', $game);
            return $this->redirectToRoute('game/end');
        }

        $session->set('game_session', $game);
        return $this->redirectToRoute('game/play');
    }

    #[Route("/game/stop", name: "game_stop", methods: ['POST'])]
    public function banksTurn(SessionInterface $session): Response
    {
        /**
         * @var Game $game
         */
        $game = $session->get('game_session');

        try {
            $game->bankDraw();
        } catch (Exception $e) {
            $session->set('game_session', $game);
            $this->addFlash(
                'warning',
                $e->getMessage()
            );
        }

        $session->set('game_session', $game);
        return $this->redirectToRoute('game/end');
    }

    #[Route("/game/play", name: "game/play")]
    public function play(SessionInterface $session): Response
    {
        /**
         * @var Game $game
         */
        $game = $session->get('game_session');
        $session->set('game_session', $game);

        return $this->render('game_play.html.twig', [
            'title' => "Play",
            'heading' => "Play",
            'gameState' => $game->getGameState()
        ]);
    }

    #[Route("/game/end", name: "game/end")]
    public function end(SessionInterface $session): Response
    {
        /**
         * @var Game $game
         */
        $game = $session->get('game_session');

        $game->determineWinner();

        $gameState = $game->getGameState();
        $endHeading = 'Tyvärr, banken vann';

        if ($gameState['winner'] == 'player') {
            $endHeading = 'Grattis, du vann!';
            if ($gameState['bank']['score'] > 21) {
                $endHeading = 'Banken fick över 21, du vann!';
            }
        }

        if ($gameState['winner'] == 'bank') {
            if ($gameState['player']['score'] > 21) {
                $endHeading = 'Du fick över 21, banken vann';
            }
        }

        $session->set('game_session', $game);
        return $this->render('game_end.html.twig', [
            'title' => "End",
            'heading' => $endHeading,
            'gameState' => $gameState
        ]);
    }

    #[Route("/api/game")]
    public function gameJson(SessionInterface $session): Response
    {
        /**
         * @var Game $game
         */
        $game = $session->get('game_session');
        $gameState = $game->getGameStateJson();

        return $this->utilityService->jsonResponse($gameState);
    }


}
