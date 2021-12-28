<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::group(['prefix' => 'admin',  'middleware' => 'auth'], function() {
    //create
    Route::get('/create/exercise/quantity', 'ExerciseController@createQuantity')->name('exercise-create-quantity');
    Route::get('/store/exercise/quantity', 'ExerciseController@storeQuantity')->name('exercise-store-quantity');

    Route::get('/create/exercise', 'ExerciseController@create')->name('exercise-create');
    Route::post('/store/exercise', 'ExerciseController@store')->name('exercise-store');
    //list
    Route::get('/list/exercise', 'ExerciseController@show')->name('exercise-list');
    //edit
    Route::get('/edit/exercise/{exercise}', 'ExerciseController@edit')->name('exercise-edit');
    Route::post('/update/exercise/{exercise}', 'ExerciseController@update')->name('exercise-update');
    //delete
    Route::post('/delete/exercise/{exercise}', 'ExerciseController@destroy')->name('exercise-delete');
});

Route::get('/api/videos/{path}', 'ExerciseController@getVideo')->middleware("cors");

Route::get('/api/img/{path}', function (League\Glide\Server $server, $path, Illuminate\Http\Request $request) {
    $server->outputImage($path, $request->all());
})->where('path', '.+')->middleware("cors");




