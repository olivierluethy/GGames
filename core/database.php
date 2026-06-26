<?php

function connectDatabase() {
    $host = env('DB_HOST', '127.0.0.1');
    $name = env('DB_NAME', 'ggames');
    $user = env('DB_USER', 'root');
    $pass = env('DB_PASS', '');

    try {
        return new PDO('mysql:host=' . $host . ';dbname=' . $name . ';charset=utf8mb4', $user, $pass);
    } catch (PDOException $e) {
        die('Keine Verbindung zur Datenbank möglich: ' . $e->getMessage());
    }
}