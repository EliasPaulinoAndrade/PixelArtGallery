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
    return Redirect::action('HomeController@index');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::get('/peca/byDate/{begin}/{end}', 'PecaController@pecasByDate');
Route::get('/peca/byEvaluation/{begin}/{end}', 'PecaController@pecasByEvaluation');
Route::resource('/peca', 'PecaController');

Route::resource('/usuario', 'UsuarioController');
Route::post('/usuario/{id}/seguir', 'UsuarioController@seguir')->name("usuario.seguir");

Route::resource('/comentario', 'ComentarioController');