<?php

namespace App\Http\Controllers\Api\v1\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

//models
use App\Models\User;

// request
use App\Http\Requests\authFormRequest;

class AuthController extends Controller
{
    public function login(authFormRequest $request){
        Log::info($request->all());
        $user = User::where("email",$request->email)->first();
        $type = "old";
        if($user){
            if(Hash::check($request->password,$user->password)){
                $token = $user->createToken("user login")->plainTextToken;

                if(!$user->name){
                    $type = "new";
                }

                return response([
                    "message" => "User Authenticated",
                    "token" => $token,
                    "type" => $type,
                    "status" => "success"
                ],200);
            }


            return response([
                "message" => "Email or Password Incorrect",
                "status" => "success"
            ],400);
        }
        else{
            $type = "new";
            $user = new User();
            $user->email = $request->email;
            $user->password = Hash::make($request->password);
            $user->save();

            $token = $user->createToken("user login")->plainTextToken;

            return response([
                "message" => "User Authenticated",
                "token" => $token,
                "type" => $type,
                "status" => "success"
            ],200);
        }

    }

    public function saveUserData(Request $request){
        Log::info($request->all());
        $request->validate([
            "name" => "required|string"
        ]);

        $user = User::find(auth()->id());

        $user->name = $request->name;

        $user->save();

        return response([
            "message" => "User Data Stored Successfully",
            "status" => "success"
        ],200);
    }

}
