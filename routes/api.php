<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ArtistController;
use App\Http\Controllers\AlbumController;
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

Route::get('/artists/{id}',[ArtistController::class,'show']);

Route::apiResource('albums', AlbumController::class);

Route::apiResource('dairy',\App\Http\Controllers\DairyController::class);

Route::get('/albums/{id}/dairy', [AlbumController::class, 'showDairies']);
