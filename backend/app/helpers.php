<?php

if(!function_exists('convertCurrency')){
    function convertCurrency($value, $from, $to, $rates){
        if(!$from || !$to || !$rates){ return null; }
        if($from == $to){
            return $value;
        }
        if($from == 'RON'){
            $unit = 1 / $rates[$to];
            $value = $value * $unit;
        }elseif($to == 'RON'){
            $value = $value * $rates[$from];
        }else{
            // to do: convert between different currencies realtive to RON
        }
        return $value;
    }
}

