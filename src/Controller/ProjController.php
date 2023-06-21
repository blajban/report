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


use App\Repository\ItemRepository;
use App\Repository\RoomRepository;
use App\Services\UtilityService;

/**
 * @SuppressWarnings(PHPMD.ShortVariable)
 */
class ProjController extends AbstractController
{
    private UtilityService $utilityService;

    public function __construct(UtilityService $utilityService)
    {
        $this->utilityService = $utilityService;
    }

    #[Route('/game_picture/{id}', name: 'game_picture')]
    public function gamePicture(int $id, RoomRepository $roomRepo): Response
    {
        $room = $roomRepo->find($id);

        if (!$room || !$room->getImg()) {
            throw new Exception('No room picture found for id ' . $id);
        }

        return $this->utilityService->imageResponse($room->getImg());
    }

    #[Route("/proj", name: "proj", methods: ['GET'])]
    public function landing(): Response
    {
        return $this->render('proj/proj_start.html.twig', [
            'title' => "Proj",
            'heading' => "Proj"
        ]);
    }

    #[Route('/proj/play/start', name: 'proj/play_start_callback', methods: ['POST'])]
    public function start(SessionInterface $session, Request $request, RoomRepository $roomRepo, ItemRepository $itemRepo): Response
    {
        $name = 'Player';
        $numberOfQuests = 3;

        if ($request->request->has('name')) {
            $name = $request->request->get('name');
        }

        if ($request->request->has('numberOfQuests')) {
            $numberOfQuests = $request->request->get('numberOfQuests');
        }

        $rooms = $roomRepo->findAll();
        $items = $itemRepo->findAll();
        $game = new AdventureGame($rooms, $items, $name, $numberOfQuests);
        
        $session->set('proj_session', $game);

        return $this->redirectToRoute('proj/play');
    }

    #[Route("/proj/play", name: "proj/play", methods: ['GET'])]
    public function play(SessionInterface $session): Response
    {
        $game = $session->get('proj_session');

        if (!$game) {
            return $this->redirectToRoute('proj');
        }

        $session->set('proj_session', $game);

        return $this->render('proj/proj_play.html.twig', [
            'title' => "Proj",
            'heading' => "Proj",
            'gameState' => $game->getState()
        ]);
    }

    #[Route('/proj/play/move', name: 'proj/play_move_callback', methods: ['POST'])]
    public function move(SessionInterface $session, Request $request): Response
    {
        $game = $session->get('proj_session');

        if ($request->request->has('move')) {
            $direction = $request->request->get('move');
            $game->move($direction);
        }

        $session->set('proj_session', $game);

        return $this->redirectToRoute('proj/play');
    }

    #[Route('/proj/play/takeItem', name: 'proj/play_takeItem_callback', methods: ['POST'])]
    public function takeItem(SessionInterface $session, Request $request): Response
    {
        $game = $session->get('proj_session');

        if ($request->request->has('takeItem')) {
            $itemId = $request->request->get('takeItem');
            $game->takeItem($itemId);
        }


        $session->set('proj_session', $game);

        return $this->redirectToRoute('proj/play');
    }

    #[Route('/proj/play/dropItem', name: 'proj/play_dropItem_callback', methods: ['POST'])]
    public function dropItem(SessionInterface $session, Request $request): Response
    {
        $game = $session->get('proj_session');

        if ($request->request->has('dropItem')) {
            $itemId = $request->request->get('dropItem');
            $game->dropItem($itemId);
        }

        $game->updateQuests();

        if ($game->playerWins()) {
            return $this->redirectToRoute('proj/play/end');
        }

        $session->set('proj_session', $game);

        return $this->redirectToRoute('proj/play');
    }

    #[Route('/proj/play/showHint', name: 'proj/play_showHint_callback', methods: ['POST'])]
    public function showHint(SessionInterface $session, Request $request): Response
    {
        $game = $session->get('proj_session');

        if ($request->request->has('showHint')) {
            $questId = $request->request->get('showHint');
            $game->showHint($questId);
        }

        $session->set('proj_session', $game);

        return $this->redirectToRoute('proj/play');
    }

    #[Route("/proj/play/end", name: "proj/play/end", methods: ['GET'])]
    public function end(SessionInterface $session): Response
    {
        $game = $session->get('proj_session');

        if (!$game) {
            return $this->redirectToRoute('proj');
        }

        if (!$game->playerWins()) {
            return $this->redirectToRoute('proj/play');
        }

        $session->set('proj_session', $game);
        return $this->render('proj/proj_end.html.twig', [
            'title' => "Proj",
            'heading' => "Proj",
            'gameState' => $game->getState()
        ]);
    }

    #[Route("/proj/play/reset", name: "proj/play/reset", methods: ['GET'])]
    public function reset(SessionInterface $session): Response
    {
        if ($session->has('proj_session')) {
            $session->remove('proj_session');
        }

        return $this->redirectToRoute('proj');
    }
    
    
}
