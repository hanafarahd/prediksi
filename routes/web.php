<?php

use App\Models\Home;
use App\Models\Pencatatan;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PencatatanController;
use App\Http\Controllers\PredictionController;

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

//Route Dahsboard
Route::get('/dashboard', [HomeController::class, 'index'])->name('dashboard');

//Route Pencatatan
Route::get('/pencatatan', [PencatatanController::class, 'index']);
Route::get('/add-pencatatan', [PencatatanController::class, 'addPencatatan']);
Route::get('/add-invoice', [PencatatanController::class, 'addInvoice']);
Route::post('/add-invoice/store', [PencatatanController::class, 'storeInvoice']);
Route::post('/add-pencatatan/store/{id}', [PencatatanController::class, 'input']);
// Route::post('/pencatatan/store/{invoice}', [PencatatanController::class, 'store']);
// Route::get('/detail-pencatatan/{id}', [PencatatanController::class, 'detail']);
Route::get('/delete-pencatatan/{id}', [PencatatanController::class, 'delete'])->name('delete-pencatatan');

//kalo mau dicoba pakai flask diganti post
// Route::post('/predict', [PredictionController::class, 'predict'])->name('predict.post');
Route::post('/predict', [PredictionController::class, 'predict']);
