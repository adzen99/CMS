<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ExchangeRate;

class ExchangeRateController extends Controller
{
    function getExchangeRatesToday(Request $request){
    
        $cursXml=false;
        $c = curl_init('https://bnr.ro/files/xml/years/nbrfxrates2021.xml'); 
        curl_setopt($c, CURLOPT_HEADER, false); 
        curl_setopt($c, CURLOPT_SSL_VERIFYPEER, false);   
        curl_setopt($c, CURLOPT_RETURNTRANSFER, true); 
        curl_setopt($c, CURLOPT_CONNECTTIMEOUT, 3);
        $xmlString = curl_exec($c); 
        if($xmlString) { $cursXml=simplexml_load_string($xmlString); }
        curl_close($c); unset($xmlString); unset($c);
        echo '<pre>'; print_r($cursXml); die();

        // $all = $cursXml->
        
        return ['ok' => 1, 'resp' => $cursXml];        
    }
}
