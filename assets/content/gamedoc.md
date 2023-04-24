[Problemlösningsdokumentation]

### Flödesschema

![Övergripande](../img/21overview.png)

Ett övergripande flödesschema ur användarens perspektiv.

Nedan följer detaljering av flödesschemat ur ett kodperspektiv.

![Start](../img/21start.png)

![Player](../img/21player.png)

![Bank](../img/21bank.png)

![End](../img/21end.png)


### Pseudokod från och med Player's turn -> User presses take card button -> POST route

Användaren har tryckt på knappen för att ta ett nytt kort. Här skapas ett Game-objekt och ett kort dras. Beroende på om spelaren är tjock redirectas spelaren sedan till spelplanen för att få möjlighet att ta ett nytt kort, alternativt till slutskärmen.

```
#[Route("/game/play/takecard", name: "player_takes_card", methods: ['POST'])]
public function playerTakesCard(SessionInterface $session): Response
    {
        CREATE Game object
        CALL Game:: player draws card
        CALL Game:: check if player is full

        IF player is full THEN
            RETURN redirect to playing field
        
        RETURN redirect to end screen
    }
```

#### Game-klassen
Game-klassen ska innehålla hela spelet inklusive sessionshantering. Tanken är att Game-klassen innehåller en spelare, en bank, och en lek. Tanken är också att hela spelets state finns i en gameState-array som enkelt kan göras om till json. Nedan fortsätter vi följa vad som händer i funktionsanropen från flödet ovan.

#### CALL Game:: player draws card

```
public function playerDraw()
{
    IF remaining cards of deck < 1 THEN
        THROW error not enough cards
    
    CALL Deck:: draw card
    CALL Player:: add card to hand
    SET gameState[player][score] = CALL calculate points with player hand
    CALL set game state session
}
```

Tanken är att en getGameStateSession och en setGameState-session hela tiden hämtat från sessionen och uppdaterar state-arrayen med aktuell ställning.

```
private function getGameStateSession()
{
    IF deck session THEN
        SET deck
    ELSE
        CREATE deck

    SET gameState[remaingcards] = CALL Deck:: remaining cards

    IF player session THEN
        SET player
    ELSE
        CREATE player
    
    SET gameState[player][hand] = CALL PLayer:: get hand

    IF player score session THEN
        SET gameState[player][score] = playerScore from session

    IF bank session THEN
        SET bank
    ELSE
        CREATE bank

    SET gameState[bank][hand] = CALL Bank:: get hand

    IF bank score session THEN
        SET gameState[bank][score] = bankScore from session
}
```

```
private function setGameStateSession()
{
    SET deck session
    SET player session
    SET player score session
    SET bank session
    SET bank score session
}
```

Calculate points-metoden räknar helt enkelt ut poängen:

```
private function calculatePoints(hand)
{

}
```

#### CALL Game:: check if player is full
Tanken är att kontrollern kollar om någon är tjock och redirectar beroende på resultatet.

```
public function isFull()
{
    IF gameState[player][score] >= 21 THEN
        RETURN true
    
    IF gamestate[bank][score] >= 21 THEN
        RETURN true
    
    RETURN false
}
```


[Beskrivning av klasserna med namn och mening med klassens syfte]



private function updateGameState()
{
    $this->deck = $this->session->get(Game::DECK_SESSIONNAME) ?? new Deck();
    $this->gameState['remaining_cards'] = $this->deck->remainingCards();

    $playerName = $this->session->get(Game::PLAYERNAME_SESSIONNAME) ?? "Player";
    $this->player = $this->session->get(Game::PLAYER_SESSIONNAME) ?? new Player($playerName);
    $this->gameState['player']['hand'] = $this->player->getHand();
}

public function shuffle()
{
    $this->deck = new Deck();
    $this->deck->shuffleDeck();
    $this->session->set(Game::DECK_SESSIONNAME, $this->deck);
    $this->updateGameState();
}

public function calculatePoints($hand)
{

}

public function isFull()
{
    
}



public function bankDraw()
{

}

public function bankContinue()
{
    
}

public function determineWinner()
{
    
}

public function reset()
{

}

[Ev rita UML-diagram]