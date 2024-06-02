<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;
use App\Models\Appendix;
use App\Models\Invoice;

class AppendixController extends Controller
{
    function add(Request $request){
        $input = $request->input();
        unset($input['id_user']);
        $response = ['ok' => 0];
        if(Appendix::where(['no' => $input['no'], 'series' => $input['series'], 'id_provider' => $input['id_provider']])->exists()){
            $response['generalError'] = [
                'names' => ['series', 'no'],
                'alertDanger' => 'An appendix with the same series and number already exists!',
            ];
        }else{
            $appendix = new Appendix;
            foreach($input as $key => $value){ $appendix->$key = $value; }
            $appendix->save();
            $response = ['ok' => 1, 'message' => 'The appendix has been added successfully!'];
        }
        return $response;
    }

    function edit(Request $request){
        $input = $request->input();
        $id = $input['id']; unset($input['id']); 
        unset($input['id_user']);
        $response = ['ok' => 0];
        if(Appendix::where(['no' => $input['no'], 'series' => $input['series'], 'id_provider' => $input['id_provider']])->where('id' , '<>', $id)->exists()){
            $response['generalError'] = [
                'names' => ['series', 'no'],
                'alertDanger' => 'An appendix with the same series and number already exists!',
            ];
        }else{
            Appendix::where('id', $id)->update($input);
            $response = ['ok' => 1, 'message' => 'The appendix has been edited successfully!'];
            // to do: if the appendix has an associated invoice, update the info for it
        }
        return $response;
    }

    function delete(Request $request){
        $input = $request->input();
        $id = $input['id'];
        $response = ['ok' => 0];
        $messages = [];

        $countInvoices = Invoice::where('id_appendix', $id)->count();
        if($countInvoices){
            $messages[] = 'The appendix has an associated invoice!';
        }

        if(!$countInvoices){
            Appendix::find($id)->delete();
            $response = ['ok' => 1, 'message' => 'The appendix has been deleted!'];
        }else{
            $response['toastErrorMessage'] = implode("\n", $messages);
        }
        return $response;
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
                                        'appendicies.id_provider AS id_provider', 
                                        'companies.name AS provider', 
                                        'companies.address AS provider_address', 
                                        'companies.cui AS provider_cui', 
                                        'companies.nr_reg AS provider_nr_reg', 
                                        'companies.iban AS iban', 
                                        'appendicies.id_beneficiary AS id_beneficiary', 
                                        'partners.name AS beneficiary',
                                        'partners.address AS beneficiary_address',  
                                        'partners.cui AS beneficiary_cui',  
                                        'partners.nr_reg AS beneficiary_nr_reg',
                                        'appendicies.id_contract AS id_contract',   
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
        $appendicies = Appendix::select('appendicies.id AS value',  DB::raw("CONCAT(appendicies.series, appendicies.no, ' from ', appendicies.date) AS text"), 'appendicies.id_provider as id_provider', 'appendicies.id_beneficiary as id_beneficiary', 'appendicies.date as date')
                        ->join('companies', 'companies.id', '=', 'appendicies.id_provider')
                        ->where(['companies.id_user' => $id_user, 'id_invoice' => 0])
                        ->get();
        $options = [0 => '']; $fillOtherFields = [];
        foreach($appendicies as $appendix){
            $options[] = ['value' => $appendix->value, 'text' => $appendix->text];
            $fillOtherFields[$appendix->value]['id_provider'] = $appendix->id_provider;
            $fillOtherFields[$appendix->value]['id_beneficiary'] = $appendix->id_beneficiary;
            $fillOtherFields[$appendix->value]['date'] = $appendix->date;
        }

        return ['ok' => 1, 'options' => $options, 'fillOtherFields' => $fillOtherFields];        
    }
    function getAppendiciesForInvoicesEdit(Request $request){
        $id_user = $request->route('id_user');
        $id_invoice = $request->route('id_invoice');
        $appendicies = Appendix::select('appendicies.id AS value',  DB::raw("CONCAT(appendicies.series, appendicies.no, ' from ', appendicies.date) AS text"), 'appendicies.id_provider as id_provider', 'appendicies.id_beneficiary as id_beneficiary', 'appendicies.date as date')
                        ->join('companies', 'companies.id', '=', 'appendicies.id_provider')
                        ->where(['companies.id_user' => $id_user])
                        ->whereIn('id_invoice', [0, $id_invoice])
                        ->get();
        $options = [0 => '']; $fillOtherFields = [];
        foreach($appendicies as $appendix){
            $options[] = ['value' => $appendix->value, 'text' => $appendix->text];
            $fillOtherFields[$appendix->value]['id_provider'] = $appendix->id_provider;
            $fillOtherFields[$appendix->value]['id_beneficiary'] = $appendix->id_beneficiary;
            $fillOtherFields[$appendix->value]['date'] = $appendix->date;
        }

        return ['ok' => 1, 'options' => $options, 'fillOtherFields' => $fillOtherFields];        
    }
}
