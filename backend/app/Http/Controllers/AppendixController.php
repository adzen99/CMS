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
        $myAppendicies = Appendix::select('appendicies.id AS id', 
                                        'appendicies.series AS series', 
                                        'appendicies.no AS no', 
                                        'appendicies.date AS date', 
                                        'appendicies.value as value', 
                                        'appendicies.currency AS currency', 
                                        'appendicies.vat_percentage AS vat_percentage', 
                                        'appendicies.vat AS vat', 
                                        'companies.name AS provider', 
                                        'companies.address AS provider_address', 
                                        'companies.cui AS provider_cui', 
                                        'companies.nr_reg AS provider_nr_reg', 
                                        'companies.iban AS iban', 
                                        'partners.name AS beneficiary',
                                        'partners.address AS beneficiary_address',  
                                        'partners.cui AS beneficiary_cui',  
                                        'partners.nr_reg AS beneficiary_nr_reg',  
                                        'contracts.no AS no_contract', 
                                        'contracts.date AS contract_date',
                                        'l1.name AS provider_locality',
                                        'c1.name AS provider_county',
                                        'l2.name AS beneficiary_locality',
                                        'c2.name AS beneficiary_county',
                                        'banks.name AS provider_bank',
                                        'users.first_name AS user_first_name',
                                        'users.last_name AS user_last_name',
                                        )
                                    ->join('companies', 'companies.id', '=', 'appendicies.id_provider')
                                    ->join('partners', 'partners.id', '=', 'appendicies.id_beneficiary')
                                    ->join('contracts', 'contracts.id', '=', 'appendicies.id_contract')
                                    ->join('counties AS c1', 'c1.id', '=', 'companies.id_county')
                                    ->join('localities AS l1', 'l1.id', '=', 'companies.id_locality')
                                    ->join('banks', 'banks.id', '=', 'companies.id_bank')
                                    ->join('counties AS c2', 'c2.id', '=', 'partners.id_county')
                                    ->join('localities AS l2', 'l2.id', '=', 'partners.id_locality')
                                    ->join('users', 'users.id', '=', 'companies.id_user')
                                    ->where('companies.id_user', $id_user)
                        ->get();
        $countMyAppendicies = Appendix::where('companies.id_user', $id_user)
                            ->join('companies', 'companies.id', '=', 'appendicies.id_provider')
                            ->count();
        return ['ok' => 1, 'myAppendicies' => $myAppendicies, 'countMyAppendicies' => $countMyAppendicies];        
    }

    function getAppendiciesForInvoices(Request $request){
        $id_user = $request->route('id_user');
        $appendicies = Appendix::select('appendicies.id AS id', 'appendicies.series AS series', 'appendicies.no AS no', 'appendicies.date AS date', 'appendicies.id_provider AS id_provider', 'appendicies.id_beneficiary AS id_beneficiary')
                        ->join('companies', 'companies.id', '=', 'appendicies.id_provider')
                        ->where(['companies.id_user' => $id_user, 'id_invoice' => 0])
                        ->get();
        return ['ok' => 1, 'appendicies' => $appendicies];        
    }
}
