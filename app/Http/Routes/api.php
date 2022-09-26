<?php

/**
 * @var $router EventManagementSystem\App\Http\Router
 */

// $router->get('/welcome', 'WelcomeController@index');
$router->post('/inputData', 'EventController@inputform');
$router->get('/eventData', 'EventController@eventData');
$router->get('/singleEventData/{id}', 'EventController@singleEventData')->int('id');
$router->put('/updateEventData/{id}', 'EventController@updateEventData')->int('id');
$router->delete('/deleteEvent/{id}', 'EventController@deleteEventData')->int('id');
