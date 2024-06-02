<?php

use App\Http\Controllers\AppendixController;
use App\Http\Controllers\AppendixItemController;
use App\Http\Controllers\BankController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\CompanyController;
use App\Http\Controllers\ContractController;
use App\Http\Controllers\CountyController;
use App\Http\Controllers\ExchangeRateController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\LocalityController;
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
    Route::put('editCompany', [CompanyController::class, 'edit']);
    Route::delete('deleteCompany', [CompanyController::class, 'delete']);
    Route::get('getMyCompanies/{id_user}', [CompanyController::class, 'getMyCompanies']);
    Route::get('getMyCompaniesForProviders/{id_user}', [CompanyController::class, 'getMyCompaniesForProviders']);

    Route::put('setUserInfo', [UserController::class, 'updateInfo']);

    Route::post('addPartner', [PartnerController::class, 'add']);
    Route::put('editPartner', [PartnerController::class, 'edit']);
    Route::delete('deletePartner', [PartnerController::class, 'delete']);
    Route::get('getMyPartners/{id_user}', [PartnerController::class, 'getMyPartners']);
    Route::get('getMyPartnersForBeneficiaries/{id_user}', [PartnerController::class, 'getMyPartnersForBeneficiaries']);

    Route::post('addContract', [ContractController::class, 'add']);
    Route::put('editContract', [ContractController::class, 'edit']);
    Route::delete('deleteContract', [ContractController::class, 'delete']);
    Route::get('getMyContracts/{id_user}', [ContractController::class, 'getMyContracts']);
    Route::get('getContractsForAppendicies/{id_provider}/{id_beneficiary}', [ContractController::class, 'getContractsForAppendicies']);
    
    Route::post('addAppendix', [AppendixController::class, 'add']);
    Route::put('editAppendix', [AppendixController::class, 'edit']);
    Route::delete('deleteAppendix', [AppendixController::class, 'delete']);
    Route::get('getMyAppendicies/{id_user}', [AppendixController::class, 'getMyAppendicies']);
    Route::get('getAppendiciesForInvoices/{id_user}', [AppendixController::class, 'getAppendiciesForInvoices']);
    Route::get('getAppendiciesForInvoicesEdit/{id_user}/{id_invoice}', [AppendixController::class, 'getAppendiciesForInvoicesEdit']);

    Route::post('addAppendixItem', [AppendixItemController::class, 'add']);
    Route::get('getAppendixItems/{id_appendix}', [AppendixItemController::class, 'getAppendixItems']);

    Route::post('addInvoice', [InvoiceController::class, 'add']);
    Route::put('editInvoice', [InvoiceController::class, 'edit']);
    Route::delete('deleteInvoice', [InvoiceController::class, 'delete']);
    Route::get('getMyInvoices/{id_user}', [InvoiceController::class, 'getMyInvoices']);

    Route::get('getExchangeRatesToday', [ExchangeRateController::class, 'getExchangeRatesToday']);

    Route::get('getCountiesOptions', [CountyController::class, 'getCountiesOptions']);

    Route::get('getOptionsLocalitiesOfCounty/{id_county}', [LocalityController::class, 'getOptionsLocalitiesOfCounty']);

    Route::get('getBanksOptions', [BankController::class, 'getBanksOptions']);

});

