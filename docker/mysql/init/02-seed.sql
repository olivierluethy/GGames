-- GGames mock data (runs automatically on first DB init).
-- Every seeded user has the password: password
SET NAMES utf8mb4;
USE ggames;

-- ---------------------------------------------------------------------------
-- Games. price = 'Gratis' or a bare number; img is legacy (see game_images).
-- created_at is staggered so "latest added" ordering is meaningful.
-- ---------------------------------------------------------------------------
INSERT INTO video_game (id, name, entwickler, img, price, description, created_at) VALUES
    (1, 'Counter-Strike: Global Offensive', 'Valve',      'csgo.png',                     'Gratis',  'Der legendäre kompetitive Taktik-Shooter von Valve. Plane mit deinem Team, kaufe Waffen und sichere dir die Runde.', NOW() - INTERVAL 49 HOUR),
    (2, 'Fortnite',                         'Epic Games', 'fortnite.png',                 'Gratis',  'Battle-Royale-Phänomen: 100 Spieler, eine Insel, ein Gewinner. Baue, kämpfe und überlebe in einer sich ständig verändernden Welt.', NOW() - INTERVAL 42 HOUR),
    (3, 'Minecraft',                        'Mojang',     'minecraft.png',                '23.95',   'Baue, erkunde und überlebe in einer unendlichen Welt aus Blöcken. Deiner Kreativität sind keine Grenzen gesetzt.', NOW() - INTERVAL 36 HOUR),
    (4, 'Valorant',                         'Riot Games', 'valorant.jpg',                 'Gratis',  'Taktischer 5-gegen-5-Charakter-Shooter von Riot Games. Präzises Gunplay trifft auf einzigartige Agenten-Fähigkeiten.', NOW() - INTERVAL 28 HOUR),
    (5, 'Overwatch 2',                      'Blizzard',   'overwatch.png',                'Gratis',  'Teambasierter Helden-Shooter mit farbenfrohen Charakteren und actiongeladenen 5-gegen-5-Gefechten.', NOW() - INTERVAL 20 HOUR),
    (6, 'League of Legends',                'Riot Games', 'leagueoflegends.jpg',          'Gratis',  'Das weltweit meistgespielte MOBA. Wähle aus über 160 Champions und kämpfe auf der Kluft der Beschwörer.', NOW() - INTERVAL 12 HOUR),
    (7, 'Call of Duty: Modern Warfare',     'Activision', 'callofdutymodernwarfare.png',  '49.95',   'Intensiver, filmreifer Militär-Shooter mit packender Kampagne und kompetitivem Mehrspieler-Modus.', NOW() - INTERVAL 6 HOUR),
    (8, 'Call of Duty: Warzone',            'Activision', 'callofdutywarzone.png',        'Gratis',  'Das kostenlose Battle-Royale der Call-of-Duty-Reihe. Riesige Karten, 150 Spieler, ein Sieger.', NOW() - INTERVAL 1 HOUR);

-- ---------------------------------------------------------------------------
-- Game images (URL/base64). Demo art lives under assets/ and is stored as a
-- relative URL. A few games get extra "screenshots" to show the hover carousel.
-- ---------------------------------------------------------------------------
INSERT INTO game_images (fk_video_gameId, src, position) VALUES
    (1, 'assets/csgo.png', 0),
    (1, 'assets/keyboard-gaming-moody-gamer-3165335.jpg', 1),
    (2, 'assets/fortnite.png', 0),
    (2, 'assets/welcome.jpg', 1),
    (3, 'assets/minecraft.png', 0),
    (3, 'assets/keyboard-gaming-moody-gamer-3165335.jpg', 1),
    (4, 'assets/valorant.jpg', 0),
    (4, 'assets/welcome.jpg', 1),
    (5, 'assets/overwatch.png', 0),
    (6, 'assets/leagueoflegends.jpg', 0),
    (7, 'assets/callofdutymodernwarfare.png', 0),
    (7, 'assets/callofdutywarzone.png', 1),
    (8, 'assets/callofdutywarzone.png', 0),
    (8, 'assets/callofdutymodernwarfare.png', 1);

-- ---------------------------------------------------------------------------
-- Price history. Most games have a single point; CoD: Modern Warfare shows a
-- price drop (69.95 -> 49.95) to demonstrate trends and the drop indicator.
-- ---------------------------------------------------------------------------
INSERT INTO price_history (fk_video_gameId, price, changed_at) VALUES
    (1, 'Gratis', NOW() - INTERVAL 49 HOUR),
    (2, 'Gratis', NOW() - INTERVAL 42 HOUR),
    (3, '23.95',  NOW() - INTERVAL 36 HOUR),
    (4, 'Gratis', NOW() - INTERVAL 28 HOUR),
    (5, 'Gratis', NOW() - INTERVAL 20 HOUR),
    (6, 'Gratis', NOW() - INTERVAL 12 HOUR),
    (7, '69.95',  NOW() - INTERVAL 6 HOUR),
    (7, '49.95',  NOW() - INTERVAL 2 HOUR),
    (8, 'Gratis', NOW() - INTERVAL 1 HOUR);

-- ---------------------------------------------------------------------------
-- Users — password for ALL accounts is: password
-- istAdmin = 1 -> admin (manage games), 0 -> regular user
-- ---------------------------------------------------------------------------
INSERT INTO users (id, email, password, username, istAdmin) VALUES
    (1, 'olivier@ggames.test', '$2y$10$gECaHbwq1uKmLTypunTikeMTM/MF2zHysjPel0SvE67klXZHfsere', 'Olivier', 1),
    (2, 'sarah@ggames.test',   '$2y$10$gECaHbwq1uKmLTypunTikeMTM/MF2zHysjPel0SvE67klXZHfsere', 'Sarah',   1),
    (3, 'max@ggames.test',     '$2y$10$gECaHbwq1uKmLTypunTikeMTM/MF2zHysjPel0SvE67klXZHfsere', 'Max',     0),
    (4, 'lena@ggames.test',    '$2y$10$gECaHbwq1uKmLTypunTikeMTM/MF2zHysjPel0SvE67klXZHfsere', 'Lena',    0),
    (5, 'jonas@ggames.test',   '$2y$10$gECaHbwq1uKmLTypunTikeMTM/MF2zHysjPel0SvE67klXZHfsere', 'Jonas',   0),
    (6, 'mia@ggames.test',     '$2y$10$gECaHbwq1uKmLTypunTikeMTM/MF2zHysjPel0SvE67klXZHfsere', 'Mia',     0);

-- ---------------------------------------------------------------------------
-- Saved (dummy) payment cards.
-- ---------------------------------------------------------------------------
INSERT INTO payment_cards (fk_usersId, cardholder, number, expiry, brand) VALUES
    (1, 'Olivier Luethy', '4242 4242 4242 4242', '12/29', 'Visa'),
    (6, 'Mia Muster',     '5555 5555 5555 4444', '08/28', 'Mastercard');

-- ---------------------------------------------------------------------------
-- Purchases with price paid + date. Olivier and Mia bought CoD:MW at the old
-- 69.95 price (before the drop), which the analytics can surface.
-- ---------------------------------------------------------------------------
INSERT INTO kaeufe (fk_usersId, fk_video_gameId, price_paid, purchased_at) VALUES
    (1, 1, 'Gratis', NOW() - INTERVAL 40 HOUR),
    (1, 3, '23.95',  NOW() - INTERVAL 30 HOUR),
    (1, 7, '69.95',  NOW() - INTERVAL 5 HOUR),
    (2, 2, 'Gratis', NOW() - INTERVAL 38 HOUR),
    (2, 4, 'Gratis', NOW() - INTERVAL 26 HOUR),
    (3, 1, 'Gratis', NOW() - INTERVAL 35 HOUR),
    (3, 2, 'Gratis', NOW() - INTERVAL 24 HOUR),
    (3, 5, 'Gratis', NOW() - INTERVAL 18 HOUR),
    (4, 6, 'Gratis', NOW() - INTERVAL 10 HOUR),
    (6, 1, 'Gratis', NOW() - INTERVAL 48 HOUR),
    (6, 2, 'Gratis', NOW() - INTERVAL 41 HOUR),
    (6, 3, '23.95',  NOW() - INTERVAL 33 HOUR),
    (6, 4, 'Gratis', NOW() - INTERVAL 27 HOUR),
    (6, 5, 'Gratis', NOW() - INTERVAL 19 HOUR),
    (6, 6, 'Gratis', NOW() - INTERVAL 11 HOUR),
    (6, 7, '69.95',  NOW() - INTERVAL 4 HOUR),
    (6, 8, 'Gratis', NOW() - INTERVAL 1 HOUR);

-- ---------------------------------------------------------------------------
-- Friendships (both directions per pair).
-- ---------------------------------------------------------------------------
INSERT INTO friends (fk_usersId, fk_friendId) VALUES
    (1, 2), (2, 1),
    (1, 3), (3, 1),
    (1, 6), (6, 1),
    (3, 4), (4, 3),
    (3, 6), (6, 3),
    (2, 4), (4, 2);
