<?php

namespace App\Http\Controllers\API;

use App\Models\User;
use App\Models\Ranking;
use App\Models\Noranking;
use App\Http\Controllers\Controller;
use App\Models\Game;
use Illuminate\Http\Request;

class RankingController extends Controller
{
    
    public function ranking()
    {
        $message = 'You have no ranking assignment, because you haven`t played yet';
        
        Ranking::truncate();
        $users =  User::pluck('id');

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
        
        
        $toPrint = Ranking::orderBy('avgWins' , 'DESC')->orderBy('throws' , 'DESC')->get();
        $toPrint2 = Noranking::all();

        return [$toPrint , $toPrint2];
        // return $toPrint ;

       
    }


   

    public function winner ()
    {
        Ranking::truncate();

        $users =  User::pluck('id');

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


            if (($throws != 0) && ($wins> 0)) {

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
            } 
        }

        $toPrint = Ranking::orderBy('avgWins' , 'DESC')->orderBy('throws' , 'DESC')->take(1)->get();
        return $toPrint;

    }

    public function loser()
    {
        Ranking::truncate();

        $users =  User::pluck('id');

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

        
        
        
        $toPrint = Ranking::orderBy('avgWins' , 'ASC')->orderBy('lost' , 'DESC')->take(1)->get();
        return $toPrint ;

    }


}
