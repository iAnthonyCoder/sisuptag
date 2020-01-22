<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::get('modulos/lista', 'moduloController@indexGet');

Route::get('documentos/lista/{id}', 'documentoController@indexGetMobile');


Route::get('documentos/listaPublica/{id}', 'documentoController@indexGetPublic');
//Route::get('documentos/lista/{id}', 'documentoController@indexGet');
Route::get('guest', 'documentoController@indexGetAll');
Route::get('documentos/indexGetFirst', 'documentoController@indexGetFirst');
Route::get('documentos/indexGetFirstPublic', 'documentoController@indexGetFirstPublic');
Route::get('documentos/generatePdf/{id}', 'documentoController@generatePdf');
Route::get('documentos/generatePdfMobile/{id}', 'documentoController@generatePdfMobile');
