##Kmom03 {#kmom03}
###Flödesdiagram och pseudokod
Kortspelet utvecklades genom att jag först gjorde klart spelet och sedan skrev flödesdiagrammet och pseudokoden. Det gjorde att spelets flöde och pseudokoden kändes ganska naturligt. Troligtvis hade det varit bättre att göra det i omvänd ordning.

Vid utvecklandet av kortspelet följde jag de punkter som beskriver hur spelet 21 fungerar. I samband med detta började jag titta på vilka klasser som kunde återanvändas och vilka som behövdes. I denna process testade jag att skriva klasserna, varvid spelet tog form. När jag noterade att flödesdiagrammet och pseudokoden skulle föregå skrivandet av programmet, var jag i princip färdig med programmet.

Jag valde sedan att beskriva en spelrunda, både i flödesdiagrammet och pseudokoden. Det uppfattades som ett bra sätt att få överblick av vilka funktionaliteter som var centrala för spelet. Troligtvis hade genomförandet blivit annorlunda om dessa delar gjorts först. Min slutgiltiga kod har en del metoder som inte används, varvid den kan refaktoreras.

###Implementation av uppgiften
Ser man till antalet klasser, tillkom fyra stycken till denna uppgift. Det hade möjligtvis kunnat dras ned till tre, då klassen Player och HousePlayer hade kunnat hanteras av samma klass. Jag har försökt tänka att klasserna ska kunna återanvändas i andra kortspel. Därför ligger spelets logik i klassen CardGame. Den hämtar data från andra klasser och kontrollerar spelarnas kort för att kontrollera vem som vinner.

En sak jag funderat på är om jag kanske borde anpassat klassens properties till att matcha den data som skickas till Twig-filen. I den nuvarande koden skapas ett data-objekt i CardGame::play(), som sedan används för att skicka all data till Twig-filen. Denna data skulle kunna exmpelvis kunna ha skapats genom CardGame::getData(), som sedan satt datan i objektets egna properties.

Även kodstilen kan förbättras genom att höja nivån på phpstan. För att göra detta kommer jag behöva läsa på hur man i php-docblock metoder hämtade från andra klasser.

###Känslan att koda i Symfony
Den generella känslan är att mycket tid behöver läggas på syntax. Symofony skiljer sig i vissa avseende mycket från de andra ramverk jag läst.

Strukturen i foldrarna börjar jag få koll på. Just nu är det kommentarer användande av php-docblock som jag försöker lära mig. Att sätta variabelbeskrivningar på rätt ställe känns som en ganska komplicerad grej.

En del som verkar vara en fördel med ramverk, är att det är ganska enkelt att implementera nya moduler i programmet. Jag har inte upplevt några större problem vid implementationen av linters och andra delar kopplade till composer. Å andra sidan upplevs det som lite struligt att använda JavaScript i kombination med Symfony.  
