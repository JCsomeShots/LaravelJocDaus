<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Game;
use App\Models\User;
use App\Models\Ranking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

use Illuminate\Support\Validator;
use Illuminate\Validation\Rule;
use App\Http\Requests;

class PlayerController extends Controller
{
    public function __construct() 
    {
        $this->middleware('auth:api')->except(['register' , 'login']);
    } 
  
    public function register(Request $request)
    {
        if ($request['nickname'] != 'Anonimo') {
            $validatedData = $request->validate([
               'nickname' => 'nullable|string|min:2|max:12|unique:users',
               'email' => 'required|string|email|max:255|unique:users',
               'password' => 'required|string|confirmed|min:8 ',
           ]);
        } else {
            $validatedData = $request->validate([
                'nickname' => 'nullable|string|max:8',
                'email' => 'required|string|email|max:255|unique:users',
                'password' => 'required|string|confirmed|min:8 ',
            ]);
        }

        if (!$validatedData['nickname'] | $validatedData['nickname'] == null) {
            $validatedData['nickname'] = 'Anonimo';
        }


        $validatedData['password'] =  Hash::make($request->password);

        $user = User::create($validatedData);

        $accessToken = $user->createToken('Token')->accessToken;

        return response([
            'user' => $user,
            'access_token' => $accessToken
        ]);
    }



    public function login(Request $request)
    {
        $loginData = $request->validate([
            'email' => 'required | email ',
            'password' => 'required '
        ]);

        if (!auth()->attempt($loginData)) {
            return response(['message' => 'Invalid login credentials'], 422);
        }

        $accessToken = Auth::user()->createToken('userToken')->accessToken;

        return response(['user' => Auth::user(), 'access_token' => $accessToken], 202);
    }


    public function logout(Request $request)
    {

        // $token = $request->user()->token();
        // $token->revoke();

        // $user = Auth::user()->token();
        // $user->revoke();

        return response(['message' => 'You have successfully logout'], 200);
    }


    
    public function index()
    {
        $users = User::all();
        return $users;

    }



    /**
     * Update the specified User.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        
        if (! User::Find($id) ){
            return response(['message' => 'User not found'] , 404);
        }
        else {
            $user = User::Find($id);
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


    public function averageGame(){


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


        $throws = Game::all()
            ->count();
        
        $users = User::all()
            ->count();

        $wins = Ranking::all()
            ->sum('win');

        $losts = Ranking::all()
            ->sum('lost');


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

//     Password grant client created successfully.
// Client ID: 967d1971-e274-4a99-8064-c294ce914d2c
// Client secret: jGcYisl4l37IGwripXYrlNZQopWlYkJ3GSZ9s42a
}