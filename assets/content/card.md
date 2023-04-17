
[card/deck](/card/deck)

[card/deck/shuffle (use this to reset deck)](/card/deck/shuffle)

[card/deck/draw](/card/deck/draw)

[card/deck/draw/:number (3 cards)](/card/deck/draw/3)

[card/deck/deal/:players/:cards (3 players, 3 cards)](/card/deck/deal/3/3)

[card/deck/deal/reset (reset all player hands in session)](/card/deck/deal/reset)

### Om klasserna

![UML-diagram](img/uml-card.png)

Grunden är klassen `Card` som implementerar ett `FrenchEnglishCardInterface` och ett `JokerInterface`. Det gör det enkelt att exempelvis skapa andra typer av kort eller utelämna jokern.

Korten används sedan i leken. Här har jag en `Deck`-klass som implementerar ett `DeckInterface`. Man kan alltså använda deck-interfacet för många olika lekar, men i just den här implementationen använder jag Card-klassen enligt tidigare. Snyggt och prydligt tycker jag. 

För att få in arvet enligt kraven så har jag helt enkelt en `DeckWithJokets` som ärver från Deck och som lägger till jokrar i leken. Det är denna lek jag sedan använder i kontrollerna.

För att göra kontrollerna små och för att kunna återanvända kod mellan webb-kontrollen och json-kontrollen har jag också en `CardGame`-klass som implementerar ett `CardGameInterface`. Här hanterar jag session och all logik för att få ingångarna att fungera.

I CarcGame använder jag också `Player`-klassen som implementerar ett `CardHandInterface` och använder ett `CardHandTrait`. Tanken är att all logik som har med korthanden att göra är separerad från koden som har med spelaren att göra. Delen som hanterar spelaren kan utvecklas framöver, just nu är det bara spelarens namn. När man sneglar på nästa kursmoment så tänker jag att även en `Bank`-klass skulle kunna implementera CardHandInterface och använda CardHandTrait.


