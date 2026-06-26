-- Migration 004: simulated payment cards (dummy, NOT validated)
--
-- Cards are stored purely for the purchase simulation. Details are never
-- validated or processed. Do not store real card data here.
USE ggames;

CREATE TABLE IF NOT EXISTS payment_cards (
    id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
    fk_usersId INT NOT NULL,
    cardholder VARCHAR(255) NOT NULL,
    -- Stored as-is for the demo; never validated.
    number VARCHAR(40) NOT NULL,
    expiry VARCHAR(10) NOT NULL,
    brand VARCHAR(30) NULL,
    created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (fk_usersId) REFERENCES users(id) ON DELETE CASCADE
);

-- Give a couple of demo users a saved card so the flow is visible out of the box.
INSERT INTO payment_cards (fk_usersId, cardholder, number, expiry, brand) VALUES
    (1, 'Olivier Luethy', '4242 4242 4242 4242', '12/29', 'Visa'),
    (6, 'Mia Muster',     '5555 5555 5555 4444', '08/28', 'Mastercard');
