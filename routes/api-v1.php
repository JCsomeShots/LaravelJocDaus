<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\PlayerController;
use App\Http\Controllers\API\GameController;
use App\Http\Controllers\API\RankingController;
use App\Http\Controllers\Api\Auth\LoginController;
use App\Http\Controllers\Api\Auth\RegisterController;
use App\Http\Middleware;

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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });


Route::prefix('/players')->group( function (){
    Route::post('/',      [RegisterController::class , 'store'])->name('players.registe r');
    Route::post('/login', [LoginController::class , 'store'])->name('players.login');

    Route::get('/index' ,   [PlayerController::class , 'index'])->name('players.index');
    Route::post('/logout' , [LoginController::class , 'destroy'])->name('players.logout');
    Route::put('/{id}' ,    [PlayerController::class , 'update'])->name('players.update');
    Route::get('/',         [PlayerController::class , 'averagePlayerList'])->name('players.listGames');
    Route::get('/average',  [PlayerController::class , 'averageGame'])->name('players.game');

    Route::prefix('/{id}')->group( function (){ 
        Route::get('/games' ,    [GameController::class , 'show'])->name('games.show');
        Route::post('/games' ,   [GameController::class , 'store'])->name('games.store');
        Route::delete('/games' , [GameController::class , 'destroy'])->name('games.delete');
    });

    Route::prefix('/ranking')->group( function (){
        Route::get('/' ,       [RankingController::class,'ranking'])->name('ranking');
        Route::get('/winner' , [RankingController::class,'winner'])->name('ranking.winner');
        Route::get('/loser' ,  [RankingController::class,'loser'])->name('ranking.loser');
    });


});

  