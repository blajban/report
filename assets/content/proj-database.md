### Om databasen

Jag har använt SQLite, dels för att det kändes enklast, dels för att det uppfyllde alla syften.

Databasen används för att spara information om innehållet i spelet, det vill säga rum och items som används för questerna. Då världen i spelet byggs upp dynamiskt hanteras också relationerna mellan rum och items i själva spelet, t ex att en item finns i ett visst rum. Det innebär att tabellerna för rum och items inte har någon relation till varandra.

room-tabellen sparar information om respektive rums id, namn, beskrivning och bild. item-tabellen sparar information om respektive items id, namn och beskrivning.

![ER-diagram](../../img/proj_er.png)


Jag har inte gjort enhetstester mot databasen.

I kursen har vi använt ORM vilket känts väldigt bra. Jag tycker att ORM tar bort lite av komplexiteten om man jämför med att använda SQL-queries direkt. Det blir mer "programmering" vilket gör att i alla fall jag kan jobba snabbare med ORM. En annan fördel som jag förstått det är att man kan byta den underliggande databasen utan att påverka sin kod. Det är ju oftast möjligt även annars men vissa detaljer kan skilja sig från databas till databas. Det var också väldigt eknelt att komma igång med databas-scheman. Nackdelarna är väl till exempel att man går miste om ett visst mått av kontroll, med sql-queries kan man styra varenda liten detalj själv. Det kan också kräva mycket arbete att uppdatera queriesarna (och större risk att förstöra något...). Men den största nackdelen med SQL-queries för mig är nog nivån av kunskap som krävs - ORM känns helt enkelt mycket mycket enklare.
