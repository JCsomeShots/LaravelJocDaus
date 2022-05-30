<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use phpDocumentor\Reflection\Types\Null_;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        
        $validatedData = $request->validate([
            'nickname' => 'nullable',
            'email' => 'required | email | max:255 | unique:users',
            'password' => 'required | confirmed',
        ]);

        if(!$validatedData['nickname'] | $validatedData['nickname'] == Null){ 
            $validatedData['nickname'] = 'Anonimo';
        }

        if($validatedData['nickname'] = )

        $validatedData['password'] =  Hash::make($request->password);

        $user = User::create($validatedData);

        $accessToken = $user->createToken('authToken')->accessToken;

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


        return response (['user' => Auth::user(), 'access_token' => $accessToken]);
        
        
    }
}