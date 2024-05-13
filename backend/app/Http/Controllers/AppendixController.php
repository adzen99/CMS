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

    function getMyAppendicies(Request $request){
        $id_user = $request->route('id_user');
        $myAppendicies = Appendix::select('appendicies.series AS series', 'appendicies.no AS no', 'appendicies.date AS date', 'appendicies.value as value', 'appendicies.currency AS currency', 'companies.name AS provider', 'partners.name AS beneficiary', 'contracts.no AS no_contract', 'contracts.date AS contract_date')
                        ->join('companies', 'companies.id', '=', 'appendicies.id_provider')
                        ->join('partners', 'partners.id', '=', 'appendicies.id_beneficiary')
                        ->join('contracts', 'contracts.id', '=', 'appendicies.id_contract')
                        ->where('companies.id_user', $id_user)
                        ->get();
        $countMyAppendicies = Appendix::where('companies.id_user', $id_user)
                            ->join('companies', 'companies.id', '=', 'appendicies.id_provider')
                            ->count();
        return ['ok' => 1, 'myAppendicies' => $myAppendicies, 'countMyAppendicies' => $countMyAppendicies];        
    }

    function getAppendiciesForInvoices(Request $request){
        $id_user = $request->route('id_user');
        $appendicies = Appendix::select('appendicies.id AS id', 'appendicies.series AS series', 'appendicies.no AS no', 'appendicies.date AS date')
                        ->join('companies', 'companies.id', '=', 'appendicies.id_provider')
                        ->where(['companies.id_user' => $id_user, 'id_invoice' => 0])
                        ->get();
        return ['ok' => 1, 'appendicies' => $appendicies];        
    }
}
