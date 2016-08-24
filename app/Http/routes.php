<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::post('football-data', 'UpdateController@update');

Route::get('home', 'HomeController@index');
Route::post('home', 'HomeController@joinGroup');


Route::get('admin/user', 'UserController@edit');
Route::post('admin/user', 'UserController@update');


Route::delete('admin/group', 'GroupController@destroyFast');
Route::resource('admin/group', 'GroupController');


Route::get('group/{id}/manage', 'TippAdminController@manage');
Route::post('group/{id}/manage', 'TippAdminController@manageUpdate');

Route::get('group/{id}/results', 'TippController@show');
Route::get('group/{id}/tipp', 'TippController@edit');
Route::post('group/{id}/tipp', 'TippController@update');
Route::get('group/{id}/ranking', 'TippController@rank');



Route::auth();


