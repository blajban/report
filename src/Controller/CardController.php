<?php

namespace App\Controller;

use App\CardGame\Deck\Deck;
use App\CardGame\DeckWithJokers\DeckWithJokers;
use App\CardGame\CardGame\CardGame;
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
        $deck = $session->get("deck") ?? new Deck();
        $maxActivePlayers = $session->get("active_players") ?? $players;
        if ($players >= $maxActivePlayers) {
            $session->set("active_players", $players);
        }
        $activePlayers = [];

        for ($i = 1; $i <= $players; $i++) {
            $player = "Player $i";
            $activePlayers[] = $session->get($player) ?? new Player($player);
        }

        if ($deck->remainingCards() > $players * $cards) {
            for ($i = 0; $i < $cards; $i++) {
                foreach ($activePlayers as $pl) {
                    $pl->addCard($deck->drawCard());
                }
            }
        } else {
            $this->addFlash(
                'warning',
                'Not enough cards left in deck'
            );
        }

        $session->set("deck", $deck);

        foreach ($activePlayers as $pl) {
            $session->set($pl->getName(), $pl);
        }

        return $this->render('table.html.twig', [
            'title' => "Deal",
            'remaining_cards' => $deck->remainingCards(),
            'players' => $activePlayers
        ]);
    }

    #[Route("/card/deck/deal/reset")]
    public function resetPlayers(SessionInterface $session)
    {
        $numActivePlayers = $session->get("active_players") ?? 0;


        for ($i = 1; $i <= $numActivePlayers; $i++) {
            $playerName = "Player $i";
            $player = $session->get($playerName);

            $player->discardHand();

            $session->set($playerName, $player);
        }

        return $this->render('1col_nohero.html.twig', [
            'title' => "Reset players",
            'heading' => "Reset players",
            'content' => "$numActivePlayers players resetted"
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
