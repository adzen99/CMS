<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Invoice;
use App\Models\Appendix;
use App\Models\ExchangeRate;

class InvoiceController extends Controller
{
    function add(Request $request){
        $input = $request->input();
        unset($input['id_user']);
        if(Invoice::where(['no' => $input['no'], 'series' => $input['series'], 'id_provider' => $input['id_provider']])->exists()){
            return ['ok' => 0, 'generalError' => [
                'names' => ['series', 'no'],
                'alertDanger' => 'An invoice with the same series and number already exists!',
                ]
            ];
        }else{
            $invoice = new Invoice;
            foreach($input as $key => $value){ $invoice->$key = $value; }
            if(isset($input['id_appendix'])){
                $appendix = Appendix::where(['id' => $input['id_appendix']])->first();
                if($appendix){
                    if($appendix->currency != $invoice->currency){
                        $exchangeRate = ExchangeRate::where(['date' => $input['date']])->first();
                        if($exchangeRate){
                            $rates = (array)json_decode($exchangeRate->rates);
                            $rateValue = isset($rates[$appendix->currency]) ? $rates[$appendix->currency] : null;
                            if(!$rateValue){
                                return ['ok' => 0, 'toastError' => 'Cannot convert the selected currency!'];
                            }else{
                                $value = convertCurrency($appendix->value, $appendix->currency, $invoice->currency, $rates);
                                $invoice->value = $value !== null ? $value : 0;
                            }   
                        }else{
                            return ['ok' => 0, 'generalError' => [
                                'names' => ['series', 'no'],
                                'alertDanger' => 'Exchange rate for the selected date does not exist!',
                                ]
                            ];
                        }
                    }else{
                        $invoice->value = $appendix->value;
                    }
                }
            }

            $invoice->save();
            if(isset($input['id_appendix'])){
                $inv = Invoice::where('id_appendix', '!=', 0)->orderBy('id', 'DESC')->first();
                if($inv){
                    Appendix::where('id', $input['id_appendix'])->update(['id_invoice' => $inv->id]);
                }
            }
            return ['ok' => 1, 'message' => 'The invoice has been added successfully!'];
        }
    }

    function edit(Request $request){
        $input = $request->input();
        $id = $input['id']; unset($input['id']); 
        unset($input['id_user']);
        $response = ['ok' => 0];
        if(Invoice::where(['no' => $input['no'], 'series' => $input['series'], 'id_provider' => $input['id_provider']])->where('id' , '<>', $id)->exists()){
            $response['generalError'] = [
                'names' => ['series', 'no'],
                'alertDanger' => 'An invoice with the same series and number already exists!',
            ];
        }else{
            Invoice::where('id', $id)->update($input);
            $response = ['ok' => 1, 'message' => 'The invoice has been edited successfully!'];
            // to do: if the invoice has an associated appendix, make validations
        }
        return $response;
    }

    function delete(Request $request){
        $input = $request->input();
        $id = $input['id'];
        $response = ['ok' => 0];

        $invoice = Invoice::where('id', $id)->first();
        if($invoice && $invoice->id_appendix){
            Appendix::where('id', $invoice->id_appendix)->update(['id_invoice' => 0]);
        }
        Invoice::find($id)->delete();
        $response = ['ok' => 1, 'message' => 'The invoice has been deleted!'];
        
        return $response;
    }

    function getMyInvoices(Request $request){
        $id_user = $request->route('id_user');
        $myInvoices = Invoice::select('invoices.id AS id', 
                                        'invoices.series AS series', 
                                        'invoices.no AS no', 
                                        'invoices.date AS date', 
                                        'invoices.due_date as due_date', 
                                        'invoices.value as value',
                                        'invoices.id_appendix as id_appendix',
                                        'invoices.id_provider as id_provider',
                                        'invoices.id_beneficiary as id_beneficiary',        
                                        'invoices.currency AS currency', 
                                        'invoices.vat_percentage AS vat_percentage', 
                                        'invoices.vat AS vat', 
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
                                    ->join('companies', 'companies.id', '=', 'invoices.id_provider')
                                    ->join('partners', 'partners.id', '=', 'invoices.id_beneficiary')
                                    ->leftJoin('contracts', 'contracts.id', '=', 'invoices.id_contract')
                                    ->join('counties AS c1', 'c1.id', '=', 'companies.id_county')
                                    ->join('localities AS l1', 'l1.id', '=', 'companies.id_locality')
                                    ->join('banks', 'banks.id', '=', 'companies.id_bank')
                                    ->join('counties AS c2', 'c2.id', '=', 'partners.id_county')
                                    ->join('localities AS l2', 'l2.id', '=', 'partners.id_locality')
                                    ->join('users', 'users.id', '=', 'companies.id_user')
                                    ->where('companies.id_user', $id_user)
                        ->get();
        $countMyInvoices = Invoice::where('companies.id_user', $id_user)
                            ->join('companies', 'companies.id', '=', 'invoices.id_provider')
                            ->count();
        return ['ok' => 1, 'myInvoices' => $myInvoices, 'countMyInvoices' => $countMyInvoices];        
    }
}
