# Krav 1, 2, 3: Webbplats

Din nya webbplats skall minst uppfylla följande krav.

## Innehåll och utseende

[OK] Skapa en landningssida /proj som syns i navbaren på din report-sida. Denna sida är din förstasida på projektets webbplats.
[OK] Välj ditt fokus för ditt projekt. Implementera det i din webbplats under proj/.
* Ditt projekt skall ha en stil och ett utseende som tydligt skiljer sig från din report-sida.
    * Det skall utseendemässigt se ut som en ny webbplats så bygg en “ny” stylesheet eller modifiera din befintliga. Modifiera i någon omfattning färg, typsnitt och utseende på header och footer.
    * Skapa en separat navbar för projektet som enbart innehåller länkarna för projektet.
    En sida /proj/about som ger en kort introduktion till ditt projekt och vad det handlar om.

## Repo och dokumentation

* Ditt git repo skall ha en README.md.
    * Det skall finnas badges som är klickbara och leder till uppdaterade Scrutinizer rapporter för build, coverage och quality.
    * Beskriv innehållet av repot och berätta varför det finns. som beskriver innehållet i någon omfattning.
    * Instruktion för hur man klonar och startar igång webbplatsen

* Innehållet i docs/ skall vara uppdaterat
    * Kodtäckning sikta på över 90% kodtäckning (exkludera filer som inte är relevanta).
    * Generera dokumentation med phpdoc.
    * Generera metrics med phpmetrics.

## Spelet

* spelidé 
* Databas för administration av spelet (lägga till rum, objekt etc)? Se spelstatus? Ska man kunna spela igenom det via json också?
* Quests, random slutpunkt
* Fusklapp
* Planera med flödesdiagram/dokument/er-diagram

# Krav 4: JSON API (optionellt)

* Skapa ett JSON API till dit projekt och presentera det i sidan proj/api.

* Skapa minst 5 olika JSON routes varav minst en skall vara en POST route.

* I sidan skall man kunna klicka på samtliga länkar/knappar för att testa ditt API.

# Krav 5: ORM (optionellt)

* Din webbplats skall använda databas via ORM.

* Din databas måste innehålla minst två tabeller.

* Skapa en sida proj/about/database, och lägg till
    * En bild på ett ER diagram av tabellerna.
    * För varje tabell beskriv i en mening vad som sparas i tabellen.
    * Förklara hur du löste eventuella relationer mellan tabellerna.
    * Berätta om du använde SQLite eller någon annan databas.
    * Berätta om du gjorde enhetstester mot databasen.
        * Berätta om/hur du lyckades med enhetstester på Scrutinizer med databasen.

    * Berätta med egna ord (cirka 15 meningar) om hur du ser på fördelar, nackdelar, likheter och skillnader mellan ORM och det sätt vi jobbade med databasen i databaskursen.

    * Från din sida proj/about, lägg till en länk till proj/about/database.

# Krav 6: Avancerade features (optionellt)

Förutsatt att du har uppfyllt krav 4 och krav 5 så kan du även uppfylla krav 6 genom att själv beskriva och lyfta fram 3-5 features/saker som du anser har varit extra svåra och utmanade att lösa i ditt projekt.

Kanske är det saker som är tidskrävande eller så är det saker som varit utmanande att lösa rent tankemässigt.

Det handlar alltså om att beskriva de saker som du gjort förutom baskraven. Du väljer själv vilka delar du anser värda att ta upp.

Välj saker som tydligt kan betraktas att vara utanför ramen för baskraven och för varje sak du lyfter fram så skriver du ett kort textstycke om varför du anser att detta bör räknas in i detta sista optionella krav.

Rättaren gör en bedömning, baserad på din text, om din insats är värd 0, 5 eller 10 poäng. Rättaren väger troligen ockå in det allmänna tillståndet på din lösning och kan eventuellt väga in den bedömda svårighetsnivån.

# Redovisning

Avsluta och redovisa din projektinlämning enligt följande.

* Testa ditt projekt med dbwebb test kmom10. Se till att alla delar passerar grönt.

* Tagga som v10.0.0, pusha till GitHub/Lab.

* Driftsätt din applikation på studentservern. Dubbelkolla att alla delar fungerar, inklusive nollställningen av databasen.

* På din me/report sida, skriv följande:

    * För varje krav du implementerat, dvs 1-3, 4, 5, 6, skriver du ett textstycke om ca 5-10 meningar där du beskriver hur du löste kravet. Poängsättningen tar sin start i din text så se till att skriva väl för att undvika poängavdrag. Missar du att skriva/dokumentera din lösning så blir det 0 poäng. Du kan inte komplettera en inlämning för att få högre betyg.

    * Skriv ett allmänt stycke om hur projektet gick att genomföra. Problem/lösningar/strul/enkelt/svårt/snabbt/lång tid, etc. Var projektet lätt eller svårt? Tog det lång tid? Vad var svårt och vad gick lätt? Var det ett bra och rimligt projekt för denna kursen?

    * Avsluta med ett sista stycke med dina tankar om kursen och vad du anser om materialet och handledningen (ca 5-10 meningar). Ge feedback till lärarna och förslå eventuella förbättringsförslag till kommande kurstillfällen. Är du nöjd/missnöjd? Kommer du att rekommendera kursen till dina vänner/kollegor? På en skala 1-10, vilket betyg ger du kursen?

* Ta en kopia av texten på din redovisningssida och kopiera in den på Canvas. Glöm inte att bifoga länken till projektet på studentservern.

* Spela in en redovisningsvideo för projektet och lägg länken till videon i en kommentar på din inlämning i Canvas. Detta kan du göra dagen efter projektets deadline. Läs mer om hur du kan spela in en redovisningsvideo.


# Tankar/redovisning/idéer/todo

* Promptar:
- A room for a classix pixel art point and click adventure game. Set in the victorian era with three exits and one window
- A room for a classix pixel art point and click adventure game. Set in a futuristic era in a control room setting with screens and one exit

* Tog hjälp av ChatGPT för att få en bra spelidé. Efter lite diskussioner landade vi i följande:

**Title:** "Echoes of Tomorrow"

**Genre:** Time-Travel Interactive Adventure Game

**Setting:** The game is set in a mysterious mansion known as the Chronos Mansion, which has many rooms. Each room is a portal to a different era, ranging from the prehistoric age to the distant future. 

**Story:** You play as a novice historian who stumbles upon this Chronos Mansion. You discover that the mansion has been affected by a Temporal Rift, causing each room to be connected with a different time period. The mansion and its inhabitants are in danger because of this rift and the anomalies it has caused.

Your task is to correct these anomalies by interacting with the environment and the objects in each room, and restore the mansion's rooms to their rightful state.

**Gameplay:** 

The game mechanics would focus on point-and-click exploration and puzzle-solving in the style of classic adventure games. Each room represents a different era and has items, environmental features, and clues that belong to that era. You need to pick up and use these items in the correct manner to resolve the anomalies and "fix" the room.

For instance, in the 'Medieval Room', you might find a futuristic device that doesn't belong. You'll have to find the right place (or time) for this item and return it to its rightful era, which could involve using it in a different room.

Puzzles could involve decoding messages, finding hidden objects, creating certain item combinations, or even interacting with characters who've ended up in the wrong time!

**Graphics:**

The rooms of the mansion would be still images with clickable areas. A 2D art style with attention to detail would serve this format well. Each room could have a unique color palette and art style to reflect its mood and characteristics.

**Player Engagement:**

As players progress, they can unlock more rooms in the mansion and uncover the deeper story of the Chronos Mansion. There could be a grand puzzle that threads through all the eras/rooms which players slowly piece together.

This adjusted idea should be more in line with your requirements! Let me know if you need any more help or if there's anything you'd like to change.


## Grunden

Äventyrsspel.

Spelloopen:
1. Presentera rum med [exits]
2. Presentera [items] i rummet
3. Gör ett val:
    * Gå i en riktning
    * Plocka upp en item 

[GÖR ETT FLÖDESDIAGRAM]
[GÖR ETT ER-DIAGRAM]


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
* GameState??

## Att spara i databasen

* Room
    * Name
    * Description
    * Era
* Items
    * Name
    * Description
* GameState
    * ID
    * GameState 

## Quests
Om tid finns
Annars är målet att hitta utgången.
Olika typer av quests:
    * "move [thing] to [room]
    * "find [room]
    * 