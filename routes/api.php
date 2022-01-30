<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use \App\Http\Controllers\ArtistController;
use \App\Http\Controllers\AlbumController;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/artists/{id}',[ArtistController::class,'show']);


Route::get('/albums/',[AlbumController::class,'show']);

Route::post('/albums/',[AlbumController::class,'create']);

Route::put('/albums/{id}',[AlbumController::class,'update']);

Route::delete('/albums/{id}',[AlbumController::class,'destroy']);

Route::get('/create',[AlbumController::class,'create']);
