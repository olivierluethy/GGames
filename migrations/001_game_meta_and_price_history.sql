-- Migration 001: game metadata + price history
--
-- - add a `description` and `created_at` to games
-- - normalize prices to either 'Gratis' or a bare numeric string (drop " CHF")
-- - add a `price_history` table and seed an initial point per game
--
-- Apply to an existing database with:
--   docker exec -i ggames-db mysql -uroot -proot ggames < migrations/001_game_meta_and_price_history.sql
SET NAMES utf8mb4;
USE ggames;

ALTER TABLE video_game
    ADD COLUMN description TEXT NULL AFTER price,
    ADD COLUMN created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP AFTER description;

-- Stagger existing games so "latest added" ordering is meaningful in the demo
-- (higher id = added more recently).
UPDATE video_game SET created_at = (NOW() - INTERVAL (50 - id) HOUR);

-- Prices become 'Gratis' or a bare number (e.g. '69.95'); formatPrice() renders them.
UPDATE video_game SET price = TRIM(REPLACE(price, 'CHF', '')) WHERE price LIKE '%CHF%';

-- Short German descriptions for the seeded games (admin data is source of truth).
UPDATE video_game SET description = 'Der legendäre kompetitive Taktik-Shooter von Valve. Plane mit deinem Team, kaufe Waffen und sichere dir die Runde.' WHERE name LIKE 'Counter-Strike%';
UPDATE video_game SET description = 'Battle-Royale-Phänomen: 100 Spieler, eine Insel, ein Gewinner. Baue, kämpfe und überlebe in einer sich ständig verändernden Welt.' WHERE name = 'Fortnite';
UPDATE video_game SET description = 'Baue, erkunde und überlebe in einer unendlichen Welt aus Blöcken. Deiner Kreativität sind keine Grenzen gesetzt.' WHERE name = 'Minecraft';
UPDATE video_game SET description = 'Taktischer 5-gegen-5-Charakter-Shooter von Riot Games. Präzises Gunplay trifft auf einzigartige Agenten-Fähigkeiten.' WHERE name = 'Valorant';
UPDATE video_game SET description = 'Teambasierter Helden-Shooter mit farbenfrohen Charakteren und actiongeladenen 5-gegen-5-Gefechten.' WHERE name = 'Overwatch 2';
UPDATE video_game SET description = 'Das weltweit meistgespielte MOBA. Wähle aus über 160 Champions und kämpfe auf der Kluft der Beschwörer.' WHERE name = 'League of Legends';
UPDATE video_game SET description = 'Intensiver, filmreifer Militär-Shooter mit packender Kampagne und kompetitivem Mehrspieler-Modus.' WHERE name LIKE 'Call of Duty: Modern%';
UPDATE video_game SET description = 'Das kostenlose Battle-Royale der Call-of-Duty-Reihe. Riesige Karten, 150 Spieler, ein Sieger.' WHERE name LIKE 'Call of Duty: Warzone%';

CREATE TABLE IF NOT EXISTS price_history (
    id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
    fk_video_gameId INT NOT NULL,
    price VARCHAR(100) NOT NULL,
    changed_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (fk_video_gameId) REFERENCES video_game(id) ON DELETE CASCADE
);

-- Seed an initial price point for every existing game.
INSERT INTO price_history (fk_video_gameId, price, changed_at)
SELECT id, price, created_at FROM video_game;
