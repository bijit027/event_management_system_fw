<?php

/**
 * @var $router EventManagementSystem\App\Http\Router
 */

$router->get('/welcome', 'WelcomeController@index');
$router->post('/inputData', 'WelcomeController@inputform');
$router->get('/eventData', 'WelcomeController@eventData');
$router->get('/singleEventData/{id}', 'WelcomeController@singleEventData')->int('id');
$router->delete('/deleteEvent/{id}', 'WelcomeController@deleteEventData')->int('id');
