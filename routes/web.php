<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

// Disable default registration screen
Route::get('register', function() {
	return redirect('/');
});

Route::get('/home', 'HomeController@index')->name('home')->middleware('auth');
Route::get('/mycompany','CompanyController@mycompany')->middleware('auth');
Route::resource('company', 'CompanyController')->middleware('auth');
Route::resource('sales-invoice', 'SalesInvoiceController')->middleware('auth');
Route::resource('sales-payment', 'SalesPaymentController')->middleware('auth');
Route::resource('sales-item', 'SalesItemController')->middleware('auth');
Route::resource('purchases-invoice', 'PurchaseInvoiceController')->middleware('auth');
Route::resource('purchases-payment', 'PurchasePaymentController')->middleware('auth');
Route::resource('purchases-item', 'PurchaseItemController')->middleware('auth');
Route::resource('expenses-invoice', 'ExpenseInvoiceController')->middleware('auth');
Route::resource('expenses-payment', 'ExpensePaymentController')->middleware('auth');
Route::resource('stock','StockCountController')->middleware('auth');
Route::resource('cashbalance','CashBalanceController')->middleware('auth');

// Fixing Laravel's routing screw-ups
Route::post('/sales-invoice/{id}','SalesInvoiceController@update');
Route::post('/sales-payment/{id}','SalesPaymentController@update');
Route::post('/sales-item/{id}','SalesItemController@update');
Route::post('/purchases-invoice/{id}','PurchaseInvoiceController@update');
Route::post('/purchases-payment/{id}','PurchasePaymentController@update');
Route::post('/purchases-item/{id}','PurchaseItemController@update');
Route::post('/expenses-invoice/{id}','ExpenseInvoiceController@update');
Route::post('/expenses-payment/{id}','ExpensePaymentController@update');

// Custom pages/routes
Route::get('/sales-item/print/{id}','SalesInvoiceController@print')->middleware('auth');
Route::get('/pl','PLController@index')->middleware('auth');
Route::post('/pl/show','PLController@show')->middleware('auth');
Route::get('/accounting','AccountingController@index')->middleware('auth');
Route::post('/stock/{id}','StockCountController@update');
Route::post('/cashbalance/{id}','CashBalanceController@update');
Route::get('/accounting/balance/{id}/{account}','CompanyController@balance');
Route::get('/accounting/collection-balances','CompanyController@collection_balances');
Route::get('/accounting/payment-balances','CompanyController@payment_balances');