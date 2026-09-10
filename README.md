# Bubbles – ett community-forum

Bubbles är ett enkelt community-forum byggt i PHP där användare kan skapa konton, gå med i grupper och delta i diskussioner genom trådar och kommentarer.

Projektet är byggt utan något större ramverk och har fokus på tydlig struktur, återanvändbara komponenter och grundläggande forumfunktionalitet.

## Syfte

Projektet syftar till att bygga ett mindre webbcommunity från grunden och samtidigt arbeta med bland annat:

- PHP och serverside-rendering
- relationsdatabaser
- autentisering och sessionshantering
- SQL-frågor och relationer
- återanvändbara vyer och komponenter
- strukturering av ett halvstort PHP-projekt

## Funktionalitet

Bubbles innehåller bland annat:

- registrering och inloggning
- användarprofiler med användarnamn och avatar
- grupper med medlemmar och användarnivåer/roller
- medlemsförfrågningar
- inbjudningar till grupper via hot-link
- skapande och visning av diskussionstrådar
- kommentarer i trådar
- visning av senaste aktivitet
- administrationsfunktioner för gruppadministratörer
- responsivt gränssnitt för desktop och mobil

## Techstack

Projektet använder huvudsakligen:

- **PHP**
- **MariaDB**
- **HTML**
- **CSS**
- **JavaScript**
- **PDO** för kommunikation med databasen
- **Docker** för lokal utveckling

Applikationen är serverside-renderad och använder PHP för routing, databaslogik och rendering av vyer.

I nuvarande servermiljö körs projektet med **Nginx + PHP-FPM 8.4**, men applikationen är inte beroende av Nginx i sig.

## Projektstruktur

```text
.
├── app
│   ├── actions
│   ├── data
│   ├── helpers
│   ├── views
│   │   ├── components
│   │   ├── pages
│   │   └── parts
│   ├── bootstrap.php
│   └── request.php
├── config
│   ├── database.php
│   └── settings.php
├── docs
├── public
│   ├── assets
│   ├── css
│   ├── js
│   └── index.php
├── docker-compose.yml
├── Dockerfile
└── README.md
```

### `app/actions`

Innehåller funktioner som hanterar användarens olika actions, till exempel inloggning, registrering, medlemskap, trådar och kommentarer.

### `app/data`

Innehåller funktioner för projektets databasåtkomst, uppdelade efter område, till exempel användare, grupper, trådar, kommentarer och medlemskap.

### `app/helpers`

Gemensamma hjälpfunktioner för bland annat autentisering, rendering, felhantering, formattering och avatarer.

### `app/views`

Innehåller projektets vyer:

- **components** – återanvändbara delar av sidor
- **pages** – kompletta sidvyer
- **parts** – gemensamma delar som header, navigation och footer

### `config`

Projektets konfiguration, bland annat databasanslutning och inställningar för navigation och sidor.

### `docs`

Dokumentation för projektet, innefattande uppgiftsbeskrivning, checklista, sitemap och ER-diagram.

### `public`

Webbserverns publika katalog. Här finns applikationens entry point samt CSS, JavaScript, bilder och ikoner.

## Namnkonventioner

Projektet följer i huvudsak dessa namnkonventioner:

- PHP-filer använder `snake_case`, exempelvis `group_details.php`
- databastabeller och kolumner använder `snake_case`
- PHP-funktioner använder `camelCase`, exempelvis `getGroupById()`
- sidvyer börjar med `page_`, exempelvis `page_profile.php`
- komponenter namnges efter vad de representerar, exempelvis `thread_list.php`
- action-filer grupperas efter funktion, exempelvis `membership.php` och `thread.php`

## Databas

Bubbles använder MariaDB.

Databasen innehåller (se `docs/er-diagram.png`) tabeller för:

- användare
- grupper
- gruppmedlemskap
- roller
- trådar
- kommentarer
- medlemsförfrågningar
- medlemsinbjudningar

En användare kan vara medlem i flera grupper och ha olika roller i olika grupper.

## Installation

Projektet kan köras lokalt med Docker.

```bash
git clone <repository-url>
cd <repository>
docker compose up -d
```

Databasinställningar och övrig konfiguration finns dels i `.env.example`, dels under `config/`.

## Routing

Bubbles använder en enkel egen routinglösning där sidförfrågningar hanteras genom `public/index.php` och `app/request.php`.

## Inloggning och sessioner

Inloggade användare identifieras med PHP-sessioner.

Sessionen lagrar användarens ID och övrig användarinformation hämtas från databasen vid behov.

Lösenord lagras hashade och databasfrågor använder PDO och prepared statements.