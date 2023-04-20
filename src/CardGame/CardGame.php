<?php

namespace App\CardGame;

use App\CardGame\DeckWithJokers;
use App\CardGame\Player;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

interface CardGameInterface
{
    /**
     * @return void
     */
    public function __construct(SessionInterface $session);

    /**
     * @return array<Card>
     */
    public function getDeck(): array;

    /**
     * @return array<Mixed>
     */
    public function getJsonDeck(): array;

    /**
     * @return void
     */
    public function shuffle();

    /**
     * @return void
     */
    public function sortDeck();

    /**
     * @return array<Card>
     */
    public function draw(int $number): array;

    public function remainingCards(): int;

    /**
     * @return array<Mixed>
     */
    public function dealCards(int $num_players, int $num_cards): array;
    public function resetPlayers(): int;
}

class CardGame implements CardGameInterface
{
    /**
     * @var DeckWithJokers $deck
     */
    protected $deck;

    /**
     * @var SessionInterface $session
     */
    protected $session;

    public function __construct(SessionInterface $session)
    {
        $this->session = $session;
        $this->deck = $this->getDeckFromSession();
    }

    private function getDeckFromSession(): DeckWithJokers
    {
        $deckFromSession = $this->session->get("deck");
        if ($deckFromSession === null) {
            return new DeckWithJokers();
        }
        
        assert($deckFromSession instanceof DeckWithJokers);
        return $deckFromSession;
    }

    public function getDeck(): array
    {
        return $this->deck->getDeck();
    }

    public function getJsonDeck(): array
    {
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
        $this->deck->sortDeck();
    }

    public function draw(int $number): array
    {
        $cardsDrawn = [];

        if ($this->deck->remainingCards() < $number) {
            $cardsDrawn = $this->session->get("cards_drawn");
            assert(is_array($cardsDrawn));
            foreach ($cardsDrawn as $card) {
                assert($card instanceof Card);
            }
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
        return $this->deck->remainingCards();
    }

    public function dealCards(int $num_players, int $num_cards): array
    {
        class_exists(Player::class);

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
