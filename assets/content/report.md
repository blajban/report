<a name="kmom01"></a>

### Kmom01
Kul att komma igång med kursen igen! Jag påbörjade den vårterminen 2022 men på grund av byte av jobb hann jag inte köra klart den. Jag har tidigare fuskat med c++ på kvällarna i några år, tidigare gått oopython-kursen och även vteam-kursen, så jag känner att jag har hyfsad koll på läget när det gäller objektorienteringen. Php känns lite ringrostigt nu i början men det ger sig säkert snart.

Så vitt jag förstår är det inte så mycket som skiljer just i objektorienteringen gentemot mot andra språk, det finns attribut och det finns metoder och man kan säga att klassen är mallen som man använder för att instansiera objektet. Viktigt att komma ihåg är att ->-operatorn används för att anropa metoder i objekt och att $this används för att referera till just det objekt jag använder nu, till exempel för att komma åt medlemsvariabler/attribut. Det finns också ett standardobjekt som man kan använda lite på samma sätt som ett javascript-objekt tänker jag. Men för att jobba med objektorientering på riktigt är det såklart egendefinierade klasser som gäller.

Jag tänker att jag kommer ha god nytta av "PHP the right way", men jag vet inte om jag skulle kalla den för en "artikel". Den är snarare ett uppslagsverk. Jag har skummat litegrann och känner att jag kommer återkomma till flera områden när det blir aktuellt.

Utmaningen för mig ligger nog mer i arbetet med strukturen, ramverket och så vidare. Att få allt att funka och lira ihop. Men efter att ha jobbat igenom uppgift 1 känner jag att jag börjar lära känna kodbasen och strukturen vi ska jobba med. Jag har utforskat en del, t ex lagt in stöd för Sass och ett par andra moduler. Det känns bra! Samtidigt finns det fortfarande mängder med konfigurationsfiler och annat som jag inte har en aning om vad de gör. Mitt TIL för detta kursmoment handlar nog om just detta, det kändes som att jag gjorde det mesta själv och på riktigt (även om jag återanvände en hel del från förra året...). Men det har varit mycket fixande i terminalen, installation av moduler etc som gjort att jag känner att jag rört mig framåt.

<a name="kmom02"></a>

### Kmom02

Jag känner att jag har bra koll på arv och komposition. Arv är en är-relation, en student är en person. Person är basklassen och så ärver man person när man skapar student-klassen och får då med den funktionalitet som finns i basklassen. Komposition är en har-relation. En fotbollsplan har spelare, men fotbollsplanen kan vara utan spelare och en spelare är definitivt inte en fotbollsplan. Här skulle spelaren då existera som en variabel i fotbollsplan-klassen. 

Jag är relativt nöjd med hur det blev, försökte också utforska interface och traits i min kod, vilket är nyheter för mig. Jag tänker att trait är som en liten byggsten som man kan lägga till i sina klasser, där traitet då innehåller färdig kod som helt enkelt bakas in i klassen och blir en del av klassen när koden körs. Interface däremot beskriver vilka krav en klass ska uppfylla, t ex vilka metoder som ska finnas, men lämnar implementationen till den som kodar. Trait och interface är definitivt mitt TIL den här gången och jag försökte använda båda i min implementation.

Card-klassen implementerar ett interface som förutom funktioner också innehåller ett antal konstanter, till exempel css-klasser och namn på färgerna. Jag har också några konstanter till färgerna så man slipper ange färgerna med strängar när man skapar kortet. Konstanterna gör också att de direkt kan mappas in i const-arrayerna med namn vilket funkar mycket bra. 

Man kan fundera på vilken nytta det första interfacet gjorde i form av återanvändbar kod, men om vi går vidare till Deck-klassen som implementerar ett deck-interface ser jag verkligen nyttan. Deck-interfacet skulle ju kunna användas även till andra typer av lekar, en magic-lek eller pokemon-lek eller vad som helst. Själva funktionaliteten eller koden i både card och deck är relativt simpel. 

För att få in arv gjorde jag en joker-leken som ärver från Deck. För Player använde jag ett cardhand-interface och ett trait med implementationerna av cardhand-interfacet. Denna lösning kändes också väldigt bra, jag ser framför mig att Player-klassen skulle kunna implementera fler interfaces. Till exempel lade jag till spelarnamn i klassen, och där hade man såklart kunna tänka sig ett playerinfo-interface exempelvis. Också omvänt, att cardhand-interfacet och cardhand-traitet skulle kunna användas för t ex en bank eller annan aktör vid ett kortspel. Controllern och att skicka data till template-filerna fungerade också bra.

Jag är mycket nöjd med CardGame-klassen som gjorde att koden kunde delas mellan webb-delen och json-delen i mycket hög utsträckning.

Totalt sett ett kul kursmoment och jag tycker att det blev snyggt och prydligt på sidan.

<a name="kmom03"></a>

### Kmom03

Det kändes givetvis lite jobbigt att dra igång modellerandet av spelet, men jag vet sedan tidigare och fick nu bekräftat igen att det är oerhört nyttigt och värdefullt. Jag gjorde flödesdiagrammen i två delar, först ett övergripande utifrån användarens perspektiv, själva spelflödet, och sedan bröt jag ner de olika delarna med fokus på kodflödet. Det funkade bra och blev en jättestor hjälp i själva kodandet. Allt blev inte exakt så som jag tänkt, men näst intill. Pseudokoden var också väldigt värdefull, även om det var lite svårt att veta vilken nivå man skulle hålla det på. Jag valde att göra en del av flödet som pseudokod. 

Jag har hållt kontrollerna väldigt små och försökt tänka att de alla i princip ska fungera likadant: skapa ett Game-objekt, gör eventuellt något, och skicka sedan game state till template-filen. Själva spelet hanteras helt i Game-klassen. Man skulle kunna tänka sig att bryta ner den i fler klasser också, t ex en klass som hanterar själva spelsessionen. Det mesta var ganska straight forward, det jag pillade mest med var hanteringen av ess. I slutändan löste jag det genom en algoritm som först räknar poäng om ess är 1, och sedan testar om poängen är under 21 om man gör om till esset till 14. Jag hoppas att jag hittat alla edge cases i algoritmen, annars kommer det kanske visa sig i nästa kursmoment som jag förstår handlar om testning. 

Jag tycker symfony känns bra och rimligt, även om det känns väldigt omfattande med många filer jämfört t ex med express. 

Totalt sett är jag mycket nöjd. Mitt TIL för kursmomentet är nog ytterligare bekräftelse på att jag är rätt bra på att göra flödesscheman och tänka kring koden innan.

<a name="kmom04"></a>

### Kmom04

I föreläsningen pratade Mos om hur testerna ger förtroende för koden, och jag håller verkligen med. Jag har nu ett högt förtroende för att min kod fungerar, vilket känns bra. Tyckte det fungerade bra att skriva testerna, PHPUnit är lättanvänt. Jag skrev tester för alla klasser utom CardGame-klassen (som hör till kmom01-02), och lyckades nå 100 procent på alla klasser förutom Game-klassen där jag nådde 89 procent. Totalt sett var koden testbar utan att jag behövde göra för mycket ändringar eller avancerade testkonstruktioner, men i Game-klassen gjorde min implementation och hanteringen av sessionen att testbarheten blev lidande. Det hade kunnat utvecklas. Jag fick till exempel lägga till en klass som ärver från game-klassen bara för att kunna testa den privata leken i game-klassen.

Testbar och snygg och ren kod hänger definitivt ihop. Optimalt vill man ju ha metoder som tar in en eller ett par parametrar, gör något och returnerar något. Den typen av metoder utan sidoeffekter är också ren och snygg kod. Jag tror att jag hade för mycket sidoeffekter i min game-klass till exempel.

Jag skrev om små delar av koden här och där för att underlätta testningen, men inget större. Man hade kunnat göra om game-klassen, men jag är samtidigt nöjd med implementationen. Det var framför allt sessionshanteringen som var problemet.

Mitt TIL gäller väl att fundera igenom testbarhets-aspekterna innan implementation, så att game-klassen hade blivit lite lättare att testa.


<a name="kmom05"></a>

### Kmom05

Superkul kursmoment, bra att bryta av kort-delen av kursen litegrann. Det kändes bra att knyta ihop säcken hela vägen med backend med databas och frontend med templates och forms. Kul! Jag tyckte det fungerade bra och var logiskt helt vägen.

Jag försökte göra ett bra och logiskt användargränssnitt, enkelt i grunden men försökte utmana mig själv genom att göra det möjligt att visa upp och redigera/ta bort flera böcker på en gång. Nådde inte riktigt hela vägen med användargränssnittet för redigeringsdelen, men tycker det fungerar bra nog för uppgiften. Annars har jag följt instruktionerna i kursmomentet och funktionaliteten finns där. jag valde att lägga all kod i controllern och i repository-klassen, det fanns liksom inte så mycket logik som inte handlade om att lägga till/uppdatera databasen. Tycker det blev rent och snyggt. 

ORM fungerade också bra, det blev lite med känslan av att jobba med en dokumentdatabas. Jag ser definitivt fördelar med ORM, till exempel enkelheten och att det fungerar med många olika databaser. Samtidigt finns det ju nackdelar. Säg att jag jobbar med många olika teknologier, t ex php, python, nodejs, då måste jag ju lära mig ORM-bibliotek inom flera olika teknologier.

Mitt TIL för kursmomentet är nog helheten, att jag kunde utveckla en liten mini-applikation hela vägen från databas till ux utan några större bekymmer. Man har lärt sig en del ändå!

<a name="kmom06"></a>

### Kmom06

Redovisningstext.

<a name="kmom10"></a>

### Kmom10

Redovisningstext.