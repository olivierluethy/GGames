-- GGames schema (runs automatically on first DB init).
-- The `ggames` database itself is created by the MYSQL_DATABASE env var.
USE ggames;

CREATE TABLE IF NOT EXISTS users (
    id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
    email VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    username VARCHAR(255) NOT NULL DEFAULT '',
    istAdmin TINYINT(1) NOT NULL DEFAULT 0,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS video_game (
    id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(100) NOT NULL,
    entwickler VARCHAR(100) NOT NULL,
    img VARCHAR(100) NOT NULL,
    price VARCHAR(100) NOT NULL
);

CREATE TABLE IF NOT EXISTS kaeufe (
    id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
    fk_usersId INT NOT NULL,
    fk_video_gameId INT NOT NULL,
    FOREIGN KEY (fk_usersId) REFERENCES users(id),
    FOREIGN KEY (fk_video_gameId) REFERENCES video_game(id)
);
