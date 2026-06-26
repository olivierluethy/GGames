-- GGames mock data (runs automatically on first DB init).
-- Every seeded user has the password: password
USE ggames;

-- ---------------------------------------------------------------------------
-- Games (img must match a file in /assets)
-- ---------------------------------------------------------------------------
INSERT INTO video_game (id, name, entwickler, img, price) VALUES
    (1, 'Counter-Strike: Global Offensive', 'Valve',      'csgo.png',                     'Gratis'),
    (2, 'Fortnite',                         'Epic Games', 'fortnite.png',                 'Gratis'),
    (3, 'Minecraft',                        'Mojang',     'minecraft.png',                '23.95 CHF'),
    (4, 'Valorant',                         'Riot Games', 'valorant.jpg',                 'Gratis'),
    (5, 'Overwatch 2',                      'Blizzard',   'overwatch.png',                'Gratis'),
    (6, 'League of Legends',                'Riot Games', 'leagueoflegends.jpg',          'Gratis'),
    (7, 'Call of Duty: Modern Warfare',     'Activision', 'callofdutymodernwarfare.png',  '69.95 CHF'),
    (8, 'Call of Duty: Warzone',            'Activision', 'callofdutywarzone.png',        'Gratis');

-- ---------------------------------------------------------------------------
-- Users — password for ALL accounts is: password
-- istAdmin = 1 -> admin (can add/edit/delete games), 0 -> regular user
-- ---------------------------------------------------------------------------
INSERT INTO users (id, email, password, username, istAdmin) VALUES
    (1, 'olivier@ggames.test', '$2y$10$gECaHbwq1uKmLTypunTikeMTM/MF2zHysjPel0SvE67klXZHfsere', 'Olivier', 1),
    (2, 'sarah@ggames.test',   '$2y$10$gECaHbwq1uKmLTypunTikeMTM/MF2zHysjPel0SvE67klXZHfsere', 'Sarah',   1),
    (3, 'max@ggames.test',     '$2y$10$gECaHbwq1uKmLTypunTikeMTM/MF2zHysjPel0SvE67klXZHfsere', 'Max',     0),
    (4, 'lena@ggames.test',    '$2y$10$gECaHbwq1uKmLTypunTikeMTM/MF2zHysjPel0SvE67klXZHfsere', 'Lena',    0),
    (5, 'jonas@ggames.test',   '$2y$10$gECaHbwq1uKmLTypunTikeMTM/MF2zHysjPel0SvE67klXZHfsere', 'Jonas',   0),
    (6, 'mia@ggames.test',     '$2y$10$gECaHbwq1uKmLTypunTikeMTM/MF2zHysjPel0SvE67klXZHfsere', 'Mia',     0);

-- ---------------------------------------------------------------------------
-- Purchases (kaeufe) — varied so each account shows different data:
--   Olivier: a few games   Sarah: a couple   Max: a few
--   Lena: one              Jonas: none (empty library test)   Mia: owns everything
-- ---------------------------------------------------------------------------
INSERT INTO kaeufe (fk_usersId, fk_video_gameId) VALUES
    (1, 1), (1, 3), (1, 7),
    (2, 2), (2, 4),
    (3, 1), (3, 2), (3, 5),
    (4, 6),
    (6, 1), (6, 2), (6, 3), (6, 4), (6, 5), (6, 6), (6, 7), (6, 8);
