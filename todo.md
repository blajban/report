## Introduktion och förberedelse

Du skall göra en mindre CRUD applikation i Symfony med Doctrine. Du kan välja fokus för din applikation. Standardfokuset på uppgiften är “Bibliotek med böcker” men du kan ändra fokus och spara andra saker i din databas.

Du kan välja mellan SQLite och MariaDB. Om du väljer SQLite så ligger hela databasen i en fil och följer med till produktionsmiljön (studentservern). Du har alltså samma databas lokalt och på produktionsmiljön. Om du jobbar med MariaDB så har du en databas lokalt och en annan databas på produktionsservern. Det blir lite mer “riktigt” men också lite mer konfiguration att hantera. Är du osäker så kan du börja med SQLite och den enklare vägen. Du kan alltid byta databas i ett senare skede.
Krav

## Bibliotek CRUD

[OK] Skapa en landningssida library/ för din “Bibliotek” applikation. Placera landningssidan i din navbar.

[OK] Fixa innehåll för landningssidan

[OK] Skapa en databas som innehåller en tabell med böcker. 

* Lägg in minst tre böcker (riktiga eller påhittade) med deras 
    [OK] titel, 
    [OK] ISBN och 
    [OK] författare samt en 
    [OK] bild som representerar boken.



* Hantera att man inte kan uppdatera flera på en gång. Antingen alltid uppdatera alla? Eller gråa ut dom man inte kan uppdatera?
* Gråa ut knappen om man inte gjort några ändringar?
* Lägg till en flagga som säger att uppdateringarna sparats när man klickat på spara uppdateringar
* Gör en table på redigera-sidan istället?


[OK] Kolla hur man kan ladda upp en bild i databasen

[OK] [CREATE] Skapa en möjlighet att lägga till en ny bok. Man skall kunna mata in detaljer om boken i ett formulär.

[OK] [READ ONE] Skapa en webbsida där man kan se detaljer om en viss bok.


[OK] [READ MANY] Skapa en webbsida där man kan se samtliga böcker i en HTML tabell (eller liknande).

[OK] Man skall kunna klicka på en bok och komma vidare till en sida som enbart visar detaljer om den boken.



[OK] [UPDATE] Man skall kunna uppdatera detaljer om en bok. Det skall finnas en sida som visar bokens detaljer i ett formulär och man skall kunna uppdatera bokens detaljer och spara dem.


[OK] [DELETE] Man skall kunna radera en bok.

[OK] Använd GET och POST. Kom ihåg att alltid använda POST när du gör en uppdatering i databasen.

[OK] Inkludera möjligheten att återställa databasen till sitt ursprungliga innehåll via routen library/reset.

[OK] Alla delar av “Biblioteket” skall fungera tillsammans som en applikation. Det finns länkar och formulär som är sammankopplade och man får en “user experience” av att applikationen hänger ihop.

## Bibliotek JSON

[OK] I din landningssida för api/ lägger du till routen api/library/books som visar upp samtliga böcker i biblioteket i en JSON struktur.

[OK] Lägg till routen api/library/book/<isbn> där man kan se en av böckerna via dess ISBN nummer. Lägg till ett exempel som länkar direkt till en av böckerna i biblioteket.

* Lägg till i landningssidan för api (exempel och länk till alla)

## Utvecklingsmiljö

* Fixa till din kod enligt den kodstil du kör genom att köra composer csfix.

* Kolla din kod hur den matchar dina linters genom att köra composer lint.

* Dubbelkolla att dina testfall passerar med composer phpunit.

* Generera documentation av din kod med composer phpdoc.

## Publicera

* TESTA ALLT

* Committa alla filer och lägg till en tagg 5.0.0. Om du gör uppdateringar så ökar du taggen till 5.0.1, 5.0.2, 5.1.0 eller liknande.

* Kör dbwebb test kmom05 för att kolla att du inte har några fel.

* Pusha upp repot till GitHub, inklusive taggarna.

* Gör en dbwebb publishpure report och kontrollera att att det fungerar på studentservern.
