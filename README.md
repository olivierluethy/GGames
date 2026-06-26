<!-- PROJECT LOGO -->
<br />
<p align="center">
  <a href="https://github.com/olivierluethy/GGames.git">
    <img src="assets/favicon.ico" alt="Logo" width="80" height="80">
  </a>

  <h3 align="center">GGames</h3>

  <p align="center">
    Here I'll explain what this project is and how you set it up!
    <br />
    <a href="https://github.com/olivierluethy/GGames/blob/main/README.md"><strong>Explore the docs »</strong></a>
    <br />
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
    <li>
      <a href="#about-the-project">About The Project</a>
    </li>
    <li>
      <a href="#installation-guide">Installation Guide</a>
    </li>
  </ol>
</details>

<!-- ABOUT THE PROJECT -->
## About The Project
At the company, I was working on a big project with another colleague. It was a web-based software. To realize this project we used the languages PHP and JavaScript. For the database we used MySQL. 
During the development of the software, I was fascinated by what you can develop with PHP and MySQL. 

After that, I started many small projects, but most of them turned out to be nothing. So I decided to start my first own big project. Since I always wanted to create a store, I decided to use PHP and MySQL to create a
to create a game store similar to Steam. I structured the code almost the same as the one we used for the company's project.

When I first started programming, I often got annoyed when things didn't work the way I wanted them to. I often had to delete and rebuild the project because there were too many bugs in the code. After a few months, things started to get better. I was able to finish a large part, but not the heart of the project. By that, I mean that a logged-in user could buy games from the site. You could only add, edit, or delete games. But not buy them. I held on to that goal for a long time.

Later I went to an inter-company course for about a week. There I learned how to work with PHP and the MVC pattern. I learned it very quickly and started with some small projects. Most of them turned out to be nothing though. One of them was the TackPad application.

After half a year, the company tested me to see how good I really was. I had to program a large web application. When I was able to complete every single task of the assignment, I realized how good I really was.

After that, I decided to continue working on my game store, which was a dream of mine to finally finish. I started all over again. 

It took me a long time to program everything perfectly. About 1 to 2 weeks. When I finished a big part of the project, I spent hours fixing the bugs, except for buying games. After about 4 hours I was finally able to finish it, and I was so extremely happy to finish something I had been working on for so long.

<!-- INSTALLATION -->
## Installation Guide

1. At first you need to install git on your local computer. For that, you need to go to this [website](https://git-scm.com/downloads).
2. Go to your Windows Explorer and search for a good place to store this project
3. Now right-click on your folder or place and then click on "Git Bash Here"
4. Finally you will see a new program. If you do you only have to enter this<br>
   ```sh
   git clone https://github.com/Oli7000/GGames.git
   ```

## Run with Docker (recommended)

The whole stack (PHP/Apache web server **and** a MySQL database, pre-filled
with mock data) runs with a single command. The only prerequisite is
[Docker](https://docs.docker.com/get-docker/) with Docker Compose. This works
the same on Ubuntu, macOS or Windows.

```sh
# from the project root
docker compose up -d --build
```

Then open the app at:

> **http://localhost:8090/GGames/**

The first start automatically creates the database, the schema and a set of
mock games and users (see [docker/mysql/init](docker/mysql/init)).

Useful commands:

```sh
docker compose logs -f          # view logs
docker compose down             # stop the stack (keeps the database)
docker compose down -v          # stop and wipe the database (re-seeds on next start)
```

Ports used on the host (change them in `docker-compose.yml` if they clash):

| Service        | URL / Port                         |
| -------------- | ---------------------------------- |
| Web app        | http://localhost:8090/GGames/      |
| MySQL database | `localhost:3316` (user/pass/db: `ggames`) |

### Test accounts & quick login

All seeded accounts use the password **`password`**. On the login page a
**"Quick login (dev)"** panel lets you log in as any of them with a single
click (it is shown only while the `QUICK_LOGIN` env var is set in
`docker-compose.yml`).

| Email                  | Role  | Notes                       |
| ---------------------- | ----- | --------------------------- |
| `olivier@ggames.test`  | Admin | Owns a few games            |
| `sarah@ggames.test`    | Admin | Owns a couple of games      |
| `max@ggames.test`      | User  | Owns a few games            |
| `lena@ggames.test`     | User  | Owns one game               |
| `jonas@ggames.test`    | User  | Empty library (edge case)   |
| `mia@ggames.test`      | User  | Owns every game             |

Admins additionally see the **Add / Edit / Delete game** controls in the store.

> The app also still runs the classic way under XAMPP at
> `http://localhost/GGames/` — the database settings fall back to
> `localhost` / `root` / no password / db `ggames` when no environment
> variables are present.
