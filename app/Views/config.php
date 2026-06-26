<?php
/* Database credentials. Values come from the environment when set
(e.g. in Docker), and fall back to the local XAMPP defaults
(user 'root' with no password) otherwise. */
define('DB_SERVER', env('DB_HOST', 'localhost'));
define('DB_USERNAME', env('DB_USER', 'root'));
define('DB_PASSWORD', env('DB_PASS', ''));
define('DB_NAME', env('DB_NAME', 'ggames'));
 
/* Attempt to connect to MySQL database */
$link = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);
 
// Check connection
if($link === false){
    die("ERROR: Could not connect. " . mysqli_connect_error());
}
?>