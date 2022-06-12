<?php

namespace App\Http\Controllers\API\Auth;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class LoginController extends Controller
{
    public function store(Request $request)
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

    public function destroy()
    {

        $user = Auth::user()->token();
        $user->revoke();

        return response(['message' => 'You have successfully logout'], 200);
    }
}
