<!-- PROJECT LOGO -->
<br />
<p align="center">
  <a href="https://github.com/olivierluethy/GGames.git">
    <img src="assets/favicon.ico" alt="Logo" width="80" height="80">
  </a>

  <h3 align="center">GGAMES</h3>

  <p align="center">
    A dark-themed video game store (à la Steam) built with PHP, MySQL & Tailwind CSS.
    <br />
    <a href="https://github.com/olivierluethy/GGames.git">View Demo</a>
    ·
    <a href="https://github.com/olivierluethy/GGames.git/issues">Report Bug</a>
    ·
    <a href="https://github.com/olivierluethy/GGames.git/issues">Request Feature</a>
  </p>
</p>

<!-- TABLE OF CONTENTS -->
<details open="open">
  <summary>Table of Contents</summary>
  <ol>
    <li><a href="#about-the-project">About The Project</a></li>
    <li><a href="#features">Features</a></li>
    <li><a href="#getting-started">Getting Started</a></li>
    <li><a href="#roles--test-accounts">Roles &amp; Test Accounts</a></li>
    <li><a href="#how-its-built">How It's Built</a></li>
    <li><a href="#project-structure">Project Structure</a></li>
    <li><a href="#developer-notes">Developer Notes</a></li>
    <li><a href="#user-notes">User Notes</a></li>
  </ol>
</details>

## About The Project

GGAMES is a web-based video game store where visitors can browse games, registered
users can buy and return them and build a personal library, and admins manage the
catalogue. It started as a personal PHP/MySQL project inspired by Steam and was later
overhauled into a real game-store experience: a dark, orange/green branded UI built
entirely with Tailwind CSS, inline modals instead of page reloads, multi-image game
cards with hover carousels, price history & trends, a simulated payment flow, and a
light social layer (friends who own a game). The UI language is **German**; the code
and comments are in English.

## Features

- 🎮 **Store** with a responsive dark game-card grid; owned games never appear in the shop.
- 🖼️ **Hover carousels** — cards cycle through a game's images on hover (auto + manual).
- 🔎 **Inline game detail** modal: image carousel, description, price, **price-trend chart**,
  buyers-per-price, friends who own it, and recommended games.
- 🛠️ **Admin CRUD** via an inline modal (no page navigation): add/edit/delete games with
  **image URL / base64** inputs and **live previews**, multiple images per game.
- 🏠 **Auth-aware home**: a welcome hero for guests; an auto-sliding *latest games* showcase
  and a *popular by developer* ranking for logged-in users.
- 💸 **Price history**: editing a price records a point; users see a *price-drop* badge and a
  trend chart; purchases store the price actually paid.
- 💳 **Simulated payment**: save a dummy card (never validated) and use it to "pay" for games.
- 👥 **Friends**: see which of your friends already own a game.
- 📚 **Library**: your purchases with purchase dates, one click from the nav.

## Getting Started

### Run with Docker (recommended)

The whole stack — PHP/Apache **and** a MySQL database pre-filled with mock data — runs
with a single command. The only prerequisite is [Docker](https://docs.docker.com/get-docker/)
with Docker Compose. Works the same on Ubuntu, macOS and Windows.

```sh
git clone https://github.com/olivierluethy/GGames.git
cd GGames
docker compose up -d --build
```

Then open:

> **http://localhost:8090/GGames/**

The first start automatically creates the database, schema and mock data
(see [`docker/mysql/init`](docker/mysql/init)).

Useful commands:

```sh
docker compose logs -f      # view logs
docker compose down         # stop (keeps the database)
docker compose down -v      # stop AND wipe the database (re-seeds on next start)
```

Host ports (change in `docker-compose.yml` if they clash):

| Service        | URL / Port                                  |
| -------------- | ------------------------------------------- |
| Web app        | http://localhost:8090/GGames/               |
| MySQL database | `localhost:3316` (user / pass / db: `ggames`) |

### Environment variables

Configured in `docker-compose.yml` (the web app reads them, with local XAMPP
defaults as fallback):

| Variable        | Default | Purpose                                                        |
| --------------- | ------- | -------------------------------------------------------------- |
| `DB_HOST`       | `db`    | Database host (`127.0.0.1` when running under XAMPP)           |
| `DB_NAME`       | `ggames`| Database name                                                  |
| `DB_USER`       | `ggames`| Database user                                                  |
| `DB_PASS`       | `ggames`| Database password                                              |
| `QUICK_LOGIN`   | `1`     | Show the one-click quick-login dev panel on the login page     |
| `RAWG_API_KEY`  | *(unset)* | Optional [RAWG.io](https://rawg.io/apidocs) key to enrich game detail with extra screenshots/rating. **Without it the app works fully from admin-entered data.** |

### Run under XAMPP (classic)

Place the project at `htdocs/GGames`, import the schema and seed from
[`docker/mysql/init`](docker/mysql/init) (or run the files in [`migrations/`](migrations)),
and open `http://localhost/GGames/`. With no env vars set, the DB connection falls back to
`localhost` / `root` / no password / database `ggames`.

## Roles & Test Accounts

Two roles exist (via the `users.istAdmin` flag): **Admin** (can add / edit / delete games)
and **User**. All seeded accounts use the password **`password`**. On the login page the
**Quick Login (Dev)** panel logs you in as any of them with one click (hidden unless
`QUICK_LOGIN=1`).

| Email                  | Password   | Role  | Notes                       |
| ---------------------- | ---------- | ----- | --------------------------- |
| `olivier@ggames.test`  | `password` | Admin | Owns a few games, has a card |
| `sarah@ggames.test`    | `password` | Admin | Owns a couple of games      |
| `max@ggames.test`      | `password` | User  | Owns a few games            |
| `lena@ggames.test`     | `password` | User  | Owns one game               |
| `jonas@ggames.test`    | `password` | User  | Empty library (edge case)   |
| `mia@ggames.test`      | `password` | User  | Owns every game, has a card |

## How It's Built

- **Backend:** PHP 8.2 (no framework) in a small custom **MVC** — a tiny front-controller
  router (`core/Router.php`) maps URLs to controller actions; the model layer uses **PDO**.
- **Database:** MySQL 8 — tables for users, games, images, price history, purchases,
  payment cards and friends.
- **Frontend:** **Tailwind CSS** (Play CDN, dark mode only, orange + green brand theme) with
  shared PHP layout partials. Interactions (carousels, modals, inline detail, image previews,
  price chart) are dependency-free vanilla JS in `public/js/ggames.js`.
- **Infra:** Docker Compose runs `web` (php:8.2-apache, served under `/GGames/`) and `db`
  (mysql:8). The DB auto-seeds on first run.

Request flow: `index.php` (routes) → `core/bootstrap.php` (helpers, router, DB, model) →
`GGamesController` action → renders an `app/Views/*.view.php` that composes the shared
partials. The inline detail modal and the admin edit form are populated from the
`gameDetail` JSON endpoint.

## Project Structure

```
GGames/
├── index.php                      # Front controller: route table + DB config
├── core/
│   ├── bootstrap.php               # Requires helpers, router, db, model
│   ├── Router.php                  # URL -> Controller@method dispatch
│   ├── database.php                # PDO connection (env-configurable)
│   └── helpers.php                 # e(), env(), isLoggedIn(), isAdmin(), formatPrice(), ...
├── app/
│   ├── Controllers/GGamesController.php   # All actions (store, gameDetail, CRUD, buy, konto, cards, auth)
│   ├── Models/Games.php                   # Data access (images, prices, library, social, payments)
│   └── Views/
│       ├── partials/               # head, nav, account-menu, foot, game-card, modals
│       ├── welcome.view.php        # Guest landing (hero)
│       ├── home.view.php           # Logged-in home (showcases)
│       ├── store.view.php          # Shop grid
│       ├── konto.view.php          # Account: library / payment / friends / info
│       ├── login.view.php          # Login (+ quick-login dev panel)
│       ├── register.view.php       # Sign up
│       └── editKonto.view.php      # Edit account
├── public/js/
│   ├── ggames.js                   # Carousels, modals, detail, admin form, price chart
│   └── clientSideValidationKonto.js
├── assets/                         # Logo, favicon, demo cover images
├── docker/
│   ├── php/php.ini                 # Errors to log, not into responses
│   └── mysql/init/                 # 01-schema.sql + 02-seed.sql (consolidated, fresh installs)
├── migrations/                     # Incremental SQL to upgrade an existing DB (001..005)
├── Dockerfile
└── docker-compose.yml
```

## Developer Notes

- **No build step.** Tailwind is delivered via the Play CDN with an inline theme in
  `app/Views/partials/head.php`; reusable component classes (`.btn*`, `.card`, `.input`,
  `.chip`) are defined there with `@apply`. There is **no** custom `.css` file.
- **Database changes:** fresh installs use the consolidated `docker/mysql/init` scripts;
  to upgrade an existing database, apply the numbered files in [`migrations/`](migrations)
  (instructions in `migrations/README.md`).
- **Images** are stored as URL or base64 strings in `game_images` (no file uploads). The
  legacy `video_game.img` column is kept for backwards-compat but is no longer the source
  of truth. Seeded demo covers reference the bundled `assets/` files via relative URLs.
- **Prices** are stored as `'Gratis'` or a bare number (e.g. `49.95`); `formatPrice()`
  renders them. Editing a price appends a `price_history` row; purchases snapshot
  `price_paid`.
- **RAWG enrichment** is optional and additive — admin-entered data is always the source of
  truth, and the app is fully functional with no API key.

## User Notes

- Buying a **paid** game requires a saved payment card (add one under **Konto → Zahlung**);
  free games need none. Payment is **simulated** — no card data is validated or processed.
- Games you already own never show up in the shop; find them under **Käufe** (your library),
  where each shows its purchase date and can be returned.
- Hover a game card to preview its screenshots; click it for full details, the price trend,
  and which of your friends own it.
