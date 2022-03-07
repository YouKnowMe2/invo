<?php

use App\Http\Controllers\ClientController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\TaskController;
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
    return view('welcome');
});



Route::prefix('dashboard')->middleware(['auth'])->group(function (){

    Route::get('/', function () {
        return view('dashboard');
    })->name('dashboard');

    Route::resource('client',ClientController::class);
    Route::resource('task',TaskController::class);

    Route::put('/task/{task}/complete',[TaskController::class,'status'])->name('status');
    Route::put('/task/search',[TaskController::class,'search'])->name('task.search');

    Route::prefix('invoices')->group(function (){
        Route::get('/',[InvoiceController::class,'index'])->name('invoice.index');
        Route::get('create',[InvoiceController::class,'create'])->name('invoice.create');

        Route::get('preview',[InvoiceController::class,'preview'])->name('invoice.preview');
        Route::get('generate',[InvoiceController::class,'generate'])->name('invoice.generate');
        Route::get('download',[InvoiceController::class,'download'])->name('invoice.download');
        Route::post('sendMail/{invoice:invoice_id}',[InvoiceController::class,'sendMail'])->name('invoice.sendMail');

        Route::get('{invoice}/show',[InvoiceController::class,'show'])->name('invoice.show');
        Route::get('search',[InvoiceController::class,'search'])->name('invoice.search');
        Route::put('{invoice}/update',[InvoiceController::class,'update'])->name('invoice.update');
        Route::put('{invoice}/status',[InvoiceController::class,'status'])->name('invoice.status');
        Route::post('store',[InvoiceController::class,'store'])->name('invoice.store');
        Route::delete('{invoice}/destroy',[InvoiceController::class,'destroy'])->name('invoice.destroy');
    });


});

require __DIR__.'/auth.php';
