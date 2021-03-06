<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\PlayerController;
use App\Http\Controllers\API\GameController;
use App\Http\Controllers\API\RankingController;
use App\Http\Controllers\Api\Auth\LoginController;
use App\Http\Controllers\Api\Auth\TokenController;
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



Route::post('players/', [RegisterController::class , 'store'])->name('register');
Route::post('players/login', [LoginController::class , 'store'])->name('login');


Route::middleware(['auth:api'])->group(function () {

    Route::prefix('/players')->group( function (){

        Route::post('/logout', [LoginController::class , 'destroy'])->name('logout'); //optional

        Route::get('/', [PlayerController::class , 'averageGame'])->name('admin.game');
        Route::get('/index', [PlayerController::class , 'index'])->name('admin.index'); //optional
        Route::get('/average', [PlayerController::class , 'averagePlayerList'])->name('admin.listGames'); // opcional - this route will return an array (NO JSON) result for each player
        
        Route::prefix('/{id}')->group(function () {
            Route::put('/', [PlayerController::class , 'update'])->name('players.update');
            Route::put('/admin', [LoginController::class , 'update'])->name('admin.update'); //optional - An admin can change a user behavior to admin
            Route::get('/games', [GameController::class , 'show'])->name('games.show');
            Route::post('/games', [GameController::class , 'store'])->name('games.store');
            Route::delete('/games', [GameController::class , 'destroy'])->name('games.delete');
        });

        Route::prefix('/ranking')->group(function () {
            Route::get('/', [RankingController::class,'ranking'])->name('admin.ranking');
            Route::get('/winner', [RankingController::class,'winner'])->name('admin.ranking.winner');
            Route::get('/loser', [RankingController::class,'loser'])->name('admin.ranking.loser');
        });
    });

});

  