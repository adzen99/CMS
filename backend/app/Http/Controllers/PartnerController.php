<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Partner;
use App\Models\Contract;
use App\Models\Appendix;
use App\Models\Invoice;

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

    function edit(Request $request){
        $input = $request->input();
        $id = $input['id']; unset($input['id']); 
        unset($input['id_user']);
        $response = ['ok' => 0];
        if(Partner::where(['cui' => $input['cui']])->where('id' , '<>', $id)->exists()){
            $response['generalError'] = [
                'alertDanger' => 'A partner with the same CUI already exists!',
                'names' => ['cui']
            ];
        }else{
            Partner::where('id', $id)->update($input);
            $response = ['ok' => 1, 'message' => 'The partner has been edited successfully!'];
        }
        return $response;
    }

    function delete(Request $request){
        $input = $request->input();
        $id = $input['id'];
        $response = ['ok' => 0];
        $messages = [];
        $countContracts = Contract::where('id_beneficiary', $id)->count();
        if($countContracts){
            $messages[] = 'The partner has associated contracts!';
        }
        $countAppendicies = Appendix::where('id_beneficiary', $id)->count();
        if($countAppendicies){
            $messages[] = 'The partner has associated appendicies!';
        }

        $countInvoices = Invoice::where('id_beneficiary', $id)->count();
        if($countInvoices){
            $messages[] = 'The partner has associated invoices!';
        }

        if(!$countContracts && !$countAppendicies && !$countInvoices){
            Partner::find($id)->delete();
            $response = ['ok' => 1, 'message' => 'The partner has been deleted!'];
        }else{
            $response['toastErrorMessage'] = implode("\n", $messages);
        }
        return $response;
    }

    function getMyPartners(Request $request){
        $id_user = $request->route('id_user');
        $myPartners = Partner::select('partners.id AS id', 'partners.name AS name', 'partners.address AS address', 'partners.id_locality AS id_locality', 'localities.name AS locality', 'partners.id_county AS id_county', 'counties.name AS county', 'partners.cui AS cui', 'partners.nr_reg AS nr_reg')
                        ->join('counties', 'counties.id', '=', 'partners.id_county')
                        ->join('localities', 'localities.id', '=', 'partners.id_locality')
                        ->where('id_user', $id_user)
                        ->get();
        $countMyPartners = Partner::where('id_user', $id_user)->count();
        return ['ok' => 1, 'myPartners' => $myPartners, 'countMyPartners' => $countMyPartners];        
    }

    function getMyPartnersForBeneficiaries(Request $request){
        $id_user = $request->route('id_user');
        $options = Partner::select('partners.id AS value', 'partners.name AS text')
                        ->where('id_user', $id_user)
                        ->get();
        return ['ok' => 1, 'options' => $options];        
    }
}
