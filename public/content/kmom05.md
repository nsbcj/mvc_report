##Kmom05 {#kmom05}
###Symfony och Doctrine
Det tog lite tid att komma igång med Doctrine. Det krävdes en del läsande av manualer och instruktioner för att förstå grunderna. Jag fick initialt problem kopplat till att jag glömt lägga till kolumnen för bildlänken i databasen. Efter en tid sökande, hittades en lösning som verkar fungera bra. Ett annat problem som uppstod i samband med lintningen, var att vissa kolumnnamn genererade felmeddelande. Ett av kolumnnamnen, som i php-koden var variabelnamn, var $id. Jag hittade inget bra sätt att korrigera felet rörande $id-variabeln, då jag fick felmeddelande när ändringar gjordes.

Övningen uppfattades sammanfattningsvis som bra och gav en bra grund till att använda Doctrine.

###Library-applikationen
Tanken var initialt att få ihop delarna i CRUD. Efter att ha skapat index-sidan, skapades formulär för att lägga till innehåll i databasen. När create-formuläret var på plats, skapades sidan för att läsa innehållet från databasen. När innehållet i databasen kunde läsas och visas på en sida, lade jag till möjligheten att via bokens titel komma till en sida som enbart visade vald bok. Slutligen lade jag till länkar för att uppdatera respektive ta bort de visade böckerna.

Min grundläggande tanke har varit att länkar till sidor som visar innehåll görs med GET-requests. I formulär som används för att lägga till, uppdatera eller ta bort innehåll, används POST-requests.

Jag har försökt använda en liknande design för sidor på webbplatsen. På routen /library finns två länkar; en för att skapa ny bok och en för att visa alla böcker. På sidan som visar alla böcker kan man sedan välja att uppdatera, ta bort eller visa en bok.

###ORM i CRUD
Det var en ny erfarenhet att arbeta med ORM i CRUD. Efter att ha läst databaskursen kändes det som ett förenklat sätt att arbeta mot en databas. Det krävdes en del konfiguration att komma igång, men kändes ganska smidigt när allt var igång. Koden som skrevs i controllern upplevdes kort och koncis. Att inte behöva skriva några längre sql-queries är smidigt. Att arbeta med databasinnehållet som objekt kändes som ett bra sätt att skapa enhetlighet i koden. Om man jämför exempelvis med användande av lagrade procedurer, kändes det som att det blev betydligt färre rader kod.

###Uppfattning om ORM
Som jag skrivit ovan tyckte jag att ORM var ett smidigt sätt att arbeta mot databaser. Det som möjligen upplevs som en nackdel är att konfigurationen krävde lite tid. Förmodligen kommer jag behöva läsa manualen för konfigurationen vid fler tillfällen.

Då jag missade att lägga till bildlänkar i databasen vid tillfället då tabellen skapades, fick jag läsa lite extra om hur man förändrade tabeller efter att de skapats. Detta ledde till att jag fick skapa nya migrationer, vilket ledde till ytterligare felhantering. Felhanteringen ledde till ytterligare förståelse om Doctrine, framförallt kopplat till migreringen.

Sammanfattningsvis uppfattades ORM som ett bra sätt att integrera arbete mot en databas i projektet.

###TIL
Mycket kopplat till ORM och Doctrine var nya erfarenheter. Det är intressant att lära sig nya delar och jag upplever att jag fått lägga en hel del tid på att förstå grunderna. Det har framförallt varit en utmaning att förstå hur Doctrine skriver saker i databas-filen och hur man kan konfigurera saker kopplade till detta. Jag upplever att jag fortfarande har mycket att lära kopplat till detta. Uppgiften var en bra introduktion och jag tänker att det var nyttigt att erfara felhantering kopplat till implementationen av applikationen.
