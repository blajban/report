<?php

namespace App\CardGame;

use App\CardGame\DeckWithJokers;
use App\CardGame\Player;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

use App\CardGame\CardGameInterface;
use App\CardGame\CardGameTrait;

class CardGame implements CardGameInterface
{
    use CardGameTrait;

    private SessionInterface $session;

    public function __construct(SessionInterface $session)
    {
        $this->session = $session;

        /** @phpstan-ignore-next-line */
        $this->deck = $this->session->get("deck") ?? new DeckWithJokers();
    }

    /**
     * @return void
     */
    public function shuffle()
    {
        $this->deck = new DeckWithJokers();
        $this->deck->shuffleDeck();
        $this->session->set("deck", $this->deck);
    }

    /**
     * @return void
     */
    public function sortDeck()
    {
        $this->deck->sortDeck();
    }

    /**
     * @return array<Card>
     */
    public function draw(int $number): array
    {
        /** @var Card[] $cardsDrawn */
        $cardsDrawn = [];

        if ($this->deck->remainingCards() < $number) {
            /** @var Card[] $cardsDrawn */
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

    /**
     * @return array<Player> $activePlayers
     */
    private function getActivePlayers(int $numPlayers): array
    {
        $maxActivePlayers = $this->session->get("active_players") ?? $numPlayers;
        if ($numPlayers >= $maxActivePlayers) {
            $this->session->set("active_players", $numPlayers);
        }

        /**
         * @var array<Player> $activePlayers
         */
        $activePlayers = [];

        for ($i = 1; $i <= $numPlayers; $i++) {
            $player = "Player $i";
            $activePlayers[] = $this->session->get($player) ?? new Player($player);
        }

        return $activePlayers;
    }

    /**
     * @return array<Mixed>
     */
    public function dealCards(int $numPlayers, int $numCards): array
    {
        class_exists(Player::class);

        $activePlayers = $this->getActivePlayers($numPlayers);

        if ($this->remainingCards() < $numPlayers * $numCards) {
            return [
                "success" => false,
                "activePlayers" => $activePlayers
            ];
        }

        for ($i = 0; $i < $numCards; $i++) {
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
        /** @var int $numActivePlayers */
        $numActivePlayers = $this->session->get("active_players") ?? 0;

        for ($i = 1; $i <= $numActivePlayers; $i++) {
            $playerName = "Player $i";

            /** @var Player $player */
            $player = $this->session->get($playerName);

            $player->discardHand();

            $this->session->set($playerName, $player);
        }

        return $numActivePlayers;
    }
}
