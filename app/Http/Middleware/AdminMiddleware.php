<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class Admin
{
    public function admin(){

        if (Auth::check())
        {
            if (Auth::user()->is_admin !== 1) {
                
                return response(["message" => "Sorry but you are not allowed to realice this action"]);
            }
           
            
        }
    }
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    // public function handle(Request $request, Closure $next)
    // {
        

        
    // }

    // public function isAdmin(Request $request){
    //         if(is_admin == 1)  {
    //             return $next($request);
    //         }
    // }
}
