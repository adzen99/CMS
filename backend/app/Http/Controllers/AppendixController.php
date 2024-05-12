<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Appendix;

class AppendixController extends Controller
{
    function add(Request $request){
        $input = $request->input();
        $appendix = new Appendix;
        foreach($input as $key => $value){ $appendix->$key = $value; }
        $appendix->save();
        return ['ok' => 1];
    }
}
