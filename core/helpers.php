<?php
/**
 * Nutze diese Funktion um einfach eine Ausgabe
 * mit htmlspecialchars() zu erstellen.
 */
function e(string $value): string
{
    return htmlspecialchars($value, ENT_QUOTES, 'UTF-8', false);
}

/**
 * Nutze diese Funktion um auf einen POST-Wert
 * zuzugreifen.
 */
function post(string $key, $default = '')
{
    return $_POST[$key] ?? $default;
}

/**
 * Liest einen Wert aus der Umgebung (Environment) und gibt
 * andernfalls den Standardwert zurück. So lässt sich die App
 * sowohl lokal (XAMPP) als auch in Docker konfigurieren.
 */
function env(string $key, $default = null)
{
    $value = getenv($key);

    if ($value === false) {
        $value = $_ENV[$key] ?? $_SERVER[$key] ?? false;
    }

    return $value === false ? $default : $value;
}

/**
 * Returns true if a user is currently logged in.
 */
function isLoggedIn(): bool
{
    return isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true;
}

/**
 * Returns true if the logged-in user is an admin (istAdmin flag).
 */
function isAdmin(): bool
{
    return isLoggedIn() && isset($_SESSION['istAdmin']) && (string) $_SESSION['istAdmin'] === '1';
}

/**
 * Returns the current user's id, or null when logged out.
 */
function currentUserId(): ?int
{
    return isset($_SESSION['id']) ? (int) $_SESSION['id'] : null;
}

/**
 * Formats a price the way the store expects it: the literal string
 * "Gratis" stays as-is, numeric values are rendered as "X.XX CHF".
 */
function formatPrice($price): string
{
    if ($price === null || $price === '' || strcasecmp((string) $price, 'Gratis') === 0) {
        return 'Gratis';
    }

    if (is_numeric($price)) {
        return number_format((float) $price, 2) . ' CHF';
    }

    return (string) $price;
}

/**
 * THE single source of truth for database credentials.
 *
 * Every connection (PDO and mysqli) reads its settings from here, so to point
 * the app at a different database you only change this one place (or override
 * via the DB_* environment variables, e.g. in docker-compose.yml).
 */
function dbConfig(): array
{
    return [
        'host' => env('DB_HOST', '127.0.0.1'),
        'name' => env('DB_NAME', 'ggames'),
        'user' => env('DB_USER', 'root'),
        'pass' => env('DB_PASS', ''),
    ];
}