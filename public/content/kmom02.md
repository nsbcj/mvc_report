##Kmom02 {#kmom02}
###Objektorienterade konstruktioner
####Arv
Arv är en form av utbyggnad av en basklass. Den kan använda för att möjliggöra tillgång till en basklass medlemsvariabler och metoder. Ett arv kan inte finnas utan en basklass. I uppgiften använde jag en arvsrelation för att möjliggöra en grafisk representation av ett spelkort.

####Komposition
Jag tänker att komposition, precis som aggregation, karakteriseras av "har en" relation mellan två klasser. En komposition innebär att den ena klassens existens är beroende av den andra. Ett exempel är att en klass som instansierar en flygresa inte kan finnas utan ett flygplan.

####Aggregation
Aggregation liknar komposition med tillägget att klasserna, som "har en" relation, kan existera oberoende av varandra. Ett exempel är en legomodell som har legobitar.

####Interface
Interface användes inte stor utsträckning under kursmomentet. Jag testade det i guiden och uppfattade det då som en form av uppsättning av villkor rörande vilka metoder som ska finnas i en klass. Använder en klass ett interface, ska alltså de metoder som är beskrivna i interfacet hittas i klassen.

####Trait
Trait användes inte heller i stor utsträckning av mig under kursmomentet. Jag uppfattar att traits tillgängliggör sina medlemsvariabler och metoder för andra klasser som använder traitet. Medlemsvariabler och metoder som är användbara för flera klasser, kan skrivas i ett Trait.

###Implementation av uppgiften
Uppgiften försökte jag lösa genom att använda en liknande struktur som i övningen. Jag använde ett eget namespace för klasserna och en egen folder för template-filerna. Metoderna i klasserna har försökts hållas så konkreta som möjligt.

Det som tog tid var representationen av korten. Jag använde en sprite-bild, vilket tog en stund att konfigurera i .scss-filen. I detta sammanhang lade jag mest tid på att få sprite-bilden att läsas in efter publicering på servern.

Sammanfattningsvis kändes Dice-övningen som en bra grund inför uppgiften. Även kunskapen från föregående kursmoment kunde användas för att få sakerna att fungera. Under genomförandet av de sista momenten av uppgiften insåg jag att det förmodligen gått att skriva om koden. Detta genom att använda det skapade API:et och därigenom hämta representationerna av spelkorten.

###Modellering av kortspelet
I uppgiften ingick en beskrivning av klassdiagrammens relationer och ritande av ett uml-diagram. Delarna uppfattades något kluriga. Det är inte helt enkelt att avgöra om relationer är aggregation eller komposition. Slutligen landande jag i att en kortlek inte kan existera utan kort och att en spelhand inte kan existera utan en kortlek.

Uml-diagrammet var heller inte enkelt få på plats. Det var ett tag sedan jag gjorde uml-diagram. Jag tror att jag slutligen fick medlemsvariabler, metoder och relationer på plats.

Jag uppfattar att det är svårt att göra uml-diagrammet innan koden fungerar och är på plats. Det är inte enkelt att på förhand se hur metoderna kommer fungera samt vilka metoder som behövs. Jag ser fram emot att lära mig ytterligare om att planera koden.

###TIL
Mest tid lades på att lösa använda en sprite-bild för att representera korten i kortleken. Det var lite krångligt att få till en fungerande lösning på servern. Ambitionen var att använda en .svg-fil, men användandet av en sådan verkar kräva ytterligare konfiguration. Slutligen använde jag en .png-fil och med hjälp av background: url() i .scss-filen. Problemet som uppstod var att webpack lade .png-filen i public/build/img/<filnamn>, samtidigt som servern pekade på public/build/build/img/<filnamn>. Jag tror att detta beror på konfigurationen setPublicPath('build') i webpack.config.js.

Arbetet med att lösa konfigurationen av webpack gav en del insikter i hur encore och webpack fungerar. Det känns som ett lager ovanpå Symfony.

Sammanfattningsvis kändes kursmomentet som en bra utmaning, som bidraget med ytterligare kunskaper om Symfony.  
