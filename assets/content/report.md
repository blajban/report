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

Redovisningstext.

<a name="kmom04"></a>

### Kmom04

Redovisningstext.

<a name="kmom05"></a>

### Kmom05

Redovisningstext.

<a name="kmom06"></a>

### Kmom06

Redovisningstext.

<a name="kmom10"></a>

### Kmom10

Redovisningstext.