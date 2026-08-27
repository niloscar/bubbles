# Inlämningsuppgift
I denna uppgift ska vi bygga ett community forum där användare kan skapa konton och prata om de intressen som intresserar just dem. Det handlar om att hålla koll på vilken användare som tillhör vilken grupp och vilken inforamtion de ska ha tillgång till.

Vi kommer bygga både front-end och back-end med php, så react eller andra javascript-ramverk får inte användas, men man får skapa enklare javascript för att förbättra användarupplevelsen.

## Kraven för denna uppgift:

🚨VIKTIGT - Det ska gå att se att det är du som gjort koden, vilket du visar genom att ha en bra git-historik genom hela projektet. Minst en commit för varje dag som då du jobbat på uppgiften, men gärna fler. Om du bara har 1 eller några få commits innan inlämning kommer uppgiften inte att godkännas.🚨

**Betyg G**

- Databasen ska vara SQL.
- Alla sidor ska vara skrivna i php (ingen react mot api tillåten för denna uppgift).
- All data måste hanteras säkert så att en användare inte kommer åt data som den inte ska ha tillgång till. 
- En användare ska kunna skapa ett användarkonto för att gå med i grupper
- Ett användarkonto ska lagra namn (för- och efternamn), epostadress och hash för lösenord.
- En inloggad användare ska kunna skapa en grupp med ett namn på vad som diskuteras i den gruppen
​​​​​​​- När man är medlem i en grupp ska man kunna starta en diskussion, man anger ett ämne och ett första inlägg
​​​​​​​​​​​​​​- Alla som är medlemmar i gruppen ska kunna svara med ett inlägg under ett ämne
​​​​​​​​​​​​​​- Man ska kunna se alla grupper som man inte är medlem i, och man ska kunna ansöka om att gå med i gruppen
​​​​​​​​​​​​​​- Om man är medlem i en grupp där det finns ansäkningar, ska man kunna godkänna dessa ansäkningar så att användaren blir medlem av gruppen

Vid inlämning ska det även skickas med 3 screenshots och en genomgångsvideo med voice over:
- Bild på startsidan
- Bild på en gruppdiskussion
- Bild på hur man svarar på en diskussion
- Genomgånsvideo på hur man skapar ett konto, ansöker om att gå med i en grupp och hur man startar en diskussion

**Betyg VG:**

​​​​​​​​​​​​​​- Det ska finns 2 roller som en användare kan ha för en grupp, medlem eller adminstratör.​​​​​​​
​​​​​​​​​​​​​​- Det är endast administratörer som ska kunna godkänna ansökningar om att gå med i gruppen
​​​​​​​​​​​​​​- En administraör ska kunna välja roll på de andra som är med i gruppen
​​​​​​​​​​​​​​- En administratör ska kunna skapa en inbjudanlänk, som en annan person kan använda för att gå med i gruppen utan att behöva vänta på att bli godkänd. Detta ska vara en “hot link” där man bara kan registrera sig 1 gång, och den ska bara vara giltig i 24 timmar.

**Denna uppgift mäter följande moment från kursplanen:**

- Utveckla programstruktur för hantering av information, informationsflöde och användare
- Ta fram design för system och kodbaser utifrån arkitektuella principer
- Använda Postman för att testa API:er

**Denna uppgift mäter följande VG-moment från kursplanen:**

Den studerande ska dels nått samtliga läranderesultat för kursen. Den studerande ska dessutom med säkerhet och skicklighet kunna:

- Utveckla programstruktur för hantering av information, informationsflöde och användare
- Ta fram design för system och kodbaser utifrån arkitektuella principer
- Använda Postman för att testa API:er