<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Bank;

class BankController extends Controller
{
    function getBanksOptions(){
        $options = Bank::select('id AS value', 'name AS text')->orderBy('name', 'asc')->get();
        return ['ok' => 1, 'options' => $options];        
    }
}
