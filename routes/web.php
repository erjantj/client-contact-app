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

$router->group([
    'prefix' => 'api/v1',
], function ($router) {

    // Client
    $router->get('/client', 'ClientController@all');
    $router->post('/client', 'ClientController@create');
    $router->get('/client/{id}', 'ClientController@get');
    $router->post('/client/{id}', 'ClientController@update');
    $router->delete('/client/{id}', 'ClientController@delete');
    $router->post('/client/import', 'ClientController@import');

    // Client contacts
    $router->get('/client-contact', 'ClientContactController@all');
    $router->post('/client/{clientId}/contact', 'ClientContactController@createUserContact');
    $router->get('/client/{clientId}/contact', 'ClientContactController@userContacts');
    $router->get('/client/{clientId}/contact/{contactId}', 'ClientContactController@get');
    $router->post('/client/{clientId}/contact/{contactId}', 'ClientContactController@update');
    $router->delete('/client/{clientId}/contact/{contactId}', 'ClientContactController@delete');

});
