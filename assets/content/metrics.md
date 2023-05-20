[Metrics]

### Introduktion



#### Coverage
Coverage handlar helt enkelt om hur stor del av kodbasen som täcks av tester. Det säger egentligen ingenting om huruvida det är rätt eller bra tester, men man kan ändå se det som någon form av positiv signal: jag utgår i alla fall från att en person som satt sig och gjort tester för att uppnå en hög täckning också har försökt göra ett bra jobb med testera. Men någon garanti finns så klart inte. Sammanfattningsvis: positiv signal men ingen garanti för kvalitet. Min coverage innan förändringar i koden ligger på 28 procent.

#### Complexity
Cyklomatisk komplexitet beskriver hur många "vägar" det finns genom koden. Om en funktion enbart returnerar ett värde så är den cyklomatiska komplexiteten 1, med en if-sats ökar komplexiteten till 2 och så vidare. Som jag ser det är det alltid en god idé att försöka minska komplexiteten och jag tycker att man ska sikta på högst 3-4 för en funktion. För en klass blir komplexiteten naturligtvis högre - men mindre är alltid positivt enligt min mening. Med det sagt betyder det inte att komplexiteten alltid kommer att vara låg, viss kod är helt enkelt mer komplex än annan kod. När jag tittar på min PHPMetrics ser jag att Game-klassen har en komplexitet på 25, vilket är högre än önskvärt. I Scrutinizer 32. Å andra sidan är genomsnittet för klasserna 6,5 i PHPMetrics vilket känns bra. För metoderna ligger ett par metoder på 8-9 enligt PHPMetrics, vilket bör åtgärdas. Game::calculatePoints-metoden har enligt Scrutinizer en komplexitet på 7, vilket känns mycket.

![Complexity](img/metrics_1.png)

Jag tolkar det som att när man pratar om komplexitet så hndlar det främst om den cyklomatiska komplexiteten. Men det finns ju också andra parametrar, programmets längd och så vidare, "halstead complexity measures". Jag tycker dessa känns svåra att förstå och tolka. Jag konstaterar att det finns siffror i PHPMetrics-rapporten som kommer från dessa, t ex Bugs. Jag tror att man kan använda dessa siffror på ungefär samma sätt som övriga värden, det är en aspekt att ta hänsyn till och titta på men ingen saninng.

En annan aspekt är maintainabilitity index som bakar ihop cyklomatisk komplexitet, halstead, längden på källkoden och antalet kommentarsrader och ger ett index för hur lätt koden kan förväntas vara att underhålla.

#### Cohesion
Cohesion beskriver hur väl en modul hänger ihop och hur många olika saker en modul vill göra. Med en hög cohesion hänger metoderna i klassen ihop och utför enbart saker som har med klassens syfte att göra. Klassen har inte två syften. Om klassen ska hantera betalningar så ska den inte samtidigt hantera lagersaldot. Lack of cohesion of methods (LCOM) är ett mått som beskriver graden av cohesion. Ett LCOM på 1 är det ideala och innebär att klassen bara har ett ansvarsområde. Ett LCOM på 5 innebär att klassen har 5 ansvarsområden.

När jag tittar på min kod innan några ändringar så noterar jag att min UtilityService-klass har ett LCOM på 5, vilket innebär att den har många olika ansvarsområden. Det är naturligtvis inte idealt, men samtidigt är den mest en behållare som jag kan injecta för att få tillgång till olika fristående metoder. Jag är okej med det värdet. Men jag väljer att hålla koll på det och är redo att refaktorera den när antalet metoder växer.

Min LibraryController och BookRepository har ett värde på 3, GameController och Deck har 2. I övrigt har klasserna 1 i LCOM vilket är bra. Genomsnittet ligger på 1,39.

![Cohesion](img/metrics_2.png)

#### Coupling
Coupling beskriver hur olika moduler hänger ihop, genom att de beror på eller använder varandra. Här finns två perspektiv, efferent coupling som mäter antalet klasser som den aktuella klassen har ett beroende till, och afferent coupling som mäter hur många klasser som har ett beroende till den aktuella klassen. Man kan också prata om ett instabilitetsindex som beskriver risken för att något ska gå sönder om man ändrar i klassen. Det räknas ut genom att dividera efferent coupling med den totala couplingen (efferent + afferent). Ett värde på 1 betyder att klassen är väldigt instabil medan ett värde på 0 betyder att den är väldigt stabil. 

Precis som det brukar vara med index av olika slag så tänker jag att man ska hantera det med varsamhet. Det är inte ett självändamål att nå 0 i instabilitetsindex - utan det är en del av en sammanvägd bedömning. Det är inte konstigt om min Game-klass har en hög instabilitet, hela poängen med den klassen är att samla ihop kod och klasser för 21-spelet, den kommer bero på och ha beroenden till andra klasser. Card-klassen bör ju dock inte ha en lika hög instabilitet.

![Coupling](img/metrics_3.png)

#### CRAP
CRAP-score är ett mått på hur mycket tester som skulle krävas för att fixa komplexa metoder/funktioner. En CRAP-score på X innebär att det krävs X testcoverage för att fixa till metoden. CRAP relaterar till komplexitet - ju mer komplex kod desto fler tester krävs. En CRAP-score över 30 anses inte acceptabel. Enligt min kod har CardGame::dealCards-metoden en CRAP-score på 56, vilket innebär att det krävs en test-coverage på 56% för att den ska lämna CRAP-territoriet.

![CRAP](img/metrics_4.png)

#### Codestyle
För kodstilen finns det inget specifikt mätvärde eller index utan härhandlar mer om att ha en konsekvent kodstil som gärna följer en allmänt accepterad standard. På så sätt borgar man för att koden blir lätt att underhålla och att hanteras av andra. För mig handlar det mycket om att koden ska vara läsbar, att variabler har självförklarande namn, undvika för många intabbningar, else-satser och sådana saker. Man kan få mycket god hjälp av linters, statisk kodanalys etc för att upprätthålla sin kodstil. Jag skulle säga att det alltid är en god idé att köra den typen av verktyg.

### Phpmetrics
Det första som slår mig är att jag hr sex "violations", vilket verkar vara särskilt viktiga varningar. Här finns tre varningar: 'Blob/god object', 'Probably bugged' och 'Stable abstraction principle'.

![Violations](img/metrics_5.png)

Jag tror att LibraryController-klassen får god object-varningen på grund av antalet metoder i klassen. Jag ser dock inte det som ett problem i just mitt fall. Lite osäker på varför BookRepository-klassen får varningen. Game-klassen har en **varning om probably bugged**, vilket är en sammanvägd bedömning utifrån klassens komplexitet. Det betyder inte att den är buggad, men att komplexiteten i klassen gör att det är stor risk för buggar. **Här kan man nog förbättra en hel del**.

![Maintainability/complexity](img/metrics_6.png)

Jag konstaterar också att Game-klassen både har **hög komplexitet och ett lågt maintainability-index. Här finns också potential för förbättring**. Den har dessutom ett högt **instabilitets-index på 0,86 vilket också bör åtgärdas**. 

Totalt sett verkar det som att PHPMetrics pekar på Game-klassen som det enskilt största förbättringsområdet i min kod.

### Scrutinizer
Till skillnad från PHPMetrics som hade stora röda bubblor och violations, så applåderar Scrutinizer med ett betyg på 9,94. 

![Scrutinizer grade](img/metrics_7.png)

Det verkar inte som att Scrutinizer tittar på Halstead complexity measures på samma sätt som PHPMetrics. Alla klasser och metoder förutom metoder två har betyg A.

![B methods](img/metrics_8.png)

Anledningen är komplexiteten på 7. CRAP-scoren på Game::calculatePoints är betydligt lägre än för CardGame::dealCards, vilket beror på att jag inte skrivit tester för CardGame-klassen. **Jag bedömer att komplexiteten på båda metoderna borde kunna minskas till åtminstone 5**. **Med tanke på CRAP-scoren för CardGame::dealCards vill jag också skriva tester för metoden**.


### Förbättringar
Med tanke på diskussionen ovan så vill jag förbättra följande:

* Minska instabilitets-index på Game-klassen genom att använda dependency injection. Värde innan förändringar i kod: 0,86.
* Minska komplexiteten på Game::calculatePoints-metoden genom att minska antalet beslutspunkter i koden. Jag tror att man kan göra detta genom att skriva om/refaktorera. Värde innan förändringar i kod: 7.
    * Detta kommer förhoppningsvis också minska "expected bugs" på hela klassen.
* Minska komplexiteten på CardGame::dealCards-metoden på samma sätt (0,52 innan förändringar i kod).
* Skriv tester för CardGame::dealCards-metoden för att komma till rätta med CRAP-scoren. Värde innan förändringar 56.


### Diskussion