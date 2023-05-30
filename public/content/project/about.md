Projektet är en del av kursen MVC på BTH. Det genomförs som en del av kursens examination. Mitt projekt handlar om att utveckla ett kortspel baserat på de regler som gäller för blackjack.

Grundkrav för projektet är att spelare ska kunna ange sitt namn och därefter bli tilldelad ett konto med fiktiva spelpengar. Spelaren ska kunna spela mellan en till tre händer samtidigt och satsa fiktiva spelpengar i samband med detta. De riktiga reglerna för kortspelet ska följas.

Att göra en sida för API:er är ett optionellt krav. Detta krav genomförs, består av fem API:er kopplade till kortspelet, varav ett görs genom en POST-request.

Ett annat optionellt krav är att implementera en databas med minst två tabeller. Databasdelen innehåller en redovisning av tabellerna genom ER-diagram och separat redovisningstext.

Slutligen är ytterligare ett optionellt krav redovisat i redovisningstexte. Det handlar om att i en texten lyfta fram tre - fem delar av projektet som varit extra utmanande och utanför projektets baskrav.

##Kort gällande reglerna för kortspelet
Ess representerar 1 eller 11 poäng.

Knekt, dam och kund representerar 10 poäng.

Övriga kort representerar det värde som finns på kortet.

En till tre händer kan spelas. En spelare spelar mot huset, som spelar en korthand. Initialt dras två kort till huset, men endast ett visas. Huset drar kort till dess att dess korthand har ett totalt värde över 17.

Summan av kortens värde i en korthand motsvarar den poäng som visas. Spelare startar med två kort på handen och bestämmer om man ska dra ytterligare kort eller stanna. Om en korthand har ett värde högre än 21 förlorar spelaren den korthanden. Likaså gäller om husets korthand uppnår ett värde över 21.

Högst värde på korthanden vinner, efter att spelaren spelat klart korthanden/korthänderna.

[Om databasdelen](about/aboutdb){.button}
