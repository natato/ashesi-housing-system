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

$router->group(['prefix' => 'api'], function($router){
    $router->post('/login','UserController@login');
    $router->post('/adduser/','UserController@addUser');
    $router->get('/getusers',['middleware'=>'auth', 'uses'=>'UserController@getUsers']);
    $router->get('/getuser',['middleware'=>'auth', 'uses'=>'UserController@getUser']);
    $router->get('/editusername',['middleware'=>'auth', 'uses'=>'UserController@editUserName']);
    $router->post('/edituserrole',['middleware'=>'auth','uses'=>'UserController@editUserRole']);
    $router->post('/edituserpassword',['middleware'=>'auth','uses'=>'UserController@editUserPassword']);
    $router->post('/addhostel',['middleware'=>'auth','uses'=>'HostelController@addHostel']); 
    $router->get('/gethostels',['middleware'=>'auth','uses'=>'HostelController@getHostels']);
    $router->get('/gethostel',['middleware'=>'auth','uses'=>'HostelController@getHostel']);
    $router->post('/edithostelname','HostelController@editHostelName');
    $router->post('/edithosteldescription','HostelController@editHostelDescription');
    $router->post('/editnumberofrooms','HostelController@editNumberOfRooms');
});
