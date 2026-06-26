-- GGames schema (runs automatically on first DB init).
-- This is the consolidated final schema. For upgrading an existing database,
-- see the incremental files in /migrations.
-- The `ggames` database itself is created by the MYSQL_DATABASE env var.
SET NAMES utf8mb4;
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
    -- Legacy cover filename; kept for backwards-compat. Images now live in
    -- game_images (URL or base64). Not the source of truth anymore.
    img VARCHAR(100) NOT NULL DEFAULT '',
    -- 'Gratis' or a bare numeric string (e.g. '69.95'); rendered via formatPrice().
    price VARCHAR(100) NOT NULL,
    description TEXT NULL,
    created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP
);

-- Cover + screenshots per game, stored as image strings (URL or base64), ordered.
CREATE TABLE IF NOT EXISTS game_images (
    id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
    fk_video_gameId INT NOT NULL,
    src MEDIUMTEXT NOT NULL,
    position INT NOT NULL DEFAULT 0,
    created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (fk_video_gameId) REFERENCES video_game(id) ON DELETE CASCADE
);

-- Price changes over time (for price-drop indicators and trend charts).
CREATE TABLE IF NOT EXISTS price_history (
    id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
    fk_video_gameId INT NOT NULL,
    price VARCHAR(100) NOT NULL,
    changed_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (fk_video_gameId) REFERENCES video_game(id) ON DELETE CASCADE
);

CREATE TABLE IF NOT EXISTS kaeufe (
    id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
    fk_usersId INT NOT NULL,
    fk_video_gameId INT NOT NULL,
    price_paid VARCHAR(100) NULL,
    purchased_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (fk_usersId) REFERENCES users(id),
    FOREIGN KEY (fk_video_gameId) REFERENCES video_game(id)
);

-- Simulated payment cards (dummy, never validated).
CREATE TABLE IF NOT EXISTS payment_cards (
    id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
    fk_usersId INT NOT NULL,
    cardholder VARCHAR(255) NOT NULL,
    number VARCHAR(40) NOT NULL,
    expiry VARCHAR(10) NOT NULL,
    brand VARCHAR(30) NULL,
    created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (fk_usersId) REFERENCES users(id) ON DELETE CASCADE
);

-- Directional friend rows (a friendship inserts both directions).
CREATE TABLE IF NOT EXISTS friends (
    id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
    fk_usersId INT NOT NULL,
    fk_friendId INT NOT NULL,
    created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    UNIQUE KEY uniq_friend_pair (fk_usersId, fk_friendId),
    FOREIGN KEY (fk_usersId) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (fk_friendId) REFERENCES users(id) ON DELETE CASCADE
);
