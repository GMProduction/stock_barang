<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

//Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//    return $request->user();
//});

Route::group(['prefix' => 'auth'], function () {
    Route::post('login', [\App\Http\Controllers\Api\AuthController::class, 'login']);
});

Route::group(['prefix' => 'barang', 'middleware' => 'auth:api'], function () {
    Route::get('/', [\App\Http\Controllers\Api\BarangController::class, 'index']);
    Route::get('/{id}', [\App\Http\Controllers\Api\BarangController::class, 'detail']);
});

Route::group(['prefix' => 'barang-keluar', 'middleware' => 'auth:api'], function () {
    Route::match(['post', 'get'], '/', [\App\Http\Controllers\Api\BarangKeluarController::class, 'index']);
});

Route::group(['prefix' => 'barang-masuk', 'middleware' => 'auth:api'], function () {
    Route::match(['post', 'get'], '/', [\App\Http\Controllers\Api\BarangMasukController::class, 'index']);
});

Route::group(['prefix' => 'profil', 'middleware' => 'auth:api'], function () {
    Route::match(['post', 'get'], '/', [\App\Http\Controllers\Api\ProfileController::class, 'index']);
});
