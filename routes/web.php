<?php

use Illuminate\Support\Facades\Route;

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
    return view('auth.login');
});


Auth::routes();
//Auth::routes(['register' => false]);
Route::get('/home', 'HomeController@index')->name('home');


Route::resource('invoices', 'InvoicesController');
Route::resource('sections', 'SectionsController');
Route::resource('products', 'ProductsController');
Route::resource('InvoiceAttachments', 'InvoiceAttachmentsController');
Route::resource('Archive', 'invoiceArchiveController');

Route::get('/section/{id}','InvoicesController@getprouducts');

Route::get('InvoicesDetails/{id}', 'InvoicesDetailsController@edit');

Route::get('download/{invoice_number}/{file_name}', 'InvoicesDetailsController@get_file');

Route::get('view_file/{invoice_number}/{file_name}', 'InvoicesDetailsController@open_file');

Route::post('delete_file', 'InvoicesDetailsController@destroy')->name('delete_file');

Route::get('edit_invoice/{id}', 'InvoicesController@edit');
Route::get('Status_show/{id}', 'InvoicesController@show')->name('Status_show');
Route::post('/status_update/{id}', 'InvoicesController@status_update')->name('Status_Update');
Route::get('/invoices_paid', 'InvoicesController@invoices_paid');
Route::get('/invoices_Unpaid', 'InvoicesController@invoices_Unpaid');
Route::get('/invoices_Partial', 'InvoicesController@invoices_Partial');
Route::get('/Archive', 'invoiceArchiveController@index')->name('Archive');

Route::get('print_invoice/{id}', 'InvoicesController@print_invoice');
Route::get('export_invoices', 'InvoicesController@export');



Route::group(['middleware' => ['auth']], function() {
    Route::resource('roles','RoleController');
    Route::resource('users','UserController');
});




Route::get('invoices_report', 'Invoices_Report@index');

Route::post('Search_invoices', 'Invoices_Report@Search_invoices');


Route::get('customers_report', 'Customers_Report@index')->name('customers_report');

Route::post('Search_customers', 'Customers_Report@Search_customers');





Route::get('/{page}', 'AdminController@index');
