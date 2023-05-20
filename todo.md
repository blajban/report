## Om uppgiften

Uppgiften handlar dels om att göra din egen analys av kodkvalitet med hjälp av phpmetrics och Scrutinizer.

Därefter skall du identifiera ett antal förbättringsmöjligheter och genomföra dem i din kod.

Slutligen analyserar du om och hur dina ändringar påverkade rapporterna från phpmetrics och Scrutinizer. Försök att nå så höga “poäng” som möjligt och så lite varningar som möjligt.
Krav

### Kodkvalitet

[OK] Skapa en landningssida metrics/ för din “Metrics analys” som handlar om kodkvalitet och hur man kan jobba med “Clean code”. Placera landningssidan i din navbar. Du skriver din rapport direkt i landningssidan.

[OK] Börja med en rubrik “Introduktion” där du förklarar de sex C:na och hur de kan påverka kodens kvalitet. Exemplifiera, där det passar, med några mätvärden som är kopplad till din egen kod och ge en kort förklaring av mätvärdet relaterat till kodkvalitet.

[OK] Skapa en rubrik “Phpmetrics” och analysera dess rapport för din kod. Använd mätvärdena för att hitta flaskhalsar och svaga punkter i din kod (minst 3 stycken). Du vill hitta kod som har förbättringspotential. Visualisera med någon representativ bild från rapporten.

[OK] Skapa en rubrik “Scrutinizer” och analysera dess rapport för din kod. Gör på samma sätt som du gjorde med Phpmetrics.

[OK] I ovan analys så kopplar du dina “findings” till 6C. Använd gärna något ytterligare mättal som du finner relevant och intressant.

[OK] Skapa en ny rubrik “Förbättringar” där du väljer minst 3 förbättringar som du vill göra med din kod (gärna fler).

    * Exempel på förbättringar kan vara:
        * Fixa issues
        * Öka kodtäckning
        * Fokusera på kvalitetsindex i Scrutinizer
        * Minska komplexiteten i class/metod

    [OK] Börja med att skriva om förbättringarna, vad du tänker göra, varför du väljer dem och hur du tror det kommer påverka mätvärdena för kvalitet.
    * Implementera sedan förbättringarna.
    * Analysera därefter rapporterna från phpmetrics och Scrutinizer och notera de nya mätvärdena.
    * Gör det tydligt hur mätvärdena såg ut innan och efter dina förbättringar.

* Avsluta med ett stycke “Diskussion” där du diskuterar kort kring det du nyss gjort.
    * Kan man aktivt jobba med kodkvalitet och “clean code” på detta sättet?
    * Finns det fördelar och kanske nackdelar?
    * Ser du andra möjligheter att jobba mot “clean code”?

### Utvecklingsmiljö

Se till att köra verktygen i din utvecklingsmiljö så att de hanterar den uppdaterade koden.

* Fixa till din kod enligt den kodstil du kör genom att köra composer csfix.

* Kolla din kod hur den matchar dina linters genom att köra composer lint.

* Dubbelkolla att dina testfall passerar med composer phpunit.

* Generera dokumentation av din kod med composer phpdoc.

* Generera metrics för din kod composer metrics.

### Publicera

* Committa alla filer och lägg till en tagg 6.0.0. Om du gör uppdateringar så ökar du taggen till 6.0.1, 6.0.2, 6.1.0 eller liknande.

* Kör dbwebb test kmom06 för att kolla att du inte har några fel.

* Pusha upp repot till GitHub, inklusive taggarna.

* Verifiera att Scrutinizer är uppdaterad med senaste versionen av din kod.

* Gör en dbwebb publishpure report och kontrollera att att det fungerar på studentservern.
