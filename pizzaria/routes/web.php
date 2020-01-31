<?php

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

$router->group(['prefix' => 'clients'], function () use ($router) {
    $router->get('/', 'ClientController@index');
    $router->get('/{id}', 'ClientController@show');
    $router->post('/', 'ClientController@store');
    $router->put('/{id}', 'ClientController@update');
    $router->delete('/{id}', 'ClientController@destroy');
});

$router->group(['prefix' => 'pizzas'], function () use ($router) {
    $router->get('/', 'PizzaController@index');
    $router->get('/{id}', 'PizzaController@show');
    $router->post('/', 'PizzaController@store');
    $router->put('/{id}', 'PizzaController@update');
    $router->delete('/{id}', 'PizzaController@destroy');
});


$router->group(['prefix' => 'orders'], function () use ($router) {
    $router->get('/', 'OrdersController@index');
    $router->get('/{id}', 'OrdersController@show');
    $router->post('/', 'OrdersController@store');
    $router->put('/{id}', 'OrdersController@update');
    $router->delete('/{id}', 'OrdersController@destroy');
    $router->get('/client/{id}', 'OrdersController@show_client_orders');

});
