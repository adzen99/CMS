<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Company;

class CompanyController extends Controller
{
    function add(Request $request){
        $input = $request->input();
        $response = ['ok' => 0];
        if(Company::where('cui', $input['cui'])->exists()){
            $response['errors'][] = [
                'name' => 'cui',
                'errorMessage' => 'A company with the same CUI already exists!',
            ];
        }else{
            $company = new Company;
            foreach($input as $key => $value){ $company->$key = $value; }
            $company->save();
            $response = ['ok' => 1, 'message' => 'The company has been added successfully!'];
        }
        return $response;
    }
    function getMyCompanies(Request $request){
        $id_user = $request->route('id_user');
        $myCompanies = Company::select('companies.name AS name', 'companies.address AS address', 'localities.name AS locality', 'counties.name AS county', 'companies.cui AS cui', 'companies.nr_reg AS nr_reg', 'banks.name as bank', 'companies.iban AS iban')
                        ->join('banks', 'banks.id', '=', 'companies.id_bank')
                        ->join('counties', 'counties.id', '=', 'companies.id_county')
                        ->join('localities', 'localities.id', '=', 'companies.id_locality')
                        ->where('id_user', $id_user)
                        ->get();
        $countMyCompanies = Company::where('id_user', $id_user)->count();
        return ['ok' => 1, 'myCompanies' => $myCompanies, 'countMyCompanies' => $countMyCompanies];        
    }
    function getMyCompaniesForProviders(Request $request){
        $id_user = $request->route('id_user');
        $options = Company::select('companies.id AS value', 'companies.name AS text')
                        ->where('id_user', $id_user)
                        ->get();
        return ['ok' => 1, 'options' => $options];        
    }
}
