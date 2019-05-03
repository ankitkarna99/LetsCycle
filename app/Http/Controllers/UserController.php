<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use \Firebase\JWT\JWT;

class UserController extends Controller
{
    public function doLogin(Request $request){
        $user = User::where([
            "username" => $request->input('username'),
            "password" => $request->input('password')
        ])->first();

        if ($user){
            $token = array(
                "id" => $user->id,
                "iat" => time(),
            );

            $jwt = JWT::encode($token, env("APP_KEY"));
            
            return [
                "message" => "Login successful.",
                "token" => $jwt
            ];
        } else {
            return [
                "message" => "Username and password did not match."
            ];
        }
    }
}
