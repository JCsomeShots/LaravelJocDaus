<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Ranking;
use App\Models\Noranking;

use App\Models\Game;
use Illuminate\Http\Request;

class RankingController extends Controller
{
    
    public function ranking()
    {
        $restart = Ranking::truncate();

        $users =  User::pluck('id');
        $message = 'You have no ranking assignment, because you don`t play yet';

        foreach ($users as $user ) {
            $throws = Game::all()
            ->where('user_id' , $user)
            ->count();

            $wins = Game::all()
            ->where('user_id' , $user)
            ->where('result', 1)
            ->count();
            
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

        foreach ($users as $user) {
            $throws = Game::all()
            ->where('user_id', $user)
            ->count();
            if($throws == 0){
                $Noranking = new Noranking;
                $Noranking -> user_id = $user;
                $Noranking -> message = $message;
                $Noranking->save();
            }
        }
        
        
        $toPrint = Ranking::orderBy('avgWins' , 'DESC')->get();
        $toPrint2 = Noranking::all();

        return [$toPrint , $toPrint2];

       
    }

}
