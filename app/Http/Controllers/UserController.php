<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use \Firebase\JWT\JWT;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function getBalance(){
        return [
            "credit" => User::find(Auth::user()->id)->credit
        ];
    }

    public function doLogin(Request $request){
        $user = User::where([
            "email" => $request->input('email'),
            "password" => hash("sha256", $request->input('password').env('APP_SALT'))
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
            return response([
                "message" => "Email and password did not match."
            ], 400);
        }
    }

    public function doRegistration(Request $request){
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6',
            'name' => 'required|min:3',
            'phone_number' => 'required|min:9',
            'address' => 'required|min:5',
        ]);

        if ($validator->fails()){
            return response([
                "message" => $validator->messages()->first()
            ], 422);
        }

        $inputs = $request->all();
        $inputs['password'] = hash("sha256", $inputs['password'].env('APP_SALT'));

        $user = User::create($inputs);

        $token = array(
            "id" => $user->id,
            "iat" => time(),
        );

        $jwt = JWT::encode($token, env("APP_KEY"));
        
        return [
            "message" => "Registration successful.",
            "token" => $jwt
        ];
    }
}
