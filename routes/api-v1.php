<?php

use App\Http\Controllers\API\AuthController;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


Route::prefix('/players')->group( function (){
    // Route::middleware('auth:api')->get('/all' , 'api\user\UserController@index');
    Route::post('/' , [AuthController::class , 'register'])->name('players.register');
    Route::post('/login' , [AuthController::class , 'login'])->name('players.login');

    Route::prefix('/ranking')->group( function (){
        Route::post('/loser' , [GameController::class,'loser'])->name('ranking.loser');
        Route::post('/winner' , [GameController::class,'winner'])->name('ranking.winner');
    });
});

Route::get('players' , [AuthController::class] , 'index')->name('api.v1.players.index');
Route::get('players/{$id}/games' , [GameController::class] , 'index')->name('api.v1.game.index');
Route::post('players/{$id}/games' , [GameController::class] , 'store')->name('api.v1.game.store');

// Route::put('player'/{id}) 