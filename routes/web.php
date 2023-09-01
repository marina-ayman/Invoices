<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\Customers_ReportController;
use App\Http\Controllers\InvoiceAchiveController;
use App\Http\Controllers\Invoices_ReportController;
use App\Http\Controllers\InvoicesController;
use App\Http\Controllers\InvoicesDetailsController;
use App\Http\Controllers\InvoicesAttachmentsController;
use App\Http\Controllers\ProductsController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\SectionController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Auth;
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
// Auth::routes(['register' => false]);
// invoices\edit',$invoices->id)
// logaut


Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');


Route::resource('InvoiceAttachments', InvoicesAttachmentsController::class);
Route::resource('invoices', InvoicesController::class);
Route::resource('sections', SectionController::class);
Route::resource('products', ProductsController::class);

Route::resource('Arctive_Invoices', InvoiceAchiveController::class);
Route::post('delete_file', [InvoicesDetailsController::class,'destroy'])->name('delete_file');

Route::get('Print_invoice/{id}', [InvoicesController::class,'Print_invoice']);
Route::get('download/{invoice_number}/{file_name}',[InvoicesDetailsController::class,'get_file']);
Route::get('view_file/{invoices_number}/{file_name}', [InvoicesDetailsController::class,'open_file']);


Route::get('invoice_paid', [InvoicesController::class,'invoice_paid']);
Route::get('invoice_unpaid', [InvoicesController::class,'invoice_unpaid']);
Route::get('invoice_partial', [InvoicesController::class,'invoice_partial']);



Route::get('status_show/{id}', [InvoicesController::class,'Status_show'])->name('status_show');

Route::post('Status_Update/{id}', [InvoicesController::class,'Status_Update'])->name('Status_Update');

Route::get('edit_invoice/{id}', [InvoicesController::class,'edit']);
Route::get('InvoicesDetails/{id}',[ InvoicesDetailsController::class,'show']);
Route::get('/section/{id}', [InvoicesController::class,'getproducts']);


Route::group(['middleware' => ['auth']], function() {
    Route::resource('roles', RoleController::class);
    Route::resource('users', UserController ::class);
    // Route::resource('products', ProductController::class);
});

Route::get('/invoices_report', [Invoices_ReportController::class,'index']);
Route::post('/Search_invoices', [Invoices_ReportController::class,'Search_invoices']);


Route::get('customers_report',  [Customers_ReportController::class,'index'])->name("customers_report");
Route::post('Search_customers',  [Customers_ReportController::class,'Search_customers']);



Route::get('MarkAsRead_all',[InvoicesController::class,'MarkAsRead_all'])->name('MarkAsRead_all');
Route::get('unreadNotifications_count', [ InvoicesController::class,'unreadNotifications_count'])->name('unreadNotifications_count');
Route::get('unreadNotifications',[InvoicesController::class,'unreadNotifications'])->name('unreadNotifications');



Route::get('/{page}', [AdminController::class,'index']);