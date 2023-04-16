<?php

namespace App\Controller;

use App\CardGame\Deck\Deck;
use App\CardGame\DeckWithJokers\DeckWithJokers;
use App\CardGame\Player\Player;
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

    
    #[Route("/card/deck")]
    public function deck(): Response
    {
        $deck = new Deck();

        return $this->render('card.html.twig', [
            'title' => "Deck",
            'displayed_deck' => $deck->getDeck()
        ]);
    }

    #[Route("/card/deck/shuffle")]
    public function shuffle(SessionInterface $session): Response
    {
        $deck = new Deck();

        $deck->shuffleDeck();
        
        $session->set("deck", $deck);
        

        return $this->render('card.html.twig', [
            'title' => "Shuffle",
            'displayed_deck' => $deck->getDeck()
        ]);
    }

    #[Route("/card/deck/draw")]
    public function draw(SessionInterface $session): Response
    {
        $deck = $session->get("deck") ?? new Deck();

        if ($deck->isEmpty()) {
            $this->addFlash(
                'warning',
                'Can\'t draw from an empty deck!'
            );

            $cardDrawn = $session->get("last_card");
        } else {
            $cardDrawn = $deck->drawCard();
            $session->set("last_card", $cardDrawn);
        }
        
        $session->set("deck", $deck);

        return $this->render('card.html.twig', [
            'title' => "Draw",
            'deck' => $deck->getDeck(),
            'drawn_card' => $cardDrawn,
            'remaining_cards' => $deck->remainingCards()
        ]);
    }

    #[Route("/card/deck/draw/{number}")]
    public function drawMany($number, SessionInterface $session): Response
    {
        $deck = $session->get("deck") ?? new Deck();

        $cardsDrawn = [];

        if ($deck->remainingCards() < $number) {
            $this->addFlash(
                'warning',
                'Trying to draw more cards than left in deck!'
            );

            $cardsDrawn = $session->get("cards_drawn");
        } else {
            for ($i = 0; $i < $number; $i++) {
                $cardsDrawn[] = $deck->drawCard();
            }
            $session->set("cards_drawn", $cardsDrawn);
        }
        
        $session->set("deck", $deck);

        return $this->render('card.html.twig', [
            'title' => "Draw many",
            'deck' => $deck->getDeck(),
            'drawn_cards' => $cardsDrawn,
            'remaining_cards' => $deck->remainingCards()
        ]);
    }

    /**
     * @Route("/card/deck/deal/{players}/{cards}")
     */
    /*public function dealCards($players, $cards, SessionInterface $session): Response
    {
        $deck = $session->get("deck") ?? new Deck();
        $activePlayers = [];

        for ($i = 1; $i <= $players; $i++) {
            $activePlayers[] = new Player("Player $i");
        }

        if ($deck->remainingCards() > $players * $cards) {
            for ($i = 0; $i < $cards; $i++) {
                foreach ($activePlayers as $pl) {
                    $pl->addCard($deck->drawCard());
                }
            }
        }

        $session->set("deck", $deck);

        return $this->render('table.html.twig', [
            'title' => "Deal",
            'remaining_cards' => $deck->remainingCards(),
            'players' => $activePlayers
        ]);
    }*/

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
