## Grunden

Äventyrsspel

* Quests, random slutpunkt, dynamisk "fusklapp"
* Databas:
    * Kartor/rum
    * (Spara spel)
    * Items
* JSON-api (spelstatus, lägga till karta/rum, lägga till items, ?, ?)


## Arkitektur/entiteter

* Game
* Map
    * Room
* Player
* Inventory
    * Item
* QuestSystem
    * Quest

## Att spara i databasen

* Room
    * Name
    * Description
    * Era
* Items
    * Name
    * Description


## Quests
Om tid finns
Annars är målet att hitta utgången.
Olika typer av quests:
    * "move [thing] to [room]
    * "find [room]
    * 