<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Appendix;
use App\Models\AppendixItem;

class AppendixItemController extends Controller
{
    function add(Request $request){
        $input = $request->input();
        $id_appendix = $input['id_appendix']; unset($input['id_appendix']);
        $items = [];
        foreach($input as $k => $v){
            $split = explode('-', $k);
            if(isset($split[1]) && isset($split[0])){
                if(!isset($items[$split[1]]['id_appendix'])){ $items[$split[1]]['id_appendix'] = $id_appendix; }
                $items[$split[1]][$split[0]] = $v;
            }
        }

        $total = 0;
        foreach($items as $item){
            $total += ($item['quantity'] * $item['unit_price']);
            $appendixItem = new AppendixItem;
            foreach($item as $key => $value){ $appendixItem->$key = $value; }
            $appendixItem->save();
        }

        Appendix::where('id', $id_appendix)->update(['value' => $total]);

        return ['ok' => 1];
    }

    function getAppendixItems(Request $request){
        $id_appendix = $request->route('id_appendix');
        $items = AppendixItem::select('appendicies_items.id AS id', 'appendicies_items.description AS description', 'appendicies_items.vat_percentage AS vat_percentage', 'appendicies_items.uom AS uom', 'appendicies_items.quantity AS quantity', 'appendicies_items.unit_price AS unit_price')
                        ->where(['appendicies_items.id_appendix' => $id_appendix])
                        ->get();
        $countItems = AppendixItem::where('id_appendix', $id_appendix)
                        ->count();
        return ['ok' => 1, 'items' => $items, 'countItems' => $countItems];        
    }
}
