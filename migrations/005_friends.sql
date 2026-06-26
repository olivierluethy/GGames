-- Migration 005: friend relationships
--
-- Friendships are stored as directional rows (one per direction) so "friends
-- of user X" is a simple lookup. Creating a friendship inserts both directions.
USE ggames;

CREATE TABLE IF NOT EXISTS friends (
    id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
    fk_usersId INT NOT NULL,
    fk_friendId INT NOT NULL,
    created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    UNIQUE KEY uniq_friend_pair (fk_usersId, fk_friendId),
    FOREIGN KEY (fk_usersId) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (fk_friendId) REFERENCES users(id) ON DELETE CASCADE
);

-- Seed mutual friendships (both directions) among the demo users:
-- Olivier(1) <-> Sarah(2), Max(3), Mia(6);  Max(3) <-> Lena(4), Mia(6);  Sarah(2) <-> Lena(4)
INSERT INTO friends (fk_usersId, fk_friendId) VALUES
    (1, 2), (2, 1),
    (1, 3), (3, 1),
    (1, 6), (6, 1),
    (3, 4), (4, 3),
    (3, 6), (6, 3),
    (2, 4), (4, 2);
