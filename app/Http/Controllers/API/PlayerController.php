<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Game;
use App\Models\User;
use Illuminate\Contracts\Support\ValidatedData;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class PlayerController extends Controller
{

    public function register(Request $request)
    {
        $validatedData = $request->validate([
            'nickname' => 'nullable|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|confirmed|min:8 ',
        ]);

        if(!$validatedData['nickname'] | $validatedData['nickname'] == Null){ 
            $validatedData['nickname'] = 'Anonimo';
        }

        $validatedData['password'] =  Hash::make($request->password);

        $user = User::create($validatedData);

        $accessToken = $user->createToken('Token')->accessToken;

        return response ([
            'user' => $user,
            'access_token' => $accessToken
        ]);
    }




    public function login (Request $request)
    {
        $loginData = $request->validate([
            'email' => 'required | email ',
            'password' => 'required '
        ]);

        if (!auth()->attempt($loginData)){
            return response (['message' => 'Invalid login credentials'] , 422);
        }

        $accessToken = Auth::user()->createToken('userToken')->accessToken;

        return response (['user' => Auth::user(), 'access_token' => $accessToken] , 202);
        
        
    }

    public function logout(Request $request){

        // $token = $request->user()->token();
        // $token->revoke();

        $user = Auth::user()->token();
        $user->revoke();

        return response(['message' => 'You have successfully logout'], 200);

    }


    
   public function index()
   {
       $users = User::all();
       return $users;
            //    return response()->json(['users' => $users]);

   }




    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update( Request $request , $id)
    {
        if (! User::Find($id) ){
            return response(['message' => 'User not found'] , 404);
        }else {
            $user = User::Find($id);
        };

        $validatedData = $request->validate([
            'nickname' => 'nullable|string|max:255|unique',
        ]);

        // if ($validatedData['nickname'] == $user->nickname->any()){
        //     return response(['message' => "This nickname is already taken"] , 406);
        // }
        
        if ($validatedData['nickname'] == $user->nickname) {
            return response(['message' => "you can't choose the same nickname"] , 406);
        }

        if($validatedData['nickname'] == Null | !$validatedData['nickname'] |  $validatedData['nickname'] == ''){ 
            $validatedData['nickname'] = 'Anonimo';
            
        }
        $user->update($request->all());
        return $user;

        
    }
}