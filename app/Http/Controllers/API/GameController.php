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
    public function store(Request $request)
    {
         $dado1 = rand(1 , 6);
        $dado2 = rand(1 , 6);
        ($dado1 + $dado2 === 7) ? $result = Game::youWin : $result = Game::youLost;

        // $user -> validate ([
        //     'jugador' => 'required',
        // ]);

        $jugada = new Game;
        // $jugada -> jugador = $user -> id;
        $jugada -> dado1 = $dado1;
        $jugada -> dado2 = $dado2;
        $jugada -> resultado = $result;

        $jugada->save();
    }
    

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    
  

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
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

