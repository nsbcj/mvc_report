##Kmom04 {#kmom04}
###Skriva kod med PHPUnit
Testningen av PHP-kod upplevdes lik de test jag tidigare skrivit i Python. PHPUnit upplevs logiskt och användarvänligt. Jag har noterat att det finns många typer av asserts, men jag har initialt valt att använda några enstaka. Utformandet av varje enskilt test uppfattas som viktigt. I min lösning har jag försökt skriva asserts för de flesta metoderna.

Det upplevdes smidigt att använda PHPUnit som composer-script. Sammanfattningsvis har det varit intressant att lära sig grunderna i PHPUnit.

###Kodtäckning
Målet var initialt att komma över 90% i kodtäckning. Det visade sig vara en utmaning, då några metoder inte var optimalt skrivna för att testas. En del som uppmärksammades som mer svårtestad var de funktioner som innehöll logik. Jag noterade även att det på ett ställe fanns en loop som inte fungerade på önskvärt sätt. Efter att koden i klasserna ändrats, blev kodtäckningen bättre.

Till slut lyckades jag skriva tester för samtliga klasser och rader i klasserna. De flesta testerna körs enbart mot klassen som testas. Det finns även fall då metoder i klasser testas i samband med att de används i andra klasser. Dessa testfall känns inte optimala, då målet varit att testa varje klass för sig.

###Testbar kod
Korta metoder upplevs enklare att test. Därav har klasserna med korta enkla metoder varit enklare att arbeta med.

Delar av min kod gick smidigt att testa, medan andra delar var lite svårare. Det känns som att klassen GameCard använder för stora metoder, vilket gör det svår att testa. Det finns även fall, som är svåra att hitta, där det skrivits metoder som inte används. Det kan exempelvis röra sig om att flera klasser kan ha en metod för att dra kort från DeckOfCards och lägga det i CardHand. Jag tänker att det skulle räckt med en sådan metod.

Förbättringspotential finns sammanfattningsvis i att minska storleken på metoderna samt minska det totala antalet metoder.

###Omarbetning av kod
I de fall koden inte gick att testa eller var svårtestad, gjorde jag ändringar i koden. Det rörde sig framförallt om ändringar i GameStats-klassen. Där fanns delar som inte fungerade på önskvärt sätt i samband med testning.

Ändringar i större omfattning hade kunnat göras. Jag har i efterhand funderat över att det borde finnas en CardGameRound-klass. Klassen kunde haft ansvar för varje spelrunda och dess innehåll kunde sedan lagts till CardGame efter avslutad runda. Förutom att det förenklat strukturen i spelet, hade det skapat ytterligare möjligheter att presentera statistik kopplad till spelet.

Som jag nämnt ovan hade storleken på och antalet metoder även kunnat förbättras.

###Tankar om testbar kod
Testbar kod känns som en bra grund. Enkla och tydliga lösningar upplevs av mig som en bra grund till testbar kod. För att skriva bra tester krävs det förståelse för koden. Att skapa förståelse för koden känns som en god grund i strävan efter att skriva bra kod.

En annan del i detta är förklarande kommentarer. I uppgiften har jag tränat ytterligare på docblock-kommentarer. Det upplevs ibland tidskrävande, men tillför mycket avseende förståelsen för koden. Sammanfattningsvis upplevs kursen ha givit en del grundläggande förståelse för de verktyg man kan använda för att skapa god struktur i koden.

###TIL
Under kursmomentet har jag fått ytterligare insyn i hur lätt det är att tappa förståelsen för hur en applikation hänger ihop. Att liknande metoder finns på flera ställen och att koden skrivs onödigt lång är exempel på detta. Det är också svårt att rätta till sakerna i efterhand. Speciellt när man har en fungerande applikation.
