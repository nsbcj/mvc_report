##Introduktion
Detta är en redovisningstext till uppgiften rörande analys och förbättring av kodkvalitet. Uppgiften bygger på att verktygen phpmetrics och scrutinizer använts för att analyser den kod jag skrivit under kursen. Rapporterna från verktygen ligger till grund för den analysen i denna uppgift.
###Mättal
Analysen av koden ska utgå från sex mätvärden: Codestyle, Coverage, Complexity, Cohesion, Coupling och CRAP. Nedan ska jag kort beskriva vad de mätvärdena representerar.
####Codestyle
I [föreläsningen](https://www.youtube.com/watch?v=T3nK2ppTru4) kopplad till kursmoment 6 uppfattar jag att codestyle beskrivs vara kopplad till kodens syntax. Alltså om koden uppfyller eller inte uppfyller de kodstandarder som är uppsatta för ett språk. Under kursmomentet har vi använts `composer csfix` för att korrigera eventuella fel kopplade till detta. `composer lint` har sedan använts för att upptäcka ytterligare fel i koden.
####Coverage
Kod-täckning, eller covarage, har i kursen varit kopplat till kommandot `composer phpunit`. Det mätvärde som returnerats motsvarar hur stor del av koden som täcks av enhetstester. I tidigare kursmoment har jag skrivit enhetstester till delar av den kod som skrivits, varvid testerna endast täcker en begränsad del av den totala kodbasen. Mätvärdet returneras ett procenttal mellan 0 - 100.
####Complexity
I föreläsningen Software quality metrics, se [underlaget](https://dbwebb-se.github.io/mvc/lecture/L06-static-code-analysis-and-metrics/slide.html), är complexity ett av flera nämnda mätvärden. Det beskrivs kopplat till begreppet `Cyclomatic complexity`, som beskrivs vara ett mätvärde som används för att mäta ett programs komplexitet. Det returnerade mätvärdet ska, enligt beskrivning i [artikel](https://en.wikipedia.org/wiki/Cyclomatic_complexity) på Wikipedia, vara under 10 för att betraktas som enkla procedurer. Nivåerna för mätvärder kopplade till komplexitet är enligt artikeln: 1-10, 11-20, 21-50 och över 50. Jag tolkar det som att låga värden är bra, med liten komplexitet, och att höga värden innebör högre komplexitet. En komplexitet över 50 beskrivs i artikeln vara ostabil kod med mycket hög risk.
####Cohesion
I föreläsningen rörande Software quality metrics, nämnd ovan, beskrivs även begreppet cohesion. Begreppet beskrivs även i en [artikel](https://en.wikipedia.org/wiki/Cohesion_(computer_science)) på Wikipedia. Min uppfattning är att mätvärdet exempelvis kan beskriva hur väl klassmetoder används i förhållande till data som ska användas i klassen. I föreläsningen beskrivs det som att en klass som uppfyller ett syfte har hög cohesion. Min uppfattning av detta är att det kan vara positivt om en klass har flera metoder, så länge varje metod har ett eget ansvar inom klassen och att klassen har ett syfte. I våra projekt har är Card och CardHand exempel på klasser som hör ihop, men var för sig har metoder som framförallt syftar till att skapa funktionalitet inom den egna klassen.

Det värde som genereras av phpmetrics avseende cohesion är Lack of cohesion of methods (LCOM). Enligt föreläsningen är det ett värde på hur många ansvarsområde klassen har. Det ideala är att klassen endast har ett ansvarsområde. Ju fler ansvarsområde (högre mätvärde) desto sämre är cohesion-värdet.
####Coupling
Coupling-värdet beskrivs i föreläsningen, se ovan nämnt underlag, i vårt fall vara beroende av kopplingar mellan klasser. Det beskrivs vara föredraget att ha fåtal kopplingar mellan klasser. I phpmetrics beskrivs några olika mätvärden kopplade till coupling; Average afferent coupling, average efferent coupling, average instability och depth of inheritance tree. Med föreläsningsmaterialet i beaktande uppfattas average efferent coupling vara ett genomsnittsvärde för hur många klasser den genomsnittliga klassen är beroende av. Average afferent coupling uppfattas å andra sidan mäta hur många klasser som är beroende av en genomsnittlig given klass. I föreläsningsmaterialet beskrevs instabilty-index som ett värde mellan 0 och 1, där 0 representerar stabilt och 1 väldigt ostabilt.

Kombinationen mellan ett lågt coupling-värde och ett högt cohesion-värde beskrivs i föreläsningsmaterialet som positivt.
####CRAP
I föreläsningsmaterialet beskrivs CRAP-värdet som en uppskattning av hur många tester som behövs skrivas för att kodbasen ska vara på en godtagbar nivå. Det beskrivs finnas ett samband mellan den cyklomatiskt komplexiteten och kodtäckning. Lägre Cyklomatisk komplexitet kräver mindre antal tester, det vill säga färre tester. Om komplexiteten däremot är hög, krävs enligt föreläsningsmaterialet fler tester.

CRAP uppfattas vara ett riktvärde för vilken kodtäckning som bör överstigas vid de olika nivåer av cyklomatisk komplexitet.
##Phpmetrics
###Codestyle
Angående godstil har jag inte hittat något bra ställe att kontrollera eventuella fel i phpmetrics. Under rubriken "Violations" nämns att det finns fem violations. Min uppfattning är att violations snarare rör utformning av klasser än syntax-fel. Ett exempel på en violation är att klassen ApiControllerJson har en hög LCOM, Lack of Cohesion.

Delar av kodstilen har hanterats genom kommandot `composer csfix` och rättning av fel som uppkommit när kommandor `composer lint` körts.
###Coverage
Rubriken "assertions" visar antalet assertions som noterats vid analysen. Siffran vid första testet var 50 assertions. Vid vidare kontroll noterades att testerna täcker åtta klasser och att 16 av klasser saknar tester.

I sammanhanget visar phpmetrics den cyklomatiska komplexiteten för de otestade klasserna. Detta uppfattar jag som en indikation på vilka klasser som skulle behöva testfall. Klasser med cyklomatisk komplexitet under fem beskrivs inte ha krav på kodtäckning enligt tabellen rörande CRAP i [föreläsningsmaterialet](https://dbwebb-se.github.io/mvc/lecture/L06-static-code-analysis-and-metrics/slide.html). Detta innebär att jag enligt kodtäckningsrapporten borde skriva tester för ytterligare ett antal klasser.
###Complexity
Den cyklomatiska komplexiteten är ett riktvärde för kodens komplexitet enligt beskrivningen ovan. Enligt phpmetrics analys är min kods genomsnittliga cyklomatiska komplexitet 4,38. Att värdet är under 10, innebär att koden övergripande kan bedömas bestå av enkla procedurer.

Klassen med högst cyklomatisk komplexitet är LibraryController, som har värdet 16. De tre klasser med högst cyklomatisk komplexitet är Controller-klasser. CardGame, klassen som används för att styra kortspelet, är på plats fyra och har 9 i komplexitet.
###Cohesion
Phpmetrics returnerar värdet LCOM, som är beskrivit ovan. Med bakgrund av vad som beskrivs i föreläsningsmaterialet uppfattar jag att värdet ska vara så när ett som möjligt. Det högsta LCOM värdet har klassen ApiControllerJson, som har värdet sex. Detta indikerar att klassen har för många ansvarsområden. Denna klass följs av ProductController och CardGame, som har värdet fyra respektive tre.

Sammanfattningsvis tror jag att det genomsnittliga LCOM-värdet är relativt bra, 1,63. Det innebär enligt min uppfattning att en genomsnittlig klass i min kodbas har 1,63 ansvarsområde.
###Coupling
####Afferent coupling
Den klass som flest andra klasser är beroende av är klassen DeckOfCards. Den har värdet sex, vilket jag tolkar som att de används av sex andra klasser. Likaså är CardHand en klass som används av flera, fem, andra klasser.

####Efferent coupling
Å andra sidan är ApiControllerJson den klass som använder sig av flest andra klasser, åtta stycken. Controllers är de klasser använder sig av flest andra klasser. Även CardGame, är en klass som använder sig av många andra klasser.

####Instabilty
Samtliga controllers har värdet 1 i instabiliy. De betraktas därmed som väldigt instabila klasser. CardGame har även den ett högt värde, 0,83. Två klasser som har låg instability är DeckOfCards och CardHand. Även klassen Card uppfattas vara stabil.

###CRAP
Jag har inte hittat något specifikt värde för CRAP-score i phpmetrics rapport. Av de klasser som testas, är det inga som har en cyklomatisk komplexitet över 10, vilket jag tolkar som att kravet på antalet tester på dessa klasser är lågt. Då kodtäckningen på de testade klasserna är 100%, uppfattas testernas omfattning i detta avseende som tillräckliga. Kopplat till den cyklomatiska komplexiteten uppfattar jag att LibraryController, CardGameController samt ApiControllerJson är de klasser som är i störst behov av tester.

###Svaga punkter i min kod
Övergripande är antalet testade klasser en svaghet i min kod. Det är endast åtta klasser som testar, varvid kodtäckningen kan betraktas som en svaghet.

En specifik klass som pekas ut under rubriken "violations" är ApiControllerJson. Den hanterar för många områden och har därmed ett högt LCOM-värde, vilket nämns ovan. Rekommendationen från phpmetrics är att dela klassen i flera subklasser.

En annan del som enligt rapporten kan förbättras kopplat till ApiControllerJson är att antalet publika metoder kan minskas.
##Scrutinizer
###Scrutinizers badges (före ändringar)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/nsbcj/mvc_report/badges/quality-score.png?b=main)](https://scrutinizer-ci.com/g/nsbcj/mvc_report/?branch=main)
[![Code Coverage](https://scrutinizer-ci.com/g/nsbcj/mvc_report/badges/coverage.png?b=main)](https://scrutinizer-ci.com/g/nsbcj/mvc_report/?branch=main)
[![Build Status](https://scrutinizer-ci.com/g/nsbcj/mvc_report/badges/build.png?b=main)](https://scrutinizer-ci.com/g/nsbcj/mvc_report/build-status/main)
[![Code Intelligence Status](https://scrutinizer-ci.com/g/nsbcj/mvc_report/badges/code-intelligence.svg?b=main)](https://scrutinizer-ci.com/code-intelligence)
###Codestyle
Scrutiziner uppfattas under rubriken "issues" ge en del förslag om ändringar kopplade till kodstil. Bland annat genererades en varning rörande fall där metoden Card kunde returnera ett nullvärde där integer preciserats som returvärde. I samma klass uppmärksammades jag även på kod som inte används. Totalt visades olika typer av fel i åtta filer, varav sex är sådana filer som jag skrivit i src- eller test-mapparna.

###Coverage
Den största skillnaden i förhållande till phpmetrics är att rapporten visar ett procenttal på kodtäckningen. Min kodtäckning är 27%, vilket är ganska lågt. Detta beror på att tester endast skrivits till ett begränsat antal klasser.

###Complexity
Scrutinizer visar komplexitet som "conditional complexity". Den klass som har högst värde är CardGame följt av tre controller-klasser. CardGame var på plats fyra avseende den cyklomatiska komplexiteten, redovisad i phpmetrics. CardGames komplexitet har uppmäts till 23. Ett högt värde tolkas av mig innebära att klassen är komplex.

###Cohesion
Jag har inte noterat något specifikt värde kopplat till Cohesion.

###Coupling
Coupling är heller inget värde som noterats i rapporten.

###CRAP
Kopplat till enskilda metoder, redovisar Scrutinizer ett antal värde. Ett av värdena är CRAP Score. I klassen CardGameController finns en metod, drawGame, som har ett högt CRAP-värde. Värdet är 76, vilket jag tolkar som för högt enligt tabellen kopplad till CRAP Score redovisad i föreläsningsmaterialet. Jag uppfattar resultatet som att metoden skulle behövas skrivas om, med syftet att sänka CRAP Score till en godtagbar nivå. En annan metod som ligger på gränsen är CardController::draw, som skulle vara i behov av kodtäckning genom testfall.

###Övrigt avseende Scrutinizer
Scrutinizer uppfattas ge bra feedback kopplat till skattning av klasser och metoders kvalitet. Detta görs genom en rating från A och nedåt.

###Svaga punkter i min kod
Scrutinizer ger tydlig vägledning rörande korrigering av buggar samt rörande övriga delar med förbättringspotential. Att korrigera get-metoder i klasserna Card och Dice är exempel på sådana. Som metoderna varit skrivna kan de returnera annat än en integer vilket inte preciserats som returvärde.

Den identifierade även koddelar som inte används och kan tas bort, exempelvis $game-variabeln på rad 78 i CardGameController.

Slutligen finns utvecklingpotential i utformandet av CardGameController::draw, som har ett för högt CRAP Score. Denna metod skulle behöva skrivas om.
##Förbättringar
###Utvalda förbättringar
De förbättringar jag avsett att göra är att fixa de issues Scrutinizer varna om, kopplat till de filer i src-mappen jag skrivit.

En andra del är att jag ska försöka sänka CRAP Score på CardGameController::drawGame.

Den sista delen är att jag ska öka kodtäckningen genom att skriva ytterligare tester kopplat till klassen Dice.

###Mätvärde före - efter

| Förbättring  | Före   | Efter   |
|---|---|---|
| Antal issues  | 16  |   |
| Crap Score drawGame | 72 |   |
| Kodtäckning   | 24%  |   |

##Diskussion
