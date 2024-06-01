<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ExchangeRate;

class ExchangeRateController extends Controller
{
    function getExchangeRatesToday(Request $request){
        
        $opCurrency = [
            0 => 'AED',
            1 => 'AUD',
            2 => 'BGN',
            3 => 'BRL',
            4 => 'CAD', 
            5 => 'CHF',
            6 => 'CNY',
            7 => 'CZK', 
            8 => 'DKK',
            9 => 'EGP',
            10 => 'EUR',
            11 => 'GBP',
            12 => 'HRK',
            13 => 'HUF', 
            14 => 'INR',
            15 => 'JPY', 
            16 => 'KRW',
            17 => 'MDL',
            18 => 'MXN',
            19 => 'NOK',
            20 => 'NZD',
            21 => 'PLN',
            22 => 'RSD',
            23 => 'RUB',
            24 => 'SEK',
            25 => 'THB',
            26 => 'TRY',
            27 => 'UAH',
            28 => 'USD',
            29 => 'XAU',
            30 => 'XDR',
            31 => 'ZAR',
        ];

        $ratesXml=false;
        $c = curl_init('https://bnr.ro/files/xml/years/nbrfxrates2024.xml'); 
        curl_setopt($c, CURLOPT_HEADER, false); 
        curl_setopt($c, CURLOPT_SSL_VERIFYPEER, false);   
        curl_setopt($c, CURLOPT_RETURNTRANSFER, true); 
        curl_setopt($c, CURLOPT_CONNECTTIMEOUT, 3);
        $xmlString = curl_exec($c); 
        if($xmlString) { $ratesXml=simplexml_load_string($xmlString); }
        curl_close($c); unset($xmlString); unset($c);
       
        if($ratesXml){
            $allRates = [];
            $json = json_encode($ratesXml);
            $array = json_decode($json, TRUE);
            if(isset($array['Body']['Cube'])){
                foreach($array['Body']['Cube'] as $arr){
                    if(isset($arr['@attributes']['date'])){
                        $date = $arr['@attributes']['date'];
                        if(isset($arr['Rate'])){
                            foreach($arr['Rate'] as $k => $v){
                                $mapRates[$opCurrency[$k]] = $v;
                            }
                            if($mapRates){
                                $allRates[$date] = $mapRates;
                            }                            
                        }
                    }
                }
            }
            $currentDate = '2024-01-01';
            while($currentDate != '2024-06-02'){
                if(!isset($allRates[$currentDate])){
                    $date = date('Y-m-d', strtotime($currentDate. ' -1 day'));
                    if(isset($allRates[$date])){
                        $allRates[$currentDate] = $allRates[$date];
                    }
                }
                $currentDate = date('Y-m-d', strtotime($currentDate . ' +1 day'));
            }
            ksort($allRates);

            foreach($allRates as $date => $rate){
                if(!ExchangeRate::where(['date' => $date])->exists()){
                    $exchangeRate = new ExchangeRate;
                    $exchangeRate->date = $date;
                    $exchangeRate->rates = json_encode($rate);
                    $exchangeRate->save();
                }               
            }

        }        
        return ['ok' => 1];        
    }
}
