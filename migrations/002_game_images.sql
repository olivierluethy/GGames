-- Migration 002: per-game images (URL or base64), ordered
--
-- Covers/screenshots are stored as image strings (URL or base64), entered by
-- the admin. This replaces the single `video_game.img` filename coupling.
-- The legacy `img` column is kept for backwards-compat but is no longer the
-- source of truth.
USE ggames;

CREATE TABLE IF NOT EXISTS game_images (
    id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
    fk_video_gameId INT NOT NULL,
    -- MEDIUMTEXT so base64 data URIs fit.
    src MEDIUMTEXT NOT NULL,
    position INT NOT NULL DEFAULT 0,
    created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (fk_video_gameId) REFERENCES video_game(id) ON DELETE CASCADE
);

-- Backfill: migrate the existing cover filename into game_images as the first
-- image. Existing demo art lives under assets/, so we store it as a relative
-- URL (the UI renders whatever string is here as an <img src>).
INSERT INTO game_images (fk_video_gameId, src, position)
SELECT id, CONCAT('assets/', img), 0
FROM video_game
WHERE img IS NOT NULL AND img <> '';
