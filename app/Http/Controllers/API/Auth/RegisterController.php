<?php

namespace App\Http\Controllers\API\Auth;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;

class RegisterController extends Controller
{
    
    public function store(Request $request)
    {
        
        // $validatedData = Validator::make([$request->all()],[
        //     'nickname' => 'nullable|string|max:8',
        //     'email' => 'required|string|email|max:255|unique:users',
        //     'password' => 'required|string|confirm_password|min:8 ',
        //     'confirm_password' => 'required'
        // ]);

        if ($request['nickname'] != 'Anonimo') 
        {
            $validatedData = $request->validate([
               'nickname' => 'nullable|string|min:2|max:12|unique:users',
               'email' => 'required|string|email|max:255|unique:users',
               'password' => 'required|string|confirmed|min:8 ',

           ]);
        } 
        else 
        {
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
        ], 201);
    }

    
}
