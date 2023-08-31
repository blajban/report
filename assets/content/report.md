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

Relativt segt kursmoment för mig, drog ut väldigt mycket på tiden. Men nu när det är klart så var det givetvis nyttigt och bra att dyka ner i rapporterna. PHPMetrics tycker jag kunde varit mycket bättre, med mer förklaringar och möjlighet att dyka ner i klasserna. T ex gick det inte att gå ner i en klass och se **vilka** metoder jag skulle fokusera på. Hade också önskat mer vägledning från systemet om vilka parametrar som ger en varning om probably bugged t ex, nu är det bara allmän information. Dock var det en del bra sammanställningar, till exempel coupling-sektionen. 

Scrutinizier däremot var ju väldigt trevligt, lätt att komma igång, trevliga rapporter som går att klicka runt i, lätt att förstå. Skulle jag välja ett verktyg att använda så skulle det absolut vara Scrutinizer. Kanske berodde det på att känslan Scrutinizer gav mig var väldigt mycket mer positiv med ett första betyg på 9,94, till skillnad från PHPMetrics som visade ilskna röda bollar.

För mig är hög kodkvalitet kod som gör det den ska och är lätt att läsa och ta del av. Självförklarande variabelnamn, logisk formatering med indrag. Jag ska inte behöva kommentarer för att förstå hur koden fungerar. 

Mitt TIL för kursmomentet är absolut den cyklomatiska komplexiteten. Jag tror att den mesta koden blir av högre kvalitet om vi försöker minska den cyklomatiska komplexiteten så mycket som möjligt. Det kommer jag bära med mig.


<a name="kmom10"></a>

### Kmom10

#### Krav 1-3
När jag valde att göra ett äventyrsspel fick jag först lite ågren. Hur göra med story/flavor text? Och hur fixa bilder? Tur då att det nu för tiden finns verktyg som ChatGPT och DALL-E. Perfekt för att snabbt skapa innehåll! Spelet fick namnet Chronos Mansion och går ut på att hitta och föra prylar till rätt rum i en labyrint. När man klarat alla dessa "fetch quests" är spelet slut. Målet är att klara det på så få förflyttningar som möjligt. Trots enkelheten tycker jag att spelet innehåller några spännande features som är värda att peka på:
* Dynamiskt genererad labyrint med slumpmässigt placerade rum och dörrar.
* Dynamiska quests. Prylarna placeras i slumpmässiga rum och mål-rummet väljs också slumpmässigt.
* Välj själv hur många quests du vill lösa under spelomgången.
* Lägg till och ta bort rum via ett enkelt api, spelet använder de rum som finns för att generera labyrinten.

För dig som rättar finns en "show hint"-knapp som visar hur du löser questen på snabbaste sätt. Stylingen är i retro-stil som jag tycker passar bra för ändamålet.

Under huven använder spelet MVC-mönstret som varit fokus under kursen, med så lite logik som möjligt i kontrollern och vyerna. Jag började med att göra ett övergripande flödesschema och sedan var det bara att implementera:

![Flödesschema](/img/proj_flowchart.png)

Det mesta är straight forward med olika klasser för olika uppgifter:
* AdventurGame-klassen håller ihop spelet och agerar "publikt api" för kontrollern. Kontrollern använder enbart denna klass. 
* DoorGenerator-klassen innehåller kanske den mest spännande koden - mer om det längre ner. Uppgiften är att skapa dörrar mellan de olika rummen på kartan och där med skapa en labyrint.
* ItemDistributor-klassen placerar ut items slumpmässigt i de olika rummen.
* Map-klassen genererar spelkartan, sätter startrum och håller koll på vilket rum spelaren befinner sig i.
* Player-klassen ansvarar för spelarens information och inventory.
* Quest-klassen innehåller information om respektive quest och om den är avklarad eller inte.
* QuestHandler-klassen generar quester utifrån items och rum och uppdaterar questernas status.
* Room och Item finns som entity-klasser. Till rummen finns en RoomTrait som lägger till övrig funktionalitet som behövs för rummet, till exempel dörrar och items.

Alla landningssidor är på plats med rätt innehåll, repot innehåller den förväntade informationen och innehållet i docs/ är uppdaterat. Kodtäckningen på src/proj/-mappen där min spellogik finns är 100%, men jag valde att inte göra tester på kontrollern.

#### Krav 4
Jag valde att implementera ett API för att hantera innehållet i spelet, det vill säga rum och items. Det är möjligt att hämta, lägga till, uppdatera och ta bort rum och att hämta, lägga till och ta bort items. I kraven står det att det ska vara möjligt att "klicka på samtliga länkar/knappar för att testa ditt API". Detta fungerar med hämta rum/items men jag bedömde att det inte var rimligt att fixa den funktionaliteten för övriga ingångar (efter att också haft kontakt med Mos om det). [Här finns länkar till get-ingångarna samt exempel på curl-kommandon för att testa övriga ingångar](/proj/about/api) (/proj/about/api). fill-db.bash-scriptet använder också api:n för att lägga till rum och items. 

Lösningen i sig är enkel med en kontroller som använder respektive Repository för att ändra i databasen. Innehållet i spelet är alltså inte hårdkodat utan lösningen innebär att administratören för spelet kan hantera, förändra och lägga till innehåll utan att behöva publicera en ny build av spelet. 

#### Krav 5
Databasen (SQLite) används som sagt för att spara innehållet i spelet. Det finns en tabell för rum och en tabell för items. Däremot finns det ingen koppling mellan tabellerna. Kopplingen mellan rum och items, till exempel vilket rum ett item finns i, hanteras dynamiskt när spelet laddas. Man hade kunnat tänka sig att utveckla databasen genom att lägga till information om spelaren, till exempel spara high score eller sessioner/spelstatus så att spelaren kan gå tillbaka även om sessionen löpt. Lösningen fungerar på det sätt som är tänkt.

#### Krav 6
Jag tycker det är svårt att titta på sin lösning och peka ut vissa saker som svåra, det mesta känns självklart när det väl är färdigt. En liten detalj som jag inte vet om den är svår, men som jag i alla fall är nöjd med, handlar om strukturen på koden. Jag ville att mina Entity-klasser skulle vara så rena som möjligt, att de bara skulle hantera databasen. Samtidigt krävde Room-klassen mer funktionalitet. Min första iteration innebar att jag hade en entitet RoomInfo och en Room-klass, men sedan kom jag på att utöka funktionaliteten i entiteten med en trait istället. Så nu har jag en entitet Room och en RoomTrait som lägger till funktionalitet för inventory och dörrar. Mycket snyggt tycker jag.

En annan grej som tog rätt mycket tid men som jag är väldigt nöjd med är testerna. Här handlar det om mängden mockning som krävdes för att kunna testa varenda liten rad - vilket jag lyckades med. En lösning som jag tycker är bra är att skapa en mock-klass som ärver den riktiga klassen (t ex i AdventureGame-klassen), där jag skapat metoder för att kunna byta ut olika instanser av klasser mot mocks. Fungerar riktigt bra. Det enda att tänka på är att variablerna i grundklassen behöver vara protected, inte private. 

Men det jag jobbat och kämpat absolut mest med är genererandet av labyrinten. Så här i efterhand kanske det var en onödig feature som tog mycket tid, men jag kände redan från början att jag ville ha en slumpmässig labyrint och då fick det bli så. Min första iteration byggde på att jag loopade igenom hela rum-griden, lade till dörrar om rummen runt omkring hade dörrar, och eventuellt någon extra beroende på en random-roll. Problemet här var att jag inte fick till ett bra värde på random-rollen - med för lågt värde uppstod problemet att vissa rum inte alls blev tillgängliga, med för högt värde blev det för många dörrar för att kunna kallas en labyrint. Efter en hel del research hittade jag sedan Depth-First Search-algoritmen som jag implementerade för att bygga labyrinten. Implementeringen innebär att jag bestämmer ett slumpmässigt startrum, väljer ett grannrum som inte tidigare besökts slumpmässigt, skapar dörrar, och fortsätter sedan från grannrummet rekursivt. Om det inte finns några obesökta grannar går den tillbaka till tidigre rum tills det finns ett rum med ett obesökt grannrum, och kör vidare därifrån. Resultatet är att alla rum besöks och att dörrar skapats så att det bildas en labyrint där alla rum är tillgängliga.

#### Till sist
Sammanfattningsvis tycker jag att projektet varit jätteroligt och stundtals utmanande. På grund av jobb och barn hann jag inte klart innan sommaren, och sedan kom semestern i vägen, vilket gjorde att jag blev klar sent och gör att jag känner att jag jobbat länge med det. Min idé om slumpmässighet lade också till tid (men där får jag ju skylla mig själv). Jag tycker ändå att omfattningen på projektet kändes rimlig. Det svåraste var som sagt att få till slumpmässigheten, övriga delar tycker jag att kursen förberett oss väl på och handlade mest om att bara implementera. 

Jag tycker precis som om tidigare kurser att denna kurs varit toppen. Tycker inte det kunde vara bättre anpassat för distansstudier. Bra föreläsningar, bra och snabb handledning i discord, inga fasta tider dagtid som man måste vara med på. Perfekt. Jag gillar verkligen PHP, tycker det känns jättekul, men jag undrar samtidigt hur relevant det är... när jag pratar med folk känner jag ofta att jag får skämmas lite över att plugga php i dessa tider, och det är väldigt få jobb-annonser där php efterfrågas. Samtidigt är ju design/arkitekturella mönster och programmeringstekniker universella, andra språk är ju bara att lära sig. Jag rekommenderar absolut andra att gå kursen - 9/10.
