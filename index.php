<?php
require 'core/bootstrap.php';

$routes = [
	/* Hauptseiten */
	'/shop/home' => 'WelcomeController@index',
	'/shop/store' => 'WelcomeController@store',

	/* Spiele bearbeiten */
	'/shop/addGame' => 'WelcomeController@addGame',
	'/shop/deleteGame' => 'WelcomeController@deleteGame',
	'/shop/editGame' => 'WelcomeController@editGame',

	/* Login */
	'/shop/login' => 'WelcomeController@login',
	'/shop/config' => 'WelcomeController@config',
	'/shop/register' => 'WelcomeController@register',
	'/shop/logout' => 'WelcomeController@logout',

	/* Spiel kaufen */
	'/shop/buyGame' => 'WelcomeController@buyGame',

	/* Konto */
	'/shop/konto' => 'WelcomeController@konto',
	'/shop/editKonto' => 'WelcomeController@editKonto',
];

$db = [
	'name'     => 'ggames',
	'username' => 'root',
	'password' => '',
];

$router = new Router($routes);
$router->run($_GET['url'] ?? '');