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
    $router->post('/adduser/',['middleware'=>'auth','uses'=>'UserController@addUser']);
    $router->get('/getusers',['middleware'=>'auth', 'uses'=>'UserController@getUsers']);
    $router->get('/getuser',['middleware'=>'auth', 'uses'=>'UserController@getUser']);
    $router->get('/editusername',['middleware'=>'auth', 'uses'=>'UserController@editUserName']);
    $router->post('/edituserrole',['middleware'=>'auth','uses'=>'UserController@editUserRole']);
    $router->post('/edituserpassword',['middleware'=>'auth','uses'=>'UserController@editUserPassword']);
    $router->post('/deleteuser',['middleware'=>'auth','uses'=>'UserController@deleteUser']);
    $router->post('/addhostel',['middleware'=>'auth','uses'=>'HostelController@addHostel']); 
    $router->get('/gethostels',['middleware'=>'auth','uses'=>'HostelController@getHostels']);
    $router->get('/gethostel',['middleware'=>'auth','uses'=>'HostelController@getHostel']);
    $router->post('/edithostelname',['middleware'=>'auth','uses'=>'HostelController@editHostelName']);
    $router->post('/edithosteldescription',['middleware'=>'auth','uses'=>'HostelController@editHostelDescription']);
    $router->post('/editnumberofrooms',['middleware'=>'auth','uses'=>'HostelController@editNumberOfRooms']);
    $router->post('/deletehostel',['middleware'=>'auth','uses'=>'HostelController@deleteHostel']);
    $router->post('/addroom',['middleware'=>'auth','uses'=>'RoomController@addRoom']);
    $router->get('/getrooms',['middleware'=>'auth','uses'=>'RoomController@getRooms']);
    $router->get('/getroom',['middleware'=>'auth','uses'=>'RoomController@getRoom']);
    $router->post('/editroomname',['middleware'=>'auth','uses'=>'RoomController@editRoomName']);
    $router->post('/editroomdescription',['middleware'=>'auth','uses'=>'RoomController@editRoomDescription']);
    $router->post('/editcurrentnoofbeds',['middleware'=>'auth','uses'=>'RoomController@editCurrentNoOfBeds']);
    $router->post('/editroomstatus',['middleware'=>'auth','uses'=>'RoomController@editStatus']);
    $router->post('/editroomgender',['middleware'=>'auth','uses'=>'RoomController@editGender']);
    $router->post('/editroomcapacity',['middleware'=>'auth','uses'=>'RoomController@editCapacity']);
    $router->post('/editnoofbedsreserved',['middleware'=>'auth','uses'=>'RoomController@editNoofBedsreserved']);
    $router->post('/deleteroom',['middleware'=>'auth','uses'=>'RoomController@deleteRoom']);
    $router->post('/addyear',['middleware'=>'auth','uses'=>'SemesterController@addYear']);
    $router->get('/getyears',['middleware'=>'auth','uses'=>'SemesterController@getYears']);
    $router->get('/getyear',['middleware'=>'auth','uses'=>'SemesterController@getYear']);
    $router->post('/edityear',['middleware'=>'auth','uses'=>'SemesterController@editYear']);
    $router->post('/deleteyear',['middleware'=>'auth','uses'=>'SemesterController@deleteYear']);
    $router->post('/addsemester',['middleware'=>'auth','uses'=>'SemesterController@addSemester']);
    $router->get('/getsemesters',['middleware'=>'auth','uses'=>'SemesterController@getSemesters']);
    $router->get('/getsemester',['middleware'=>'auth','uses'=>'SemesterController@getSemester']);
    $router->post('/editsemester',['middleware'=>'auth','uses'=>'SemesterController@editSemester']);
    $router->post('/deletesemester',['middleware'=>'auth','uses'=>'SemesterController@deleteSemester']);
    $router->post('/addoccupant',['middleware'=>'auth','uses'=>'OccupantController@addOccupant']);
    $router->get('/getoccupants',['middleware'=>'auth','uses'=>'OccupantController@getOccupants']);
    $router->get('/getoccupant',['middleware'=>'auth','uses'=>'OccupantController@getOccupant']);
    $router->post('/editoccupantfirstname',['middleware'=>'auth','uses'=>'OccupantController@editFirstName']);
    $router->post('/editoccupantlastname',['middleware'=>'auth','uses'=>'OccupantController@editLastName']);
    $router->post('/editoccupantemail',['middleware'=>'auth','uses'=>'OccupantController@editEmail']);
    $router->post('/editoccupantremarks',['middleware'=>'auth','uses'=>'OccupantController@editRemarks']);
    $router->post('/editoccupantstatus',['middleware'=>'auth','uses'=>'OccupantController@editStatus']);
    $router->post('/editoccupantisdeleted',['middleware'=>'auth','uses'=>'OccupantController@editIsDeleted']);
    $router->post('/editoccupantgender',['middleware'=>'auth','uses'=>'OccupantController@editGender']);
    $router->post('/editoccupantphonenumber',['middleware'=>'auth','uses'=>'OccupantController@editPhoneNumber']);
    $router->post('/editoccupantimagelink',['middleware'=>'auth','uses'=>'OccupantController@editImageLink']);
    $router->post('/addroomassignment',['middleware'=>'auth','uses'=>'RoomAssignmentController@addRoomAssignment']);
    $router->get('/getcurrentroomassignments',['middleware'=>'auth','uses'=>'RoomAssignmentController@getCurrentRoomAssignments']);
    $router->get('/getoccupantroomassignment',['middleware'=>'auth','uses'=>'RoomAssignmentController@getOccupantRoomAssignment']);
    $router->get('/getroomassignment',['middleware'=>'auth','uses'=>'RoomAssignmentController@getRoomAssignment']);
    $router->post('/editroomassignment',['middleware'=>'auth','uses'=>'RoomAssignmentController@editRoomAssignment']);
    $router->post('/editroomassignmentsettings',['middleware'=>'auth','uses'=>'RoomAssignmentController@editSettings']);
    $router->post('/deleteroomassignment',['middleware'=>'auth','uses'=>'RoomAssignmentController@deleteRoomAssignment']);
    $router->get('/getpreviousroomassignments',['middleware'=>'auth','uses'=>'RoomAssignmentController@getPreviousRoomAssignments']);

});
