<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Contract;

class ContractController extends Controller
{
    function add(Request $request){
        $input = $request->input();
        $contract = new Contract;
        foreach($input as $key => $value){ $contract->$key = $value; }
        $contract->save();
        return ['ok' => 1];
    }

    function getMyContracts(Request $request){
        $id_user = $request->route('id_user');
        $myContracts = Contract::select('contracts.no AS no', 'contracts.date AS date', 'contracts.expiration_date AS expiration_date', 'companies.name AS provider', 'partners.name AS beneficiary')
                        ->join('companies', 'companies.id', '=', 'contracts.id_provider')
                        ->join('partners', 'partners.id', '=', 'contracts.id_beneficiary')
                        ->where('companies.id_user', $id_user)
                        ->get();
        $countMyContracts = Contract::where('companies.id_user', $id_user)
                            ->join('companies', 'companies.id', '=', 'contracts.id_provider')
                            ->count();
        return ['ok' => 1, 'myContracts' => $myContracts, 'countMyContracts' => $countMyContracts];        
    }

    function getContractsForAppendicies(Request $request){
        $id_provider = $request->route('id_provider');
        $id_beneficiary = $request->route('id_beneficiary');

        $contracts = Contract::select('contracts.id AS id', 'contracts.no AS no', 'contracts.date AS date')
                        ->where(['contracts.id_provider' => $id_provider, 'contracts.id_beneficiary' => $id_beneficiary])
                        ->get();
        return ['ok' => 1, 'contracts' => $contracts];        
    }
}
