<?php

namespace App\Controller;

use App\CardGame\CardGame\CardGame;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\SessionInterface;


use App\Services\UtilityService;

class CardController extends AbstractController
{
    private $utilityService;

    public function __construct(UtilityService $utilityService)
    {
        $this->utilityService = $utilityService;
    }

    #[Route("/card", name: "card")]
    public function card(): Response
    {
        return $this->render('1col_nohero.html.twig', [
            'title' => "Card",
            'heading' => "Card",
            'content' => $this->utilityService->parseMarkdown('card.md')
        ]);
    }

    #[Route("/api", name: "api")]
    public function api(): Response
    {
        return $this->render('1col_nohero.html.twig', [
            'title' => "API",
            'heading' => "API",
            'content' => $this->utilityService->parseMarkdown('api.md')
        ]);
    }


    #[Route("/card/deck")]
    public function deck(SessionInterface $session): Response
    {
        $cardGame = new CardGame($session);

        $cardGame->sortDeck();

        return $this->render('card.html.twig', [
            'title' => "Deck",
            'displayed_deck' => $cardGame->getDeck()
        ]);
    }

    #[Route("/card/deck/shuffle")]
    public function shuffle(SessionInterface $session): Response
    {
        $cardGame = new CardGame($session);
        $cardGame->shuffle();

        return $this->render('card.html.twig', [
            'title' => "Shuffle",
            'displayed_deck' => $cardGame->getDeck()
        ]);
    }

    #[Route("/card/deck/draw")]
    public function draw(SessionInterface $session): Response
    {
        $cardGame = new CardGame($session);
        $cardsDrawn = $cardGame->draw(1);

        if ($cardGame->remainingCards() < 1) {
            $this->addFlash(
                'warning',
                'Trying to draw more cards than left in deck!'
            );
        }

        return $this->render('card.html.twig', [
            'title' => "Draw",
            'deck' => $cardGame->getDeck(),
            'drawn_card' => $cardsDrawn[0],
            'remaining_cards' => $cardGame->remainingCards()
        ]);
    }

    #[Route("/card/deck/draw/{number}")]
    public function drawMany($number, SessionInterface $session): Response
    {
        $cardGame = new CardGame($session);
        $cardsDrawn = $cardGame->draw($number);

        if ($cardGame->remainingCards() < $number) {
            $this->addFlash(
                'warning',
                'Trying to draw more cards than left in deck!'
            );
        }

        return $this->render('card.html.twig', [
            'title' => "Draw many",
            'deck' => $cardGame->getDeck(),
            'drawn_cards' => $cardsDrawn,
            'remaining_cards' => $cardGame->remainingCards()
        ]);
    }

    #[Route("/card/deck/deal/{players}/{cards}")]
    public function dealCards($players, $cards, SessionInterface $session): Response
    {
        $cardGame = new CardGame($session);

        $deal = $cardGame->dealCards($players, $cards);

        if (!$deal["success"]) {
            $this->addFlash(
                'warning',
                'Not enough cards left in deck'
            );
        }

        return $this->render('table.html.twig', [
            'title' => "Deal",
            'remaining_cards' => $cardGame->remainingCards(),
            'players' => $deal["activePlayers"]
        ]);
    }

    #[Route("/card/deck/deal/reset")]
    public function resetPlayers(SessionInterface $session)
    {
        $cardGame = new CardGame($session);

        $numResetted = $cardGame->resetPlayers();

        return $this->render('1col_nohero.html.twig', [
            'title' => "Reset players",
            'heading' => "Reset players",
            'content' => "$numResetted players resetted"
        ]);
    }

    /**
     * @Route("/card/deck2")
     */
    /*public function deck2(): Response
    {
        $deck = new DeckWithJokers(2);

        return $this->render('card.html.twig', [
            'title' => "Deck 2",
            'displayed_deck' => $deck->getDeck()
        ]);
    }*/

}
