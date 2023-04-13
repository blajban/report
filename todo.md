
[OK] Uppdatera redovisningstexten

[OK] Gör en installation av Symfony och placera den i me/report. Den publika webbkatalogen skall ligga som me/report/public.

[OK] Skapa följande webbsidor, använd controller, templatefiler och en templatemotor, förslagsvis Twig.
    [OK] Skapa en route / som ger en presentation av dig själv inklusive en bild. Det är okey att vara anonym och hitta på en figur att presentera.
    [OK] Skapa en route /about som berättar om kursen mvc och dess syfte. Länka till kursens Git-repo. Lägg till en representativ bild. Skapa ytterligare en länk som leder till ditt egna GitHub-repo. 
        [OK] Sidan skall ha två kolumner.
    [OK] Skapa en route /report där du samlar dina redovisningstexter för kursens kmom.
    [OK] Skapa även så att länken /report#kmom01 leder direkt till kursmomentets redovisningstext.

[OK] Skapa en ny route /lucky som visar något dynamiskt värde när man laddar om sidan tillsammans med en/flera bilder. Det kan vara ett “lucky number” men kanske kan du hitta på något annat spännande att visa upp i sidan. Gör sidan lite snygg och stylad, kanske till och med lite “crazy”. Se om du kan vara lite kreativ.

[OK] Skapa en tilltalande och enhetlig style till webbplatsen. Du kan använda LESS/SASS eller liknande CSS preprocessorer. Du kan använda CSS ramverk. Fundera och gör ett val.

[OK] Sidorna skall ha en enhetlig layout och det skall finns:
    [OK] En tydlig header överst på varje sida, med eller utan bild.
    [OK] En navbar som gör att man kan navigera mellan samtliga sidor.
    [OK] En footer längst ned som visar rimliga detaljer.

[OK] Skapa en route /api/quote där du ger ett JSON svar som innehåller dagens citat. Växla slumpmässigt mellan (minst) tre olika citat som du själv hittat på eller lånat av någon. JSON svaret skall även innehålla dagens datum och en tidsstämpel för när svaret genererades. Denna route ger alltså enbart ett JSON svar och inkluderar inte någon gemensam sidlayout som header, footer.

[OK] Skapa ett Git repo av katalogen me/report. Koppla samman repot med GitHub, GitLab eller liknande tjänst.

* Committa alla filer och lägg till en tagg 1.0.0. Om du gör uppdateringar så ökar du taggen till 1.0.1, 1.0.2, 1.1.0 eller liknande.

* Kör dbwebb test kmom01 för att kolla att du inte har några uppenbara fel.

* Pusha upp repot till GitHub, inklusive taggarna.

* Gör en dbwebb publishpure report för att kolla att det fungerar på studentservern.
