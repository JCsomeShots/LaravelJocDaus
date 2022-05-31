<?php

use App\Http\Controllers\API\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\GameController;

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


Route::prefix('/players')->group( function (){
    // Route::middleware('auth:api')->get('/all' , 'api\user\UserController@index');
    Route::post('/' , [AuthController::class , 'register'])->name('players.register');
    Route::get('/' , [AuthController::class] , 'index')->name('list');
    Route::post('/login' , [AuthController::class , 'login'])->name('players.login');
    Route::post('/logout' , [AuthController::class , 'logout'])->name('players.logout');
    Route::put('/{id}' , [AuthController::class] , 'update')->name('players.update');

    Route::prefix('/{id}')->group( function (){ 
        Route::get('/games' , [GameController::class] , 'index')->name('games.index');
        Route::post('/games' , [GameController::class] , 'store')->name('games.store');
        Route::delete('/games' , [GameController::class] , 'delete')->name('games.delete');
    });

    Route::prefix('/ranking')->group( function (){
        Route::get('/' , [GameController::class,'ranking'])->name('ranking');
        Route::get('/loser' , [GameController::class,'loser'])->name('ranking.loser');
        Route::get('/winner' , [GameController::class,'winner'])->name('ranking.winner');
    });
});

  