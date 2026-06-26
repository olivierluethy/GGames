<?php
/* mysqli connection for the login/register flow. Credentials come from the
   single source of truth: dbConfig() (core/helpers.php). */
$c = dbConfig();
$link = mysqli_connect($c['host'], $c['user'], $c['pass'], $c['name']);

// Check connection
if($link === false){
    die("ERROR: Could not connect. " . mysqli_connect_error());
}

// Ensure the connection speaks UTF-8 so German umlauts are handled correctly.
mysqli_set_charset($link, 'utf8mb4');
?>