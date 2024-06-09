<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Appendix;
use App\Models\AppendixItem;
use App\Models\Invoice;
use App\Models\ExchangeRate;

class AppendixItemController extends Controller
{
    function add(Request $request){
        $input = $request->input();
        $id_appendix = $input['id']; unset($input['id']);
        $items = []; $ids = [];
        foreach($input as $k => $v){
            $split = explode('-', $k);
            if(isset($split[1]) && isset($split[0])){
                if($split['0'] == 'id' && $v){
                    $ids[] = $v;
                }
                if(!isset($items[$split[1]]['id_appendix'])){ $items[$split[1]]['id_appendix'] = $id_appendix; }
                $items[$split[1]][$split[0]] = $v;
            }
        }   
        AppendixItem::whereNotIn('id', $ids)->where('id_appendix', $id_appendix)->delete();

        $total = 0;
        foreach($items as $item){
            $total += ($item['quantity'] * $item['unit_price']);
            if($item['id']){
                $update = [];
                foreach($item as $k => $v){
                    if(!in_array($k, ['id_appendix', 'id'])){
                        $update[$k] = $v;
                    }
                }
                if($update){
                    AppendixItem::where('id', $item['id'])->update($update);
                }
            }else{
                $appendixItem = new AppendixItem;
                foreach($item as $key => $value){
                    if(!in_array($key, ['id'])){
                        $appendixItem->$key = $value; 
                    }
                }
                $appendixItem->save();
            }
        }
        Appendix::where('id', $id_appendix)->update(['value' => $total]);

        $invoice = Invoice::where(['id_appendix' => $id_appendix])->first();

        if($invoice){
            $appendix = Appendix::where(['id' => $id_appendix])->first();
            if($appendix){
                $value = $appendix->value;
                if($appendix->currency != $invoice->currency){
                    $exchangeRate = ExchangeRate::where(['date' => $invoice->date])->first();
                    if($exchangeRate){
                        $rates = (array)json_decode($exchangeRate->rates);
                        $rateValue = isset($rates[$appendix->currency]) ? $rates[$appendix->currency] : null;
                        if($rateValue){
                            $value = convertCurrency($appendix->value, $appendix->currency, $invoice->currency, $rates);
                            $value = $value !== null ? $value : 0;
                        }
                    }                    
                }
            }
            Invoice::where(['id' => $invoice->id])->update(['value' => $value]);
        }

        return ['ok' => 1, 'message' => 'The appendix items have been updated successfully!'];
    }

    function getAppendixItems(Request $request){
        $id_appendix = $request->route('id_appendix');
        $items = AppendixItem::select('appendicies_items.id AS id', 'appendicies_items.description AS description', 'appendicies_items.vat_percentage AS vat_percentage', 'appendicies_items.uom AS uom', 'appendicies_items.quantity AS quantity', 'appendicies_items.unit_price AS unit_price')
                        ->where('appendicies_items.id_appendix', $id_appendix)
                        ->get();
        $countItems = AppendixItem::where('id_appendix', $id_appendix)
                        ->count();

        $appendix = Appendix::where('id', $id_appendix)->first();
        $exchangeRateToRON = '-';
        if($appendix && $appendix->currency !== 'RON'){
            $exchangeRate = ExchangeRate::where('date', $appendix->date)->first();
            if($exchangeRate){
                $decodeRates = (array)json_decode($exchangeRate->rates);
                $exchangeRateToRON = isset($decodeRates[$appendix->currency]) ? $decodeRates[$appendix->currency] : '-';
            }
        }
        return ['ok' => 1, 'items' => $items, 'countItems' => $countItems, 'exchangeRateToRON' => $exchangeRateToRON];        
    }
}
