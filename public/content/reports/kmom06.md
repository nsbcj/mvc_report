##Kmom06 {#kmom06}
###Phpmetrics
Verktyget har varit användbart. Det uppfattas smidigt att det både genererade en rapport och en utskrift i terminalen. Avseende mätvärdena uppfattas de täcka flera delar av uppgiften.

Trots jag använt den genererade html-rapporten, uppfattades termninalutskriften som tillräcklig. Den gav en snabb översikt avseende snittvärden. Det gick smidigt att hitta de mätvärden som var intressanta för uppgiften. Gällande mätvärden för komplexitet, cohesion och coupling, uppfattas de mätas på ett bra sätt av verktyget.

###Scrutinizer
Det var lite struligt att komma igång med Scrutinizer. Efter att ha uppdaterat config-filen löstes några problem, men det stora problemet verkade varit att Scrutinizer initialt använde en version av Node som inte var kompatibel med min kod. Det tog ganska lång tid innan jag förstod att Node-versionen gick att specificera i config-filen.

När allt kom igång och rapporten kunde genereras, uppfattades mätvärdena som lättöverskådliga. En fördel är att rapporten ger bra återkoppling rörande de "issues" som finns i koden. Rapporten är utformad på ett sådant sätt att flera issues har kunnat åtgärdas på ett smidigt sätt. Avseende Scrutinizers badges var det framförallt kodkvaliteten som uppfattades bra att få koll på. Den uppfattades redan från början vara ok, då den nästan var 10 från start. 9,9675 (avrundad till 9,7) står det vid kontroll av värdet kopplat till de första analyserna. Den första mätningen av kodtäckningen var 27,45% (avrundat till 27%).

###Syn på kodkvalitet
En hög kodtäckning uppfattas vara en indikation på att koden är genomarbetat och att den fungerar. Sedan uppfattas detta även vara beroende av hur testerna är skrivna. I flera fall finns det behov att göra flera typer av assertions kopplade till metoder. Kodtäckning för en metod kan uppnås genom skrivande av en assertion. Detta innebär dock inte alltid att en metod är fullständigt testad, då det kan vara begränsade delar av metod som utvärderas. Det skulle vara bra att ha ett verktyg som även utvärderar testernas kvalité.

Scrutinizers badges och betygsättning uppfattas ge tydliga riktvärden för hur kodkvalitén är. Det var gick att identifiera klasser och metoder med avvikande kvalitét, varvid det var smidigt att ändra rätt delar av koden.

Phpmetrics rapport gav även den bra indikationer på kodkvalitet.

De klasser som uppfattades som mest problematiska, vilket var controllerklasserna, identifierades av både Scrutinizer och phpmetrics.

Sammanfattningsvis framstår kodkvalitet som en viktig del av programmering. Att skriva kod som är enkel att förstå gör den enklare att underhålla. Detta uppfattas göras genom att undvika krångliga konstruktioner samt att dela upp koden i många klasser. Jag hoppas kunna skriva fler och bättre klasser under projektet.

###TIL
Den del som var svårast, och som jag lärt mig mest om, var uppstarten av Scrutinizer. Under kursens gång har vi arbetat med en del config-filer, men detta kursmoment var nog det första som krävde flera ändringar i en sådan. Filen .scrutinizer.yml fick ändras ett par gånger innan miljön kopplad till Scrutinizer kom igång. Jag tror att problemlösningen till detta gjort att jag börjar förstå hur och varför config-filer används. Det hade varit intressant att lära sig ytterligare om hur container-miljöer fungerar.

Det var flera delar i kursmomentet som var nya för mig. Att läsa och tolka de olika mätvärdena var en av delarna.

Sammanfattningsvis uppfattas kursen ha givit en bred introduktion till hur man kan arbeta med ramverk, objektorientering och testning.
