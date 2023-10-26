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
    $arr = [
        'php_version' => phpversion(),
        'app_version' => $router->app->version()
    ];
    return $arr;
});

$router->group(['prefix' => 'cobranca'], function() use ($router){
    $router->post('save-file', ['uses' => 'CobrancaController@saveFile']);
    $router->post('list-file', ['uses' => 'CobrancaController@listFile']);
});

