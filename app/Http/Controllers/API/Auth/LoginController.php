<?php

namespace App\Http\Controllers\API\Auth;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;

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
        $user = Auth::user();
        $accessToken = Auth::user()->createToken('userToken')->accessToken;

        return response(['user' => $user, 'access_token' => $accessToken], 202);
    }

    public function destroy()
    {

        $user = Auth::user()->token();
        $user->revoke();

        return response(['message' => 'You have successfully logout'], 200);
    }

    public function update(Request $request, $id)
    {
        if (! User::Find($id) ){
            return response(['message' => 'User not found'] , 404);
        }else {
            $user = User::find($id);
        }

        if(Auth::check()){
            if (Auth::user()->is_admin == 1) {
                $request->validate([
                    'is_admin'=>'required',
                ]);
            }else {
                return response(['message' => "Sorry, You have no permission to give this permission"] , 406);
            }
        }

        $user->update($request->all());
        return $user;
    }
}
