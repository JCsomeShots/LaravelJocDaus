<?php



namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Game;
use App\Models\Ranking;
use App\Models\Noranking;
use App\Models\User;
use Illuminate\Support\Facades\DB;

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
  
    public function averagePlayerList()
    {
        
        $users =  User::orderBy('id')->pluck('id');

        foreach ($users as $user ) {
            
            $throws = Game::all()
            ->where('user_id' , $user)
            ->count();

            $losts = Game::all()
            ->where('user_id' , $user)
            ->where('result', 2)
            ->count();

            $wins = Game::all()
            ->where('user_id' , $user)
            ->where('result', 1)
            ->count();

            $totalThrows = 'The number of games played is : '. $throws;
            $textWins1 = 'The number of games won is : '. $wins;
            $textWin2 = 'The average number of games won is : ' ;
            $textLost1 = 'The number of games lost is : '. $losts;
            $textLost2 = 'The average number of games lost is : ' ;
            $noAverage = 'no average games won';

            
            if ($throws != 0) {
                $avgWins = round ( ($wins * 100) / $throws);
                $avgWins = $textWin2 . $avgWins . ' % ';
                $avglosts = round ( ($losts * 100) / $throws);
                $avglosts = $textLost2 . $avglosts;

                $avglist = [
                   'user_id' => $user , 
                   'throws' => $totalThrows , 
                //    'lost' => $textLost1 , 
                   'wins' => $textWins1 , 
                   'avgWins' => $avgWins , 
                //    'avgLost' => $avglosts
                ];

            }
            else {
                $avgWins = $textWin2 . ' 0 %';
                $avglosts = $textLost2 . ' 0 ';
                
                $avglist = [
                    'user_id' => $user , 
                    'throws' => $totalThrows , 
                    // 'lost' => $textLost1 , 
                    'wins' => $wins , 
                    // 'avgWins' => $avgWins , 
                    // 'avgLost' => $avglosts,
                    'ranking' => $noAverage
                ];

                }
            
            print_r($avglist);

        }

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



    public function loser()
    {
        $users =  User::pluck('id');

        foreach ($users as $user ) {
            $throws = Game::all()
            ->where('user_id' , $user)
            ->count();
            
            $wins = Game::all()
            ->where('user_id' , $user)
            ->where('result', 1)
            ->count();
            
            $noWin = 'you have zero wins in ' .$throws . ' moves';

            if ($throws != 0) {

                if($wins == 0) {
                    $toPrint = [
                        'user' => $user,
                        'Ranking' => $noWin
                    ];
                   print_r($toPrint);
                }
            } 
        }

    }

    public function winner ()
    {
        $toPrint = Ranking::orderBy('avgWins' , 'DESC')->get();

        // $users =  User::pluck('id');

        // $eddie = [];

        // foreach ($users as $user ) {
        //     $throws = Game::all()
        //     ->where('user_id' , $user)
        //     ->count();
            
        //     $wins = Game::all()
        //     ->where('user_id' , $user)
        //     ->where('result', 1)
        //     ->count();

        //     $toPrint = [
        //         'user' => $user,
        //         'wins' => $wins
        //     ];
        //    print_r($toPrint);
            
            // if ($throws != 0) {

            //     if($wins > 0) {
                    
            //         $avgWins = round( ($wins * 100) / $throws);

                    

            //         $ranking = [
            //             'user' => $user,
            //             'throws' => $throws ,
            //             'wins' => $wins,
            //             'avgWins' => $avgWins
            //         ];

            //         // $eddie1 = ($ranking['avgWins']);
            //         // $eddie = array_push($eddie1);
            //         // var_dump($eddie);

            //         var_dump ($ranking);

            //     }

            // } 

        // }

    }


}

