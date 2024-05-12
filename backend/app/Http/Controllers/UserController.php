<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    function updateInfo(Request $request){
        $input = $request->input();
        $id = $input['id_user'];

        $user = User::where('id', $id)->first();
        if(is_null($user)){
            return ['ok' => 0, 'message' => 'The user does not exist!'];
        }

        unset($input['id_user']);
        if(!$input['password']){
            unset($input['password']); 
        }else{
            $input['password'] = Hash::make($input['password']);
        }
        User::where('id', $id)->update($input);
        return ['ok' => 1, 'message' => 'The information has been updated successfully!'];
    }
}
