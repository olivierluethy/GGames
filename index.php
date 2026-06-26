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
	'gamedetail' => 'GGamesController@gameDetail',

	/* Login */
	'login' => 'GGamesController@login',
	'config' => 'GGamesController@config',
	'register' => 'GGamesController@register',
	'logout' => 'GGamesController@logout',

	/* Spiel kaufen */
	'buyGame' => 'GGamesController@buyGame',

	/* Spiel zurückgeben */
	'returnGame' => 'GGamesController@returnGame',

	/* Konto */
	'konto' => 'GGamesController@konto',
	'editKonto' => 'GGamesController@editKonto',

	/* Zahlung (simuliert) */
	'addCard' => 'GGamesController@addCard',
	'deleteCard' => 'GGamesController@deleteCard',
];

$db = [
	'name'     => 'ggames',
	'username' => 'root',
	'password' => '',
];

$router = new Router($routes);
$router->run($_GET['url'] ?? '');