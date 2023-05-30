##Kmom10 {#kmom10}
###Krav 1-3
####Innehåll och utseende
Det gick förhållandevis problemfritt att komma igång med projektsidan. Jag valde att göra kortspelet blackjack. Att jag i report-sidan valt att användanda .scss-filer uppfattades underlättade ändradet av sidans style. För projektsidan skrevs nya stylesheets för header, main och footer. Färg, typsnitt och utseende har i någon mån förändrats. Den största förändringen är själva spelytan som är tänkt att efterlikna ett spelbord. En hel del tid av projektet lades för att visualisera spelflödet för att tydliggöra de val spelaren förväntas göra. En annan del som påverkar känslan av sidan är den mörka bakgrunden och färgschemat på submit-knapparna. Även knapparna är tänkta att förmedla sitt syfte genom designen.

Avseende sidans innehåll har en about kopplat till projektet skapats. Även den aboutsida, som var en del databasdelen krav 5, har skapats. Texterna är skrivna i Markdown-filer, vilket uppfattas vara ett smidigt sätt att tillföra content till twig-filerna.

Projektets filstruktur följer den som använts tidigare i kursen. Jag skapade separata Controllers för projektet och skapade fyra nya klasser för att få ett fungerande kortspel. Delar av de klasser som används har skrivits tidigare i kursen. Speletstyrs genom klassen ProjGame.php.

####Repo och dokumentation
Filen README.md har uppdaterats och innehåller nu en instruktion om hur repot kan klonas och användas. Det finns även en kortare beskrivning av repots innehåll och syfte.

Arbetet med kodtäckning och kodkvalitet har fortsatt under projektet. Jag har försökt skriva tester som täcker samtliga klasser och metoder som lagts till under projektets gång. Målet har varit att få full kodtäckning på de nya klasser som skrivits. Tester för Controllers och mot databasrelaterade filer har inte skrivits.

Dokumentation är en del som jag uppfattar som lite svår. Det är lätt att missa att skriva beskrivningar till metoder och klasser i den omfattning som behövs. Avseende de metoder som lagts till i projektets klasser, har ha avsikten varit att skriva beskrivningar rörande dess syfte.metodens syfte skrivits.

Rapporter för kodkvalitet och dokumentation är genererade med phpmetrics respektive phpdoc.

###Krav 4
####JSON API
JSON API:er för projektet är placerats i navbaren. De API:er jag valt att skriva är:

* 1) Visa samtliga kort i kortspelets kortlek (blackjack verkar traditionellt använda sex kortlekar).
* 2) Visa att det går att dra tre händer händer med spelkort
* 3) Visa pågående spelrunda.
* 4) Visa att det går att sätta en slumpmässigt vald spelares kontobalans.
* 5) Initiera ett önskat antal spelande händer och visa strukturen för en spelrunda.

Sammanlagt är det fem API:er, varav två är POST-requests.

Implementationen av JSON API:er liknade det som gjorts tidigare i kursen. Det gick smidigt. Samtidigt uppfattar jag att det är svårt att välja vad man ska visa och hur. Det finns exempelvis utvecklingspotential rörande det API som sätter kontobalans. Kanske hade man kunnat utveckla API:et genom att hämta spelare från databasen och editera den balans som kopplas till spelaren?

###Krav 5
####ORM - databas
Det krävdes en stunds fundering innan jag kom igång med att skapa tabellerna. En ambition var att endast ta med data av sådan typ som kunde användas i applikationen. En annan ambition var att inte skriva data till databasen vid onödigt många tillfällen. När jag slutligen skapade de nya tabellerna, players och stats, hade jag tanken att tabellernas syfte skulle kopplas till någon extra feature.

Tabellen players skapades för att ge möjlighet att återanvända skapade spelare. Tabellen stats skapades för att ge möjlighet att visa statistik.

Den krångliga delen av uppgiften var att aggregera den data som sparades i tabellen stats. Lösningen var att använda php-funktioner som array_filter och array_reduce. Användandet av funktionerna kändes igen från Javascript. Den statistik som visas på förstasidan bygger på information som aggregerats från tabellen stats. Tabellen stats innehåller statistik för varje spelrunda, medan den statistik som visas bygger på en aggregation av informationen.

En sak jag funderat kring är om ORM-delen kunde skrivits på ett bättre sätt. Koden i några Controllers har blivit omfattande. Om koden hade refaktorerats tänker jag att jag på något sätt hade kunnat bryta ut de delar som kopplas till databasen.

###Krav 6
####Avancerade features
Den sista delen av projektet är att beskriva de delar som lagts extra tid på och som gjorts utöver baskraven. Dessa presenteras nedan.
#####Möjligheten att återanvända registrerade spelare
Som jag skrivit ovan, implementerades denna del tillsammans med databasdelen. Tidigt uppfattade jag att det vore smidigt att kunna fortsätta med spelare som tidigare använts. Vid registrering av ny spelare uppfattade jag det lämpligt att skriva in varje spelares namn och balans i tabellen players. Spelarens balans uppdaterades sedan vid avslutad spelrunda.

Målet med den visuella presentationen av tidigare spelare har varit att på ett tydligt sätt presentera dem. Med hjälp av ::after och användande av data-attribut visas även kontosbalans i anslutning till formuläret. En tidigare använd spelare kan återanvändas genom att klicka på den submit-knapp som visar spelarens namn.

Den sista delen som implementerats kopplad till möjligheten att registrera spelare, är möjligheten att ta bort spelare från databasen. Detta löstes genom att lägga till en submit-knapp för att ta bort spelaren.
#####Presentation av statistik
Att på något sätt presentera statistik kopplad till spelet uppfattades av mig som en bra feature. I databasen löstes denna del med en tabell innehållande statistik per spelrunda. Målet med statistiken var att visa relevant statistik på ett enkelt och tydligt sätt. Utmaningen var främst den tidigare nämnda aggregeringen av tabellens rader. Lösningar avseende aggregeringen krävdes för att få fram önskade siffror. I sammanhanget var det för mig en ny upptäckt att Twig kunde användas för att lösa delar av aggregeringen.

Den statistik som presenteras kopplas till spelfrekvens, antal vinster/lika/förluster och den totala förtjänsten.

Slutligen lades en del tid på att presentera statistiken på ett bra och tydligt sätt. Ett designval kopplat till detta är att använda färger för att förstärka delarnas betydelse. Ett exempel är att negativt värde rörande förtjänst presenteras i röd färg och positivt värde förtjänst i grön färg.

Statistikdelen känns sammanfattningsvis som något som kan utvecklas ytterligare. Ett exempel är att lägga till cirkeldiagram för att visa fördelningen mellan antal vinster, lika och förluster.
#####Möjligheten att splitta hand
Möjligheten att splitta, nämndes i instruktionen som ett optionellt krav kopplat till blackjack. Det var en utmaning att få denna funktionalitet att fungera på önskat sätt. Under den initiala fasen av utvecklingen fungerade de grundläggande delarna av spelet någorlunda. En del som fungerade var att man kunde spela flera händer. Att denna funktionalitet var på plats underlättade utvecklingen av möjligheten att splitta.

En del jag tidigt uppfattade som en utmaning var att jag i php-manualen endast hittade sätt att lägga till objekt först eller sist i en array. Den nya handen hamnade vid splittning på fel plats med anledning av detta. Min ambition var att skapa ett naturligt spelflöde, vilket innebar att de splittade händerna önskades hamna på rätt plats i spelflödet. Lösningen blev slutligen funktionen array_splice, som möjliggjorde positionering av de "nya" händerna. Dock krävdes det en hel del felsökning innan jag noterade att objekt skulle placeras i en array för att läsas på rätt sätt i array_splice.

Slutligen verkar möjligheten att splitta fungera på önskvärt sätt. Tanken har varit att min lösning, både genom funktionellt och grafiskt stöd, ska möjliggöra att spelet spelas i rätt ordning. Detta innebär att endast en hand kan spelas i taget, vilket i sin tur ställer krav på att den aktiva handen noteras. Detta verkar fungera även efter en splittning.

###Allmänt om projektet
Uppfattningen är att projektet varit en utmaning. Jag lade till en hel del kod i förhållande till tidigare kortspel. Kombinationen att skapa något som fungerar bra och som presenteras bra, är svårt. Det är också tidskrävande. Utöver detta kommer testning, dokumentation och kodkvaliteten. Den slutliga känslan är att mer tid kunde lagts på projektet. Ju större applikationen är, desto mer kod kan förbättras.

Det som gick någorlunda enkelt var att komma igång med projektet. Då projektet utgått från samma kodbas som tidigare kursmoment fungerade många delar från start. Upplevelsen är att det inte behövts läggas lika mycket tid på felsökning som vid tidigare kursmoment.

Sammanfattningsvis var det ett bra projekt som fick med de flesta delar som berörts i kursen.

###Tankar om kursen
Kursen har varit bra. Flera nya delar har berörts. Den största svårigheten är att ställa om mellan de olika delarna. Ett exempel är övergången mellan kmom05 och kmom06, som båda berörde nya delar som krävde både inläsning och konfiguration. När övergången, från ett kursmoment till ett annat, skett har det infunnit sig en känsla av att man önskat lära sig mer av det man precis lärt sig.

Det uppfattas positivt att kursen, liksom kurspaketet i övrigt, har många praktiska moment.

Kursen har varit ett bra sätt att fördjupa sig i ramverk, objektorientering och kodkvalitet. Kursen har även givit mig ytterligare kunskaper om composer och npm. Sammanfattningsvis uppfattas kursen vara 8 av 10 på en skala från 1 - 10.
