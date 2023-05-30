##Beskrivning av tabeller
###Players-tabell
Tabellen innehåller kolumner för att spara spelarnamn ("name") och spelarens kontobalans ("balance").

###Stats-tabell
Tabellen innehåller kolumner för att spara antalet spelhänder ("hands"), antalet vunna spelhänder ("wins"), antalet spelhänder som slutade lika ("ties"), den totala insatsen per spelrunda ("totalbet") samt den totala vinsten per spelrunda ("totalreturn").

##Relationer mellan tabeller
Det finns inga relationer mellan de båda tabellerna.

##Typ av databas
Databasdelen av projektet är genomförd på samma sätt som i tidigare kursmoment. Det är Sqlite som används som databas. Tabellerna är tillagda i den databas-fil som skapades tidigare i kursen.

##Enhetstester mot databasen
Jag har inte gjort enhetstester mot databasen.

##ORM i förhållande till databaskursen användande av databas
En av de upplevda fördelarna med ORM är att det uppfattas synkronisera väl med objektorientering i övrigt. Det är ett tankesätt som känns igen och det uppfattas nu någorlunda intuitivt att läsa/skriva från/till databasen. Det gick förhållandevis fort att komma igång med ORM-uppgiften i projektet.

En nackdel jag tidigare nämnt är problematiken att förstå hur Doctrine skulle startas och integreras i ramverket. Vid detta tillfälle, under projektet, gick det avsevärt smidigare att komma igång. Det uppfattades även smidigt att lägga till databas-delen på ändamålsenliga platser i Controllerna. I mitt projekt rörde det sig mestadels om uppdateringar av befintliga Controllers.

En nackdel som uppfattades i projektet är att frågor eller procedurer som är komplexa verkar svårare att lösa med ORM. Jag har i projektet gjort en del aggregation av information som troligen kunde lösts bättre genom användande av procedurer eller funktioner i SQL. Jag är fortfarande inte helt säker på vad som är "best practice", men min användning av ORM har varit begränsad till att hämta och sätta data.

Sammanfattningsvis är min uppfattning att det sätt vi arbetade mot databaser i databaskursen kan användas för projekt där det krävs mer avancerat med databasen. ORM har uppfattats som ett smidigt sätt att integrera databasen med ramverket Symfony. Behovet av databasen i projektet har till stor del bestått i att spara undan data på ett fåtal platser. I det avseendet har ORM varit ett bra sätt att arbeta mot databasen. De begränsningar som uppfattats i förhållande till tidigare erfarenheter av databashantering är förmågan att skriva funktioner, procedurer och liknande.

[Om projektet](../about){.button}
