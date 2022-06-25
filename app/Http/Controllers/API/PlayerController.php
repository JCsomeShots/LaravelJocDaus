<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Game;
use App\Models\User;
use App\Models\Ranking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class PlayerController extends Controller
{
    // public function __construct()
    // {
    //     $this->middleware('EsAdmin');
    // }

    public function index()
    {
        if (Auth::check())
        {
            if (Auth::user()->is_admin !== 1) {
                return response(["message" => "Sorry but you are not allowed to realice this action"], 404);
            }
        }
        $users = User::all();
        return response()->json(['result' => $users], 201);


    }
   
    public function averagePlayerList()
    {
        if (Auth::check())
        {
            if (Auth::user()->is_admin !== 1) {
                return response(["message" => "Sorry but you are not allowed to realize this action"]);
            }
        }
        
        $users =  User::orderBy('id')->pluck('id');
        
        foreach ($users as $user ) {
            
            $throws = Game::all()->where('user_id' , $user)->count();       
            $losts = Game::all()->where('user_id' , $user)->where('result', 2)->count();
            $wins = Game::all()->where('user_id' , $user)->where('result', 1)->count();
            
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
                    'wins' => $textWins1 , 
                    'lost' => $textLost1 , 
                    'avgWins' => $avgWins , 
                    'avgLost' => $avglosts
                ];
            }
            else {
                $avgWins = $textWin2 . ' 0 %';
                $avglosts = $textLost2 . ' 0 ';
                
                $avglist = [
                    'user_id' => $user , 
                    'throws' => $totalThrows , 
                    'wins' => $wins , 
                    'ranking' => $noAverage
                ];
            }
            print_r($avglist);
            
        }
        
    }
    
    
    public function averageGame()
    {
        if (Auth::check())
        {
            if (Auth::user()->is_admin !== 1) {
                return response(["message" => "Sorry but you are not allowed to realice this action"]);
            }
        }

        Ranking::truncate();
        $users =  User::pluck('id');
        
        foreach ($users as $user ) {
            $throws = Game::all()->where('user_id' , $user)->count();
            $wins = Game::all()->where('user_id' , $user)->where('result', 1)->count();
            $lost = Game::all()
            ->where('user_id' , $user)
            ->where('result', 2)
            ->count();
            
            
            if ($throws != 0) {
                
                if($wins > 0) {
                    
                    $avgWins = round ( ($wins * 100) / $throws);
                    $avgLosts = round ( ($lost *100) / $throws);
                    
                    $ranking = new Ranking;
                    $ranking -> user_id = $user;
                    $ranking -> throws = $throws;
                    $ranking -> win = $wins;
                    $ranking -> lost = $lost;
                    $ranking -> avgWins = $avgWins;
                    $ranking -> avgLosts = $avgLosts;
                    $ranking->save();
                    
                } else {
                    $avgLosts = round ( ($lost *100) / $throws);
                    
                    $ranking = new Ranking;
                    $ranking -> user_id = $user;
                    $ranking -> throws = $throws;
                    $ranking -> win = $wins;
                    $ranking -> lost = $lost;
                    $ranking -> avgWins = 0;
                    $ranking -> avgLosts = $avgLosts;
                    $ranking->save();
                    
                }
            } 
        }
        
        
        $throws = Game::all()->count();
        $users = User::all()->count();
        $wins = Ranking::all()->sum('win');
        $losts = Ranking::all()->sum('lost');
        
        
        if ($wins != 0) {
            $avgWins = round(($wins * 100) / $throws); 
        }else {
            $avgWins = 0;
        }
            if ($losts != 0) {
                $avgLosts = round(($losts * 100) / $throws); 
            }else {
                $avgLosts = 0;
            }
            
            $avergaGame = [
                'Total users' => $users,
                'Total throws' => $throws,
                'Total win games' => $wins,
                'Total lost games' => $losts,
                'Average total win games' => $avgWins,
                'Average total lost games' => $avgLosts,
            ];
            return $avergaGame;
    }
    
    public function update(Request $request, $id)
    {
        
        if (! User::Find($id) ){
            return response(['message' => 'User not found'] , 404);
        }

        $actualUser = Auth::user()->id;
        $user = User::find($id);
        $user_id = $user['id'];
        
        if (Auth::check()) {

            if (Auth::user()->is_admin !== 1){

                if ($actualUser !== $user_id) {
                    return response(["message" => "Sorry but you are not allowed to realice this action "]);
                }
            }
        }
        
        
        if ($request['nickname'] != 'Anonimo' | $request['nickname'] == 'Null' | $request['nickname'] == 'null') {
            $nickAnonimo = User::pluck('nickname');

            foreach ($nickAnonimo as $nick) {
                if ($nick == $request['nickname']) {
                    return response (['message' => 'nickname taken']);
                }
            }
        }
        
        if ($request['nickname'] == $user->nickname) {
            return response(['message' => "Sorry, This Nickname is yours already. Please Try With Different One, Thank You."] , 406);
        }

        
        if($request['nickname'] == Null | !$request['nickname'] |  $request['nickname'] == '' | $request['nickname'] == 'Null' | $request['nickname'] == 'null'){
            $request['nickname'] = 'Anonimo' ;
        }
        



        $user->update($request->all());
        return $user;

    }
        
        
       
    }