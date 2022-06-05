<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Game;
use App\Models\User;
use Illuminate\Support\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use App\Http\Requests;

class PlayerController extends Controller
{
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

        // return response(['message' => 'por aquí todos los jugadores']);
    }


    public function showOnePlayer($id)
    {
        $user = User::with('game.user')->findOrFail($id);

        // $user = User::find($id);
        return $user;

        // return response(['message' => 'por aquí un sólo jugador']);
    }



    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        
        // $allNickname = User::all(['nickname']);
        // $nick = $request['nickname'];
        // $nickAnonimo = [ 'nickname' => 'Anonimo'];
        // return [$nick , $nickAnonimo , $allNickname  ];
        // return var_dump( $allNickname  );
        //     if ($nickname == $nickAnonimo) {
        //                 return response(['message' => 'es anonimo' ]);
        //             }else {
        //                 return response(['message' => 'No es anonimo ' ]);
        //             }
            
            // foreach ($nickname as $key) {
                
            //     if ($key === 'Anonimo' ) { 
            //         // var_dump($key);
            // }
            
            // if ($key !== $nick ) { return; } 
                
            
        if (! User::Find($id) ){
        return response(['message' => 'User not found'] , 404);
        }
        else {
            $user = User::Find($id);
        };
        
        
        if ($request['nickname'] == $user->nickname) {
            return response(['message' => "Sorry, This Nickname is yours already. Please Try With Different One, Thank You."] , 406);
        }

     
        if ($request['nickname'] != 'Anonimo'){
            
            $request->validate(
                
                ['nickname' => 'nullable|string|min:2|max:12|unique:users'],
                [
                    'nickname.string' => 'Sorry, This field must be filled by a text string',
                    'nickname.max' => 'Sorry, You have exceeded the number of characters for this field',
                    'nickname.min' => 'Sorry, This field must contain at least 2 characters',
                    'nickname.unique' => 'Sorry, This Nickname already taken. Please try a different one, Thank You.',
                ]
            );
        }
        if($request['nickname'] == Null | !$request['nickname'] |  $request['nickname'] == '' ){
            $request['nickname'] = 'Anonimo';
        }
      
        $user->update($request->all());
        return $user;

    }
    
}