<?php

namespace App\Controller;

use App\CardGame\CardGame\CardGame;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

use App\Services\UtilityService;

class CardControllerJson extends AbstractController
{
    private $utilityService;

    public function __construct(UtilityService $utilityService)
    {
        $this->utilityService = $utilityService;
    }

    #[Route("/api/deck")]
    public function deck(SessionInterface $session): Response
    {
        $cardGame = new CardGame($session);

        $cardGame->sortDeck();

        $deck = $cardGame->getJsonDeck();

        return $this->utilityService->jsonResponse($deck);
    }

    #[Route("/api/deck/shuffle", methods: ['POST'])]
    public function shuffle(SessionInterface $session): Response
    {
        $cardGame = new CardGame($session);
        $cardGame->shuffle();

        $deck = $cardGame->getJsonDeck();

        return $this->utilityService->jsonResponse($deck);
    }

    #[Route("/api/deck/draw", methods: ['POST'])]
    public function draw(SessionInterface $session): Response
    {
        $cardGame = new CardGame($session);
        $cardsDrawn = $cardGame->draw(1);

        $status = "Success";

        if ($cardGame->remainingCards() < 1) {
            $status = "Failed - not enough cards left";
        }

        $data = [
            'status' => $status,
            'last_drawn_card' => $cardsDrawn[0]->toArray(),
            'remaining_cards' => $cardGame->remainingCards()
        ];

        return $this->utilityService->jsonResponse($data);

    }

    #[Route("/api/deck/draw/{number}", methods: ['POST'])]
    public function drawMany($number, SessionInterface $session): Response
    {
        $cardGame = new CardGame($session);
        $cardsDrawn = $cardGame->draw($number);

        $status = "Success";

        if ($cardGame->remainingCards() < $number) {
            $status = "Failed - not enough cards left";
        }

        $data = [
            'status' => $status,
            'drawn_cards' => [],
            'remaining_cards' => $cardGame->remainingCards()
        ];

        foreach ($cardsDrawn as $card) {
            $data['drawn_cards'][] = $card->toArray();
        }

        return $this->utilityService->jsonResponse($data);

    }

    #[Route("/api/deck/deal/{players}/{cards}", methods: ['POST'])]
    public function dealCards($players, $cards, SessionInterface $session): Response
    {
        $cardGame = new CardGame($session);

        $deal = $cardGame->dealCards($players, $cards);

        $status = "Success";

        if (!$deal["success"]) {
            $status = "Failed - not enough cards left";
        }

        $data = [
            'status' => $status,
            'players' => [],
            'remaining_cards' => $cardGame->remainingCards()
        ];

        foreach ($deal['activePlayers'] as $player) {
            foreach ($player->getHand() as $card) {
                $data['players'][$player->getName()][] = $card->toArray();
            }
        }

        return $this->utilityService->jsonResponse($data);
    }

    #[Route("/api/deck/deal/reset", methods: ['POST'])]
    public function resetPlayers(SessionInterface $session)
    {
        $cardGame = new CardGame($session);

        $numResetted = $cardGame->resetPlayers();

        return $this->utilityService->jsonResponse("$numResetted players resetted");

    }

}
