## Installera och konfigurera

[OK] Installera phpunit och lägg till det som ett skript composer phpunit.

[OK] Gör så att kodtäckningsrapport för HTML genereras till katalogen docs/coverage.

## Bygg en test suite

[OK] Skapa en test suite för ditt kortspel.

[OK] Dina modellklasser är dina testobjekt och varje modellklass skall ha minst en testklass med testfall.

[OK] Varje testfall har minst en assertion.

[OK] Du har en kodtäckning som överträffar 70% på varje testobjekt men sikta mot att nå över 90% kodtäckning.

[OK] Det är helt okey om du vill uppdatera din källkod för att göra den bättre eller mer testbar. Code refactoring (att skriva om sin kod för att förbättra den) är ofta ett bra alternativ.

* [OPTINELLT] Som en extra utmaning kan du se om dina controllers är testbara med phpunit och i vilken mån du kan testa dem eller vad som krävs för att du skall kunna testa dem.

## Dokumentara kod

* Välj ut minst en av dina klasser och lägg till kommentarer med PHP DockBlock. Dina kommentarer skall minst innehålla en rads beskrivning av vad metoderna och klassen gör.

* Generera dokumentationen till katalogen docs/api med kommandot composer phpdoc.

## Utvecklingsmiljö

* Fixa till din kod enligt den kodstil du kör genom att köra composer csfix.

* Kolla din kod hur den matchar dina linters genom att köra composer lint.

* Dubbelkolla att dina testfall passerar med composer phpunit.

* Generera documentation av din kod med composer phpdoc.

## Publicera

* Committa alla filer och lägg till en tagg 4.0.0. Om du gör uppdateringar så ökar du taggen till 4.0.1, 4.0.2, 4.1.0 eller liknande.

* Kör dbwebb test kmom04 för att kolla att du inte har några fel.

* Pusha upp repot till GitHub, inklusive taggarna.

* Gör en dbwebb publishpure report och kontrollera att att det fungerar på studentservern.
