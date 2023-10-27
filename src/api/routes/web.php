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

    $router->post('save-file', ['uses' => 'ImportacaoController@saveFile']);
    $router->get('find-file/{id}', ['uses' => 'ImportacaoController@findById']);
    $router->post('list-file', ['uses' => 'ImportacaoController@listFile']);
    $router->delete('delete-file/{id}', ['uses' => 'ImportacaoController@deleteFile']);    
    
    $router->post('save-cobranca', ['uses' => 'CobrancaController@saveCobranca']);
    $router->get('find-cobranca/{id}', ['uses' => 'CobrancaController@findByIdCobranca']);
    $router->post('list-cobranca', ['uses' => 'CobrancaController@listCobranca']);
    $router->delete('delete-cobranca/{id}', ['uses' => 'CobrancaController@deleteCobranca']);

});

