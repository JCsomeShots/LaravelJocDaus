<?php

namespace App\Http\Controllers\API\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use UserResource;

class LoginController extends Controller
{
    public function store(Request $request) 
    {
        $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string ',
        ]);

        $user = User::where('email' , $request->email)->firstOrFail();

        if(Hash::check($request->password , $user->password)){
            return $user;
        }
        else {
            return response(['message' => 'La estás cagando / These credentials do not match our records.'], 404);
        }
    }
}
