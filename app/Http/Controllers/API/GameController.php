<?php



namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Game;
use App\Models\User;

class GameController extends Controller
{
    
    /**
     * Store a newly created resource in storage.
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

        if ($game->result == Game::youLost) {
            return response (['message' => 'You just throws the dices and you lost' , $game->dado1 , $game->dado2]);
        }
        else {
            return response (['message' => 'You just throws the dices and you win' , $game->dado1 , $game->dado2]);
        }

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





}

