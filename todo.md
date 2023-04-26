
* Fix methods returning multiple types
* Ignore errors from session phpstan

# En spelrunda

Spelets idé är att med två eller flera kort försöka uppnå det sammanlagda värdet 21, eller komma så nära som möjligt utan att överskrida 21. Ess är värt 1 eller 14.

En spelrunda kan se ut så här när en spelare spelar mot banken.

[OK] Spelet leder till en landningssida där man kan läsa spelregler och se dokumentation om spelet samt påbörja ett spel.
[OK] Spelplanen visas och spelaren och banken har inte tagit några kort.
[OK] Spelaren tar ett kort. Kortet visas.
[OK] Spelaren kan bestämma att stanna eller ta ytterligare ett kort.
    * Om spelaren får över 21 vinner banken.
[OK] När spelaren stannar så är det bankens tur.
[OK] Banken är inte medveten om spelarens korthand.
* Banken plockar kort tills den stannar eller har över 21.
    * Banken vinner vid lika eller om banken har mer än spelaren.
    * Spelaren vinner om banken får över 21.
[OK] Därefter kan man påbörja en ny omgång.

# Landningssida och intro

[OK] Skapa en landdningssida för spelet game/ där du samlar information om spelet och kan starta spelet. Placera länken i webbplatsens navbar.

[OK] I din landningssida, inled med en kort beskrivning av ditt kortspel och reglerna för hur det fungerar.

[OK] Placera en knapp eller länk som leder till att spelet börjar.
 

# Problemlösning

Du skall problemlösa det spelet du valt med flödesschema och pseudokod. Gör din problemlösning innan du påbörjar att implementera spelet.

[OK] Samla all din dokumentation i en webbsida under routen game/doc 

[OK] och länka till dokumentationssidan från din landningssida.

[OK] Skapa ett flödesschema som representerar hur du tänker lösa grunderna i spelet. Resultatet kan du placera som en bild i webbsidan för dokumentationen. Det behöver inte vara en komplett lösning, en dellösning räcker bra.

[OK] Skapa psuedokod som visar hur du tänker lösa delar av spelet. Du kan spara resultatet som text eller bild men visa upp det i webbsidan för dokumentationen. Det behöver inte vara en komplett lösning, en dellösning räcker bra.

[OK] Fundera igenom vilka klasser du behöver för att implementera spelet. Beskriv klasserna i text med klassens namn och en mening som beskriver vad klassens syfte är. Håll det kort och enkelt.

Följande krav är optionella och du gör dem om du har tid och lust.

* Rita ett UML klass diagram som du också visar i webbsidan för dokumentationen.

# Kortspel

* Ta bort var dumpen

* Fixa vinnarskärmen

* Lägg till poäng på spelskärmen

* hantering av ess

* Winner session

* Lägg till status i gamestate (not started, playing, player/bank winner)

Bygg ditt kortspel i Symfony med objektorienterade konstruktioner i PHP och försök tänka till så att du får “snygg kod”.

* All applikationskod placerar du i klasser som din kontroller använder. Se till att du har så lite kod som möjligt i din kontroller. Om du har mycket kod där så flyttar du den till en egen klass. Tänk att kontrollern skall vara tunn (lite kod) och modellerna (applikationens klasser) kan vara tjocka (mycket kod).

* Använd templatefiler för att rendera webbsidorna.

* Bygg spelet så att det fungerar minst enligt de regler som visas i introduktionen ovan.

[OK] Banken behöver inte vara speciellt intelligent i sitt kortspel. Det räcker att den kan utföra sin uppgift och spela spelet. En enkel variant är att banken alltid plockar kort tills den har 17 eller mer, sedan stannar den.

Följande krav är optionella och du gör dem om du har tid och lust.

* Gör så att spelaren kan satsa pengar. Man kan satsa en viss summa vid varje spel. Håll koll på hur mycket pengar som spelaren och banken har.

* Låt banken och spelaren börja med 100 pengar var. När någon har 0 pengar har den spelaren förlorat.

* Korträkning med sannolikhet att få högt/lågt kort. Låt bli att blanda kortleken inför varje ny runda och spela tills kortleken är slut. Visa statistik som berättar sannolikheten för att få ett visst kort. Visa statistiken så att spelaren kan ha hjälp av den. Tex om spelaren har 15, visa sannolikheten för att spelaren inte skall bli tjock om nytt kort tas.

* Bygg en smartare bank som spelar på ett “intelligent sätt”. Låt banken ta hjälp av statistiken.

* Låt spelaren välja om den spelar mot den “dumma” eller den “smarta” banken.

* Förklara taktiken för den “dumma” och den “smarta” banken på dokumentationssidan.

Kortspel JSON

[OK] I din landningssida för api/ lägger du till routen api/game som visar upp den aktuella ställningen för spelet i en JSON struktur.

# Kodvalidering

* Fixa till din kod enligt den kodstil du kör genom att köra composer csfix.

* Kolla din kod hur den matchar dina linters genom att köra composer lint. Får du fel så kollar du vad det är och rättar de sakerna du anser rimliga. Försök få en ren och tom rapport, utan valideringsfel.

Publicera

* Committa alla filer och lägg till en tagg 3.0.0. Om du gör uppdateringar så ökar du taggen till 3.0.1, 3.0.2, 3.1.0 eller liknande.

* Kör dbwebb test kmom03 för att kolla att du inte har några uppenbara fel.

* Pusha upp repot till GitHub, inklusive taggarna.

* Gör en dbwebb publishpure report och kontrollera att att det fungerar på studentservern.




## Anteckningar till redovisning

* Gjorde om lite i cardgame-klassen, lättade upp interfacet och la till ett trait för att kunna återanvända kod mellan klasserna. Game-klassen implementerar cardgame-interfacet och använder traitet. Blev mycket bra!
