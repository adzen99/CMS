<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Cookie;
use Symfony\Component\HttpFoundation\Response;

class AuthController extends Controller
{
    public function login(Request $request){
        if(!Auth::attempt($request->only('username', 'password'))){
            return response([
                'message' => 'Invalid credentials!'
                ], Response::HTTP_UNAUTHORIZED);
        }
        
        $user = Auth::user();

        $token = $user->createToken('token')->plainTextToken;

        $cookie = cookie('jwt', $token, 60 * 24);
        return response([
            'message' => 'Success',
            'token' => $token,
        ])->withCookie($cookie);
    }

    public function authUser(){
        return Auth::user();
    }

    public function logout(){
        $cookie = Cookie::forget('jwt');
        return response([
            'message' => 'Success'
        ])->withCookie($cookie);
    }
}
