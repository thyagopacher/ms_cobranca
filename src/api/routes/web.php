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

$router->group(['prefix' => 'cobranca', 'middleware' => ['cors']], function() use ($router){

    //para controlar as planilhas importadas
    $router->group(['prefix' => 'importacao'], function() use ($router){
        $router->post('save-file', ['uses' => 'ImportacaoController@saveFile']);
        $router->get('find-file/{id}', ['uses' => 'ImportacaoController@findById']);
        $router->post('list-file', ['uses' => 'ImportacaoController@listFile']);
        $router->get('list-file', ['uses' => 'ImportacaoController@listFile']);
        $router->delete('delete-file/{id}', ['uses' => 'ImportacaoController@deleteFile']);    
    });

    // para saber as linhas da planilha que foram importadas
    $router->group(['prefix' => 'processamento'], function() use ($router){
        $router->post('save-cobranca', ['uses' => 'CobrancaController@saveCobranca']);
        $router->get('find-cobranca/{id}', ['uses' => 'CobrancaController@findByIdCobranca']);
        $router->post('list-cobranca', ['uses' => 'CobrancaController@listCobranca']);
        $router->get('list-cobranca', ['uses' => 'CobrancaController@listCobranca']);
        $router->delete('delete-cobranca/{id}', ['uses' => 'CobrancaController@deleteCobranca']);    
    });

    // rotas para controle do e-mail que foi enviado
    $router->group(['prefix' => 'mail'], function() use ($router){
        $router->post('save-email', ['uses' => 'EmailController@saveEmail']);
        $router->get('find-email/{id}', ['uses' => 'EmailController@findByIdEmail']);
        $router->post('list-email', ['uses' => 'EmailController@listEmail']);
        $router->get('list-email', ['uses' => 'EmailController@listEmail']);
        $router->delete('delete-email/{id}', ['uses' => 'EmailController@deleteEmail']);
        $router->delete('send-email-cobranca', ['uses' => 'EmailController@sendEmailCobranca']);
    });

});

