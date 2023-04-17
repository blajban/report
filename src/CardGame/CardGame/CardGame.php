<?php

namespace App\CardGame\CardGame;

use App\CardGame\Deck\Deck;
use App\CardGame\DeckWithJokers\DeckWithJokers;
use App\CardGame\Player\Player;

interface CardGameInterface
{
    public function __construct($session);
    public function getDeck(): array;
    public function getJsonDeck(): array;
    public function shuffle();
    public function sortDeck();
    public function draw($number): array;
    public function remainingCards(): int;
    public function dealCards($num_players, $num_cards): array;
    public function resetPlayers(): int;
}

class CardGame implements CardGameInterface
{
    protected $deck;
    protected $session;

    public function __construct($session)
    {
        $this->session = $session;
    }

    public function getDeck(): array
    {
        $this->deck = $this->session->get("deck") ?? new DeckWithJokers();
        return $this->deck->getDeck();
    }

    public function getJsonDeck(): array
    {
        $this->deck = $this->session->get("deck") ?? new DeckWithJokers();
        $jsonDeck = [];

        foreach ($this->deck->getDeck() as $card) {
            $jsonDeck[] = $card->toArray();
        }

        return $jsonDeck;

    }

    public function shuffle()
    {
        $this->deck = new DeckWithJokers();
        $this->deck->shuffleDeck();
        $this->session->set("deck", $this->deck);
    }

    public function sortDeck()
    {
        $this->deck = $this->session->get("deck") ?? new DeckWithJokers();

        $this->deck->sortDeck();
    }

    public function draw($number): array
    {
        $this->deck = $this->session->get("deck") ?? new DeckWithJokers();
        $cardsDrawn = [];

        if ($this->deck->remainingCards() < $number) {
            $cardsDrawn = $this->session->get("cards_drawn");
            $this->session->set("deck", $this->deck);
            return $cardsDrawn;
        }

        for ($i = 0; $i < $number; $i++) {
            $cardsDrawn[] = $this->deck->drawCard();
        }

        $this->session->set("cards_drawn", $cardsDrawn);

        $this->session->set("deck", $this->deck);

        return $cardsDrawn;
    }

    public function remainingCards(): int
    {
        $this->deck = $this->session->get("deck") ?? new DeckWithJokers();
        return $this->deck->remainingCards();
    }

    public function dealCards($num_players, $num_cards): array
    {
        $this->deck = $this->session->get("deck") ?? new DeckWithJokers();

        $maxActivePlayers = $this->session->get("active_players") ?? $num_players;
        if ($num_players >= $maxActivePlayers) {
            $this->session->set("active_players", $num_players);
        }

        $activePlayers = [];

        for ($i = 1; $i <= $num_players; $i++) {
            $player = "Player $i";
            $activePlayers[] = $this->session->get($player) ?? new Player($player);
        }

        if ($this->remainingCards() < $num_players * $num_cards) {
            return [
                "success" => false,
                "activePlayers" => $activePlayers
            ];
        }

        for ($i = 0; $i < $num_cards; $i++) {
            foreach ($activePlayers as $pl) {
                $card = $this->draw(1)[0];
                $pl->addCard($card);
            }
        }

        $this->session->set("deck", $this->deck);

        foreach ($activePlayers as $pl) {
            $this->session->set($pl->getName(), $pl);
        }

        return [
            "success" => true,
            "activePlayers" => $activePlayers
        ];
    }

    public function resetPlayers(): int
    {
        $numActivePlayers = $this->session->get("active_players") ?? 0;

        for ($i = 1; $i <= $numActivePlayers; $i++) {
            $playerName = "Player $i";
            $player = $this->session->get($playerName);

            $player->discardHand();

            $this->session->set($playerName, $player);
        }

        return $numActivePlayers;
    }
}
