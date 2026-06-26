-- Migration 003: purchase price + timestamp
--
-- Record the price paid and when each purchase happened, so the library can
-- show purchase dates and price analytics can count buyers per price point.
USE ggames;

ALTER TABLE kaeufe
    ADD COLUMN price_paid VARCHAR(100) NULL AFTER fk_video_gameId,
    ADD COLUMN purchased_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP AFTER price_paid;

-- Backfill existing purchases with the game's current price and a staggered
-- purchase date so the demo library looks realistic.
UPDATE kaeufe k
JOIN video_game v ON v.id = k.fk_video_gameId
SET k.price_paid = v.price,
    k.purchased_at = (NOW() - INTERVAL (k.id) DAY)
WHERE k.price_paid IS NULL;
