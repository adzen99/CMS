<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller{

    public function register(Request $request){
        $input = $request->all();

        User::create([
            'username' => $input['username'],
            'password' => Hash::make($input['password']),
            'email' => $input['email'],
            'first_name' => $input['first_name'],
            'last_name' => $input['last_name'],
            'phone' => $input['phone'],
        ]);

        return response()->json(['status' => true, 'message' => 'User registered successfully!']);
    }

}
