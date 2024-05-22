<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

use App\Models\County;

class CountyController extends Controller
{
    function getCountiesOptions(){
        $options = County::select("id AS value", DB::raw("CONCAT(name, ' - ', code) AS text"))->get();
        return ['ok' => 1, 'options' => $options];        
    }
}
