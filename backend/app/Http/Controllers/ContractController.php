<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Models\Contract;

class ContractController extends Controller
{
    function add(Request $request){
        $input = $request->input();
        unset($input['id_user']);
        $response = ['ok' => 0];
        if(Contract::where(['no' => $input['no'], 'id_provider' => $input['id_provider'], 'id_beneficiary' => $input['id_beneficiary']])->exists()){
            $response['generalError'] = [
                'names' => ['no', 'id_provider', 'id_beneficiary'],
                'alertDanger' => 'A contract with the same number already exists for the selected provider and beneficiary!',
            ];
        }else{
            $contract = new Contract;
            foreach($input as $key => $value){ $contract->$key = $value; }
            $contract->save();
            $response = ['ok' => 1, 'message' => 'The contract has been added successfully!'];
        }
        return $response;
    }

    function edit(Request $request){
        $input = $request->input();
        $id = $input['id']; unset($input['id']); 
        unset($input['id_user']);
        $response = ['ok' => 0];
        if(Contract::where(['no' => $input['no'], 'id_provider' => $input['id_provider']])->exists()){
            $response['generalError'] = [
                'alertDanger' => 'A contract with the same number for the selected provider already exists!',
                'names' => ['no', 'id_provider']
            ];
        }else{
            Contract::where('id', $id)->update($input);
            $response = ['ok' => 1, 'message' => 'The contract has been edited successfully!'];
        }
        return $response;
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

        $options = Contract::select('id AS value', DB::raw("CONCAT(no, ' from ', date) AS text"))
                        ->where(['id_provider' => $id_provider, 'id_beneficiary' => $id_beneficiary])
                        ->get();
        return ['ok' => 1, 'options' => $options];        
    }
}
