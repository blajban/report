## Klasser
    - Card, ett kort
    - CardHand, en giv av kort, en korthand
    - DeckOfCards, en kortlek

Du skall ha 
    [OK] minst ett arv och här kan du välja att jobba med ett Card och ett CardGraphic som två olika kort. Du kan också välja att ha en DeckOfCards som har jokrar och en som inte har jokrar. Det är fritt så länge du har med minst ett arv.

## Flera små commits


## Skapa klasser och använd dem i webbsidor

Börja med att utveckla dina klasser och testa dem i webbsidor enligt följande.

[OK] Skapa en kontroller i Symfony där du kan skapa routes för denna delen av uppgiften.

[OK] Gör en förstasida card som länkar till samtliga undersidor för denna uppgiften. Detta är din “landningssida” för denna uppgiften. Placera länken till sidan i din navbar så den är lätt att nå.

[OK] På din landdningssida, 
    [OK] berätta kort om strukturen på dina klasser, vilka klasser har du och hur är de relaterade till varandra. 
    [OK] Rita ett UML klass diagram och visa i sidan.

[OK] Skapa en sida card/deck som visar samtliga kort i kortleken sorterade per färg och värde.

[OK] Skapa en sida card/deck/shuffle som visar samtliga kort i kortleken när den har blandats.

[OK] Skapa en sida card/deck/draw som drar ett kort från kortleken och visar upp det. Visa även antalet kort som är kvar i kortleken.

[OK] Skapa en sida card/deck/draw/:number som drar :number kort från kortleken och visar upp dem. Visa även antalet kort som är kvar i kortleken.

[OK] Kortleken skall sparas i sessionen så om man anropar sidorna draw och draw/:number så skall hela tiden antalet kort från korleken minskas tills kortleken är slut. När man gör card/deck/shuffle så kan kortleken återställas.

[OK] [OPTIONELLT] Skapa en sida card/deck/deal/:players/:cards som delar ut ett antal :cards från kortleken till ett antal :players och visar upp de korten som respektive spelare har fått. Visa även antalet kort som är kvar i kortleken.

## Bygg JSON API

Denna delen gäller främst JSON API krav.

[OK] Skapa en landningssida för routen api/ som visar en webbsida med en sammanställning av alla JSON routes som din webbplats erbjuder.

[OK] Börja med att lägga till den route du skapade i kmom01 api/quote, länka till den och ge en kort förklaring av vad routen gör.

[OK] Skapa en kontroller i Symfony där du kan skapa routes för ett JSON API för denna delen av uppgiften.

[OK] Skapa en route GET api/deck som returnerar en JSON struktur med hela kortleken sorterad per färg och värde.

[OK] Skapa en route POST api/deck/shuffle som blandar kortleken och därefter returnerar en JSON struktur med kortleken.

[OK] Skapa route POST api/deck/draw och POST api/deck/draw/:number som drar 1 eller :number kort från kortleken och visar upp dem i en JSON struktur samt antalet kort som är kvar i kortleken. Kortleken sparas i sessionen så om man anropar dem flera gånger så minskas antalet kort i kortleken.

[OK] [OPTIONELLT] Skapa en route POST api/deck/deal/:players/:cards som delar ut ett antal :cards från kortleken till ett antal :players och visar upp de korten som respektive spelare har fått i en JSON struktur. Visa även antalet kort som är kvar i kortleken.

## Kodvalidering

[OK] Fixa till din kod enligt den kodstil du kör genom att köra composer csfix.


## Publicera

[OK] npm run build!

[OK] Committa alla filer och lägg till en tagg 2.0.0. Om du gör uppdateringar så ökar du taggen till 2.0.1, 2.0.2, 2.1.0 eller liknande.

[OK] Kör dbwebb test kmom02 för att kolla att du inte har några uppenbara fel.

[OK] Pusha upp repot till GitHub, inklusive taggarna.

[OK] Skriv redovisningstext

[OK] Fixal länkarna på landningssidorna

[OK] Uppdatera tagg och commita redovisningstext

* Gör en dbwebb publishpure report och kontrollera att att det fungerar på studentservern.

