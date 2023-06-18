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

use App\Repository\BookRepository;
use App\Repository\RoomInfoRepository;
use App\Services\UtilityService;

const ITEMS = [
    [
        'id' => '1',
        'name' => 'Ett item',
        'description' => 'Det här är ett item'
    ],
    [
        'id' => '2',
        'name' => 'Ett annat item',
        'description' => 'Det här är ett annat item'
    ],
    [
        'id' => '3',
        'name' => 'Ett tredje item',
        'description' => 'Det här är tredje ett item'
    ]
];

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
    public function gamePicture(int $id, RoomInfoRepository $roomInfoRepo): Response
    {
        $roomInfo = $roomInfoRepo->find($id);

        if (!$roomInfo || !$roomInfo->getImg()) {
            throw new Exception('No room picture found for id ' . $id);
        }

        return $this->utilityService->imageResponse($roomInfo->getImg());
    }

    #[Route("/proj", name: "proj", methods: ['GET'])]
    public function landing(SessionInterface $session, RoomInfoRepository $roomInfoRepo): Response
    {
        $roomInfos = $roomInfoRepo->findAll();
        $game = new AdventureGame($roomInfos, ITEMS);
        
        $session->set('proj_session', $game);

        return $this->redirectToRoute('proj/play');
    }

    #[Route("/proj/play", name: "proj/play", methods: ['GET'])]
    public function play(SessionInterface $session, RoomInfoRepository $roomInfoRepo): Response
    {
        $game = $session->get('proj_session');

        if (!$game) {
            $roomInfos = $roomInfoRepo->findAll();
            $game = new AdventureGame($roomInfos, ITEMS);
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

        $game->updateQuests();

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

        $session->set('proj_session', $game);

        return $this->redirectToRoute('proj/play');
    }

    
    
}
