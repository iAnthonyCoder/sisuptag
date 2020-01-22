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


Route::get('/', 'WelcomeController@welcome');

Route::get('createcaptcha', 'CaptchaController@create');
Route::post('captcha', 'CaptchaController@captchaValidate');
Route::get('captchaRefresh', 'CaptchaController@refreshCaptcha');





Route::get('modulos/lista', 'moduloController@indexGet');

Route::get('documentos/listaPublica/{id}', 'documentoController@indexGetPublic');
Route::get('documentos/lista/{id}', 'documentoController@indexGet');
Route::get('guest', 'documentoController@indexGetAll');
Route::get('documentos/indexGetFirst', 'documentoController@indexGetFirst');
Route::get('documentos/indexGetFirstPublic', 'documentoController@indexGetFirstPublic');
Route::get('documentos/generatePdf/{id}', 'documentoController@generatePdf');
Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::middleware(['auth','checkIsEnabled'])->group(function () {


    Route::get('profile', 'UserController@profile');
    Route::get('changePassword', 'UserController@changePassword');
    Route::group(['middleware' => 'App\Http\Middleware\filter'], function()
    {
        Route::get('logs/lista', 'logController@indexGet');
        Route::resource('logs','logController');
        Route::get('restores/lista', 'restoreController@indexGet');
        Route::resource('restores','restoreController');
        Route::get('bitacora/lista', 'bitacoraController@indexGet');
        Route::resource('bitacora','bitacoraController');
        Route::get('laravel-send-email', 'EmailController@sendEMail');
        Route::resource('modulos', 'moduloController',['Except' => 'indexGetAll']);
        Route::get('users/lista', 'UserController@indexGet');
        Route::resource('users', 'UserController');
    });
    Route::resource('documentos','documentoController');
    Route::resource('documentos', 'documentoController',['Except' => 'indexGetAll','indexGet','indexGetFirst']);

});
