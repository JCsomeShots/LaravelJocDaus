<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\PlayerController;
use App\Http\Controllers\API\GameController;
use App\Http\Controllers\API\RankingController;
use App\Http\Controllers\Api\Auth\loginController;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


Route::prefix('/players')->group( function (){
    Route::post('/', [PlayerController::class , 'register'])->name('players.registe r');
    Route::post('/login', [PlayerController::class , 'login'])->name('players.login');
    // Route::middleware('auth:api')->get('/all' , 'api\user\AuthController@index');

    // Route::group(['middleware' => ['admin']], function () {
        // //     Route::get('admin-view', 'HomeController@adminView')->name('admin.view');
        // });
    // Route::middleware('admin')->get('/' , 'api\user\GameController@averagePlayerList');

    Route::get('/index' , [PlayerController::class , 'index'])->name('players.index');
    Route::post('/logout' , [PlayerController::class , 'logout'])->name('players.logout');
    Route::put('/{id}' , [PlayerController::class , 'update'])->name('players.update');
    Route::get('/', [GameController::class , 'averagePlayerList'])->name('players.listGames');

    Route::prefix('/{id}')->group( function (){ 
        Route::get('/games' , [GameController::class , 'show'])->name('games.show');
        Route::post('/games' , [GameController::class , 'store'])->name('games.store');
        Route::delete('/games' , [GameController::class , 'destroy'])->name('games.delete');
    });

    Route::prefix('/ranking')->group( function (){
        Route::get('/' , [RankingController::class,'ranking'])->name('ranking');
        Route::get('/loser' , [RankingController::class,'loser'])->name('ranking.loser');
        Route::get('/winner' , [RankingController::class,'winner'])->name('ranking.winner');
    });


});

  