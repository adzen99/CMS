<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Locality;


class LocalityController extends Controller
{
    function getOptionsLocalitiesOfCounty(Request $request){
        $id_county = $request->route('id_county');
        $options = Locality::select("id AS value", "name AS text")
                    ->where('id_county', $id_county)
                    ->orderBy('name', 'asc')->get();
        return ['ok' => 1, 'options' => $options];        
    }
}
