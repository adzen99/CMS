<?php

use App\Http\Controllers\AppendixController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\CompanyController;
use App\Http\Controllers\ContractController;
use App\Http\Controllers\PartnerController;
use App\Http\Controllers\UserController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware('cors')->group(function(){
    Route::post('addCompany', [CompanyController::class, 'add']);
    Route::get('getMyCompanies/{id_user}', [CompanyController::class, 'getMyCompanies']);
    Route::get('getMyCompaniesForProviders/{id_user}', [CompanyController::class, 'getMyCompaniesForProviders']);

    Route::put('setUserInfo', [UserController::class, 'updateInfo']);

    Route::post('addPartner', [PartnerController::class, 'add']);
    Route::get('getMyPartners/{id_user}', [PartnerController::class, 'getMyPartners']);
    Route::get('getMyPartnersForBeneficiaries/{id_user}', [PartnerController::class, 'getMyPartnersForBeneficiaries']);

    Route::post('addContract', [ContractController::class, 'add']);
    Route::get('getMyContracts/{id_user}', [ContractController::class, 'getMyContracts']);

    Route::post('addAppendix', [AppendixController::class, 'add']);
    Route::get('getMyAppendicies/{id_user}', [AppendixController::class, 'getMyAppendicies']);
    Route::get('getAppendiciesForInvoices/{id_user}', [AppendixController::class, 'getAppendiciesForInvoices']);

});

