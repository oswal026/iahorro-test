<?php

/** @var \Laravel\Lumen\Routing\Router $router */

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

$router->get('/', function () use ($router) {
    return $router->app->version();
});

//EndPoint: show base data (experts and time zones)
$router->get('api/mortgage/base-data', 'MortgageController@index');

//EndPoint: store mortgage request in DB
$router->post('api/mortgage/store', 'MortgageController@store');

//EndPoint: show the available records by expert ID
$router->get('api/mortgage/expert/{id}', 'MortgageController@show');
