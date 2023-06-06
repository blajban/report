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

Certainly! Here are 10 rooms designed to fit the "Echoes of Tomorrow" and "Chronos Mansion" game idea, each with a name, short description, and a suggestion for a picture:

1. Quantum Laboratory
   - Description: A futuristic laboratory with advanced scientific equipment and holographic displays.
   - Picture: Picture of a high-tech laboratory with scientists working on futuristic gadgets.

2. Time Chamber
   - Description: A room filled with mysterious devices that manipulate time, with clocks and hourglasses scattered around.
   - Picture: Picture of a chamber with intricate timepieces and swirling time vortexes.

3. Memory Archive
   - Description: A room with rows of memory pods, where fragments of past events are stored as holographic projections.
   - Picture: Picture of a room with glowing memory pods and floating holographic memories.

4. Astral Observatory
   - Description: A celestial observatory with a giant telescope and holographic projections of distant galaxies.
   - Picture: Picture of an observatory with a telescope pointing towards the stars and vivid cosmic visuals.

5. Temporal Garden
   - Description: A lush garden with exotic plants, some of which bloom with flowers that change colors over time.
   - Picture: Picture of a vibrant garden with unique flora and fauna, emitting a futuristic glow.

6. Techno-Arcade
   - Description: An arcade room filled with futuristic gaming consoles, virtual reality stations, and neon lights.
   - Picture: Picture of an arcade room with players immersed in virtual reality games and futuristic game cabinets.

7. Cybernetics Lab
   - Description: A laboratory dedicated to cybernetic enhancements, with robotic arms, computer terminals, and bionic prototypes.
   - Picture: Picture of a lab with scientists working on cybernetic technologies and advanced robotic limbs.

8. Echo Chamber
   - Description: A room with sound amplification technology that echoes past conversations and whispers cryptic messages.
   - Picture: Picture of a chamber with intricate sound equipment and soundwaves reverberating in the air.

9. Dimensional Gallery
   - Description: An art gallery showcasing paintings and sculptures that depict different dimensions and alternate realities.
   - Picture: Picture of an art gallery with mind-bending artwork and visitors mesmerized by the displays.

10. Timeless Ballroom
    - Description: A grand ballroom frozen in time, with elegant chandeliers, opulent decorations, and ghostly echoes of waltzing couples.
    - Picture: Picture of a magnificent ballroom with ornate architecture and a spectral dance floor.

Feel free to adapt and modify these room ideas to fit your vision for the "Echoes of Tomorrow" and "Chronos Mansion" game. Customize the descriptions, add more details, and find suitable pictures to enhance the immersive experience of your adventure game!


Certainly! Here are the 10 rooms with more immersive descriptions for the "Echoes of Tomorrow" and "Chronos Mansion" game:

{
    "name": "Quantum Laboratory",
    "description": "You step into a sprawling quantum laboratory where shimmering energy fields surround advanced scientific equipment. Holographic displays flicker with complex equations, while scientists in futuristic attire work diligently on cutting-edge experiments that bend the very fabric of reality."
}

{
    "name": "The Enigmatic Study",
    "description": "Step into the grandeur of The Enigmatic Study, a room that embodies the opulence of Victorian elegance. Adorned with rich mahogany bookshelves that reach from floor to ceiling, this sanctuary of knowledge houses a vast collection of leather-bound tomes, their spines embellished with intricate golden lettering."
}

{
    "name": "Time Chamber",
    "description": "You venture into a chamber bathed in a soft ethereal glow, pulsating with temporal energies. Mysterious devices hum with power, each meticulously calibrated to manipulate the flow of time. In this room, clocks tick in perfect unison, and ancient hourglasses hold the secrets of past and future."
}

{
    "name": "Memory Archive",
    "description": "You enter a chamber adorned with rows of luminescent memory pods, each encapsulating fragments of bygone eras. As you traverse the room, holographic projections spring to life, forming vivid images and capturing the essence of distant memories. It's a sanctuary where the past intertwines with the present."
}

{
    "name": "Astral Observatory",
    "description": "You ascend to an observatory nestled high above, where a colossal telescope reaches toward the vast expanse of the cosmos. Here, holographic projections showcase distant galaxies and celestial wonders. As you gaze through the glass, you witness the beauty of unseen worlds and the mysteries that lie beyond."
}

{
    "name": "Temporal Garden",
    "description": "You step into a verdant sanctuary alive with vibrant flora from across the temporal spectrum. Luminous petals bloom with hues that shift and change, echoing the passing of time. The fragrant air carries whispers of ancient wisdom, and the tranquil atmosphere invites contemplation and introspection."
}

{
    "name": "Techno-Arcade",
    "description": "You immerse yourself in a pulsating techno-arcade, where neon lights flicker and energetic music fills the air. Futuristic gaming consoles and virtual reality stations beckon you to explore captivating digital realms. Amongst the electrifying ambiance, skilled players engage in thrilling competitions of skill and strategy."
}

{
    "name": "Cybernetics Lab",
    "description": "You enter a sleek cybernetics lab where scientists in lab coats and augmented individuals collaborate on the cutting edge of human-machine integration. Advanced robotic arms dance with precision, while computer terminals hum with streams of data. The air crackles with anticipation as the boundaries between flesh and technology blur."
}

{
    "name": "Echo Chamber",
    "description": "You step into an enigmatic echo chamber, its walls adorned with intricate sound amplification devices. Within this space, whispers from ages past linger, echoing through time. The air is charged with an otherworldly energy as the chamber's soundwaves intertwine, revealing cryptic messages and long-forgotten secrets."
}

{
    "name": "Dimensional Gallery",
    "description": "You wander through a captivating dimensional gallery, where masterful paintings and captivating sculptures transport you to parallel realities. Each artwork portrays vistas and beings from realms beyond imagination. As you explore, you feel the veil between dimensions thinning, offering glimpses into the infinite possibilities of existence."
}

{
    "name": "Timeless Ballroom",
    "description": "You step into a resplendent ballroom frozen in an eternal moment. Crystal chandeliers cast a warm glow upon the opulent decor, as ghostly echoes of waltzing couples resonate through the air. The faded elegance of this timeless space evokes a sense of nostalgia, where memories of grand celebrations and hidden stories intertwine."
}




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
    * Image
* Items
    * Name
    * Description
    * Image
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

Minicluedo?

# TODO:
[OK] Enkel prototyp enligt flödesdiagram
    * Gå mellan rum (lägg till i app-koden)
[OK] Bastyling
[OK] Grunden för att visa bilder
[OK] Databas rooms
[OK] JSON-routes rooms
[OK] Bilder + lägg till några rum i db via json
* Uppdatera rum json
* Lägg till alla rum med placeholder-bilder
* Fixa problem med recursive
* Recursive-problemet
* Typografi-styling
* Minimap
* Items
* Databas items
* JSON-routes items
* Quests/wincons

## LÄNGRE FRAM
* Fixa inaccessible rooms (checkaccessibility-funktionen i Map)
* Skapa en doorgenerator-klass?






# API DOCS


## Add Room Info
Add a new room info.

### Endpoint
```
POST /proj/api/roominfo/add
```

### Request Headers
- Content-Type: multipart/form-data

### Request Body
The request body should contain two parts: `json_data` and `img`.

#### Part: json_data
- Type: JSON
- Description: The JSON data representing the room info.
- Example:
```json
{
  "name": "Room Name",
  "description": "Room Description"
}
```

#### Part: img
- Type: File
- Description: The image file associated with the room info.

### Example Request
```
POST /proj/api/roominfo/add
Content-Type: multipart/form-data

----Boundary
Content-Disposition: form-data; name="json_data"

{
  "name": "Room Name",
  "description": "Room Description"
}
----Boundary
Content-Disposition: form-data; name="img"; filename="room_image.jpg"
Content-Type: image/jpeg

[Binary image data]
----Boundary--
```

### Response
- Status: 201 Created
- Body: Added room info

