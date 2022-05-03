<?php
require 'core/bootstrap.php';

$routes = [
	/* Hauptseiten */
	'' => 'GGamesController@index',
	'home' => 'GGamesController@index',
	'store' => 'GGamesController@store',

	/* Spiele bearbeiten */
	'addGame' => 'GGamesController@addGame',
	'deleteGame' => 'GGamesController@deleteGame',
	'editGame' => 'GGamesController@editGame',

	/* Login */
	'login' => 'GGamesController@login',
	'config' => 'GGamesController@config',
	'register' => 'GGamesController@register',
	'logout' => 'GGamesController@logout',

	/* Spiel kaufen */
	'buyGame' => 'GGamesController@buyGame',

	/* Konto */
	'konto' => 'GGamesController@konto',
	'editKonto' => 'GGamesController@editKonto',
];

$db = [
	'name'     => 'ggames',
	'username' => 'root',
	'password' => '',
];

$router = new Router($routes);
$router->run($_GET['url'] ?? '');