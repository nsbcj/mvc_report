##Kmom01 {#kmom01}
###Tidigare erfarenheter av objektorientering
Objekt-konstruktioner har använts i tidigare kurser. Konceptet objektorientering inkluderades i en av de Python-kurserna i det andra kurspaketet. I kursen berördes grundläggande delar som konstruktor, arv och komposition. Kursen berörde även att modellera program, för att visualisera relationer mellan objekt. Jag tror att objektorientering i PHP kommer innehålla en hel del nyheter. Under första kursmomentet har en del sådana nyheter berörts, såsom ```->``` istället för ```.``` för att nå properties och metoder i klasser.

###PHP:s modell för klasser och objekt
Det grundläggande är att varje ny instans av en klass, skapar ett objekt. En klass innehåller medlemsvariabler (properties) och metoder. Vid skapande av ett objekt utifrån en klass, skapas alltid specificerade properties och metoder i objektet. Det finns likheter med klasser i andra språk jag läst, framförallt med Python. En instans av en klass kan skapas med hjälp av en konstruktor, som möjliggör att properties tillhörande en ny instans kan skapas vid instansieringen. En annan del som känns igen är att medlemsvariabler och metoder kan vara publika eller privata. Privata delar kan inte nås på samma sätt som publika. Syftet med detta är att inte visa de delar av klassen som användare inte ska kunna påverka.

###Kodbas, koden, strukturen i uppgiften me/report
Det tog tid att komma igång med uppgiften. Jag har inte  någon erfarenhet av Symfony. Jag läste en del manualer för att få delarna på plats, mestadels rörande användande av Markdown och JavaScript.

Gällande användande av controllers och vyer gick det ganska smidigt att förstå konceptet. Det nya var framförallt användande av namespace och syntaxen gällande routes. I övrigt, avseende strukturen i Symfony, känns det som att det finns mycket att läsa om. Det krävdes en del att förstå de grundläggande delarna, men jag hoppas att det blir tydligare under kursens gång. Bara att få JavaScript och Markdown att fungera på önskat sätt var en utmaning.

###PHP The Right Way
 [Artikeln](https://phptherightway.com/#welcome) känns som en bra översikt av PHP. Den rör flera områden som uppfattas nyttiga att använda längre fram i kursen. I nuläget kändes många delar avancerade. Exempelvis delarna rörande dependency och virtualization. Felhantering och testning är en delar jag ser fram emot att återkomma till längre fram i kursen. Kopplat till detta kursmoment uppfattas avsnitten om templating, PHPDoc och language highlights som intressanta. Slutligen tror jag att den avslutande delen, som beskriver olika resurser kopplade till PHP, kan komma till användning under kursens gång.

 ###TIL
 Att komma igång och börja använda ramverket har krävt mycket tid. Den del jag lade mest tid på var att implementera JavaScript på lucky-number routen. Det tog tid innan jag förstod att man inte kunde kalla på en JavaScript funktion inuti en Twig-fil. Lösningen blev en funktion som startas beroende av vilka klasser som finns på den visade sidan. I detta läget tror jag att ett JavaScript-baserat ramverk hade erbjudit en smidigare lösning på problemet.

 En fördel med att det varit lite komplicerat att komma igång med JavaScript-delarna har varit att jag börjar få koll på hur npm används i Symfony. När npm var igång kändes det ganska smidigt att göra stylen i ```.scss```-filer.

 Det ska framöver bli intressant att arbeta vidare med PHP.
