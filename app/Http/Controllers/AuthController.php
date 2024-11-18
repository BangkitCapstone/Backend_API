<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;

class AuthController extends Controller
{
    public function register(Request $request){
        $request->validate([
            'full_name' => 'required',
            'username' => 'required',
            'password' => 'required'
        ]);

        return response()->json([
            'message'=> 'User has been successfully created',
            
        ],Response::HTTP_CREATED);
    }

    public function login(Request $request){
        $request->validate([
            "username" => "required",
            "password" => "required"
        ]);

        return response()->json([
            'message' => "User has successfully login"
        ],Response::HTTP_OK);
    }
}
