<?php



namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Game;
use App\Models\User;

class GameController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $id )
    {
        if (! User::Find($id) ){
            return response(['message' => 'User not found'] , 404);
        }

        $dado1 = rand(1 , 6);
        $dado2 = rand(1 , 6);
        ($dado1 + $dado2 === 7) ? $result = Game::youWin : $result = Game::youLost;

        $game = new Game;
        $game -> dado1 = $dado1;
        $game -> dado2 = $dado2;
        $game -> result = $result;
        $game -> user_id = $id;

        $game->save();
    }
    

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if (! User::Find($id) ){
            return response(['message' => 'User not found'] , 404);
        }

        $user = User::with('game')->findOrFail($id);
        return $user;
    }
  
    public function showOnePlayer($id){
        

        $throws = Game::where('player_id', $id)->get();
        return $throws;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (! User::Find($id) ){
            return response(['message' => 'User not found'] , 404);
        }

        $games = Game::where('user_id' , $id)->delete();

        if (! $games || $games == 0) {
            return response (['message' => 'Sorry , Here there´s no games to delete, Please change the player ID']);
        }
        return response (['message' => 'you just deleted all the games for this player']);
    }



    // public function ranking(){
    //     return response(['message' => 'por aquí chekas el ranking'], 200);
    // }

    // public function loser(){
    //     return response(['message' => 'por aquí chekas quien ha perdido'], 200);
    // }

    // public function winner(){
    //     return response(['message' => 'por aquí chekas quien ha ganado'], 200);
    // }

}

