
* Fix methods returning multiple types
* Ignore errors from session phpstan

# En spelrunda

Spelets idé är att med två eller flera kort försöka uppnå det sammanlagda värdet 21, eller komma så nära som möjligt utan att överskrida 21. Ess är värt 1 eller 14.

En spelrunda kan se ut så här när en spelare spelar mot banken.

[OK] Spelet leder till en landningssida där man kan läsa spelregler och se dokumentation om spelet samt påbörja ett spel.
[OK] Spelplanen visas och spelaren och banken har inte tagit några kort.
[OK] Spelaren tar ett kort. Kortet visas.
[OK] Spelaren kan bestämma att stanna eller ta ytterligare ett kort.
    [OK] Om spelaren får över 21 vinner banken.
[OK] När spelaren stannar så är det bankens tur.
[OK] Banken är inte medveten om spelarens korthand.
[OK] Banken plockar kort tills den stannar eller har över 21.
    [OK] Banken vinner vid lika eller om banken har mer än spelaren.
    [OK] Spelaren vinner om banken får över 21.
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

[OK] Fixa vinnarskärmen

[OK] hantering av ess
    [OK] Banken
    [OK] Spelaren


[OK] Winner session

Bygg ditt kortspel i Symfony med objektorienterade konstruktioner i PHP och försök tänka till så att du får “snygg kod”.

[OK] All applikationskod placerar du i klasser som din kontroller använder. Se till att du har så lite kod som möjligt i din kontroller. Om du har mycket kod där så flyttar du den till en egen klass. Tänk att kontrollern skall vara tunn (lite kod) och modellerna (applikationens klasser) kan vara tjocka (mycket kod).

[OK] Använd templatefiler för att rendera webbsidorna.

[OK] Bygg spelet så att det fungerar minst enligt de regler som visas i introduktionen ovan.

[OK] Banken behöver inte vara speciellt intelligent i sitt kortspel. Det räcker att den kan utföra sin uppgift och spela spelet. En enkel variant är att banken alltid plockar kort tills den har 17 eller mer, sedan stannar den.



Kortspel JSON

[OK] I din landningssida för api/ lägger du till routen api/game som visar upp den aktuella ställningen för spelet i en JSON struktur.

# Kodvalidering

[OK] Fixa till din kod enligt den kodstil du kör genom att köra composer csfix.

[OK] Kolla din kod hur den matchar dina linters genom att köra composer lint. Får du fel så kollar du vad det är och rättar de sakerna du anser rimliga. Försök få en ren och tom rapport, utan valideringsfel.

Publicera

[OK] Committa alla filer och lägg till en tagg 3.0.0. Om du gör uppdateringar så ökar du taggen till 3.0.1, 3.0.2, 3.1.0 eller liknande.

[OK] Kör dbwebb test kmom03 för att kolla att du inte har några uppenbara fel.

[OK] Pusha upp repot till GitHub, inklusive taggarna.

[OK] Gör en dbwebb publishpure report och kontrollera att att det fungerar på studentservern.




## Anteckningar till redovisning

* Gjorde om lite i cardgame-klassen, lättade upp interfacet och la till ett trait för att kunna återanvända kod mellan klasserna. Game-klassen implementerar cardgame-interfacet och använder traitet. Blev mycket bra!
