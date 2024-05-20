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

    function edit(Request $request){
        $input = $request->input();
        $id = $input['id']; unset($input['id']);

        if(Contract::where(['no' => $input['no'], 'id_provider' => $input['id_provider']])->exists()){
            return ['ok' => 0, 'message' => 'A contract with the same number for the selected provider already exists!', 'fields' => ['no', 'id_provider']];
        }else{
            Contract::where('id', $id)->update($input);
            return ['ok' => 1];
        }

        // $contract->save();
    }

    function getMyContracts(Request $request){
        $id_user = $request->route('id_user');
        $myContracts = Contract::select('contracts.id AS id', 'contracts.no AS no', 'contracts.date AS date', 'contracts.expiration_date AS expiration_date', 'contracts.id_provider AS id_provider', 'companies.name AS provider', 'contracts.id_beneficiary AS id_beneficiary', 'partners.name AS beneficiary')
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
