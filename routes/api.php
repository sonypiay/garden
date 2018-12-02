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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['prefix' => 'provinsi'], function() {
  Route::get('/', 'Api\ProvinsiApi@all');
  Route::get('/all', 'Api\ProvinsiApi@all');
});
Route::group(['prefix' => 'kabupaten'], function() {
  Route::get('/', 'Api\KabupatenApi@all');
  Route::get('/all', 'Api\KabupatenApi@all');
  Route::get('/search/{kab}', 'Api\KabupatenApi@searchKabupaten');
  Route::get('/provinsi/{id}', 'Api\KabupatenApi@byProvinsi');
});
Route::group(['prefix' => 'kecamatan'], function() {
  Route::get('/', 'Api\KecamatanApi@all');
  Route::get('/all', 'Api\KecamatanApi@all');
  Route::get('/kabupaten/{id}', 'Api\KecamatanApi@byKabupaten');
});
