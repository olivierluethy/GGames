<?php

function connectDatabase() {
    // Credentials come from the single source of truth: dbConfig() (core/helpers.php).
    $c = dbConfig();

    try {
        return new PDO('mysql:host=' . $c['host'] . ';dbname=' . $c['name'] . ';charset=utf8mb4', $c['user'], $c['pass']);
    } catch (PDOException $e) {
        die('Keine Verbindung zur Datenbank möglich: ' . $e->getMessage());
    }
}