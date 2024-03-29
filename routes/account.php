<?php

use Illuminate\Support\Facades\Route;

Route::post('/tree_account', 'Account\AccountController@tree_account');
Route::post('/account/{id}', 'Account\AccountController@edit');
Route::post('/delete_account/{id}', 'Account\AccountController@destroy');
Route::post('/store_account', 'Account\AccountController@store');
Route::post('/account_list', 'Account\DailyController@index');
Route::post('/account_list/{id}', 'Account\AccountController@AccountStatement');
Route::post('/account_details_node/{id}', 'Account\AccountController@account_details_node');
Route::post('/account_update_node/{id}', 'Account\AccountController@account_update_node');
Route::post('/account_edit_node/{id}', 'Account\AccountController@account_edit_node');
// ------------------------------------------
Route::post('/account_store_first_level', 'Account\AccountController@account_store_first_level');


Route::post('/account_rename_node/{id}', 'Account\AccountController@account_rename_node');
// Route::post('/dailys', 'DailyController@index');
Route::post('/store_daily', 'Account\DailyController@store');
// ---------------------------------------------
Route::post('/get_account_main/{id}', 'Account\AccountController@get_account_main');
Route::post('/get_account_name/{id}', 'Account\AccountController@get_account_name');
Route::post('/get_account_store/{id}', 'Account\AccountController@get_account');
Route::post('/auditBalance', 'Account\AccountController@auditBalance');

// --------------------------------banks------------------------------------------
Route::post('/banks', 'Account\BankController@show');
Route::post('/store_bank', 'Account\BankController@store');
// --------------------------------Currencies------------------------------------------
Route::post('/currencies', 'Account\CurrencyController@show');
// --------------------------------treasuries------------------------------------------
Route::post('/treasuries', 'Account\TreasuryController@show');
Route::post('/store_treasury', 'Account\TreasuryController@store');
// --------------------------------type_expence------------------------------------------
Route::post('/type_expence', 'Account\TypeExpenceController@show');
// --------------------------------type_income------------------------------------------
Route::post('/type_income', 'Account\TypeIncomeController@show');
// --------------------------------expence_type------------------------------------------
Route::post('/expence_type', 'Account\ExpenceTypeController@show');
Route::post('/expence/newexpence', 'ExpenceController@index');

Route::post('/expence/delete', 'ExpenceController@destroy');

Route::post('/store_expence', 'ExpenceController@store');

Route::post('/payexpence', 'ExpenceController@payment');

Route::post('/expences', 'ExpenceController@show');

Route::post('/expence/newexpencesearch', 'ExpenceController@search_new');

Route::post('/listexpence', 'ExpenceController@show');

Route::post('/listexpencesearch', 'ExpenceController@search');

Route::post('/expence_details/{id}', 'ExpenceController@details_supply');
Route::post('/invoice_expence/{id}', 'ExpenceController@invoice_supply');
Route::post('/recive_expence/{id}', 'ExpenceController@recive_supply');



Route::post('import_account', [AccountController::class, 'import']);
Route::post('export_account', [AccountController::class, 'export']);
