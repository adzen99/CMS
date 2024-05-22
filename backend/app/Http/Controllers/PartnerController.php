<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Partner;

class PartnerController extends Controller
{
    function add(Request $request){
        $input = $request->input();
        $response = ['ok' => 0];

        if(Partner::where('cui', $input['cui'])->exists()){
            $response['errors'][] = [
                'name' => 'cui',
                'errorMessage' => 'A partner with the same CUI already exists!',
            ];
        }else{
            $partner = new Partner;
            foreach($input as $key => $value){ $partner->$key = $value; }
            $partner->save();
            $response = ['ok' => 1, 'message' => 'The partner has been added successfully!'];
        }
        
        return $response;
    }

    function getMyPartners(Request $request){
        $id_user = $request->route('id_user');
        $myPartners = Partner::select('partners.name AS name', 'partners.address AS address', 'localities.name AS locality', 'counties.name AS county', 'partners.cui AS cui', 'partners.nr_reg AS nr_reg')
                        ->join('counties', 'counties.id', '=', 'partners.id_county')
                        ->join('localities', 'localities.id', '=', 'partners.id_locality')
                        ->where('id_user', $id_user)
                        ->get();
        $countMyPartners = Partner::where('id_user', $id_user)->count();
        return ['ok' => 1, 'myPartners' => $myPartners, 'countMyPartners' => $countMyPartners];        
    }

    function getMyPartnersForBeneficiaries(Request $request){
        $id_user = $request->route('id_user');
        $beneficiaries = Partner::select('partners.id AS id', 'partners.name AS name')
                        ->where('id_user', $id_user)
                        ->get();
        return ['ok' => 1, 'beneficiaries' => $beneficiaries];        
    }
}
