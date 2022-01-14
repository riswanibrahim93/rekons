<?php

use App\Http\Controllers\DataController;
use App\Http\Controllers\FilingController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\PDFController;
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

Route::get('/h', function(){
    return view('pages.data.index');
});
Route::group(['middleware' => ['auth']], function () {
    Route::get('/', function () {
        return redirect('/data');
    });
    Route::resource('data', DataController::class);
    Route::get('data-eka', [DataController::class, 'ekaIndex'])->name('eka.data');

    Route::post('data/import_data', [DataController::class, 'importData'])->name('import_datas');
    Route::get('process-recons',[DataController::class,'process'])->name('proses');
    Route::post('checkData', [DataController::class, 'checkData'])->name('check.data');
    Route::post('processRecons', [DataController::class, 'processRecons'])->name('process.data');
    Route::get('processReconsDetail/{branch}', [DataController::class, 'processReconsDetail'])->name('process.dataDetail');
    // return view('welcome');
    Route::resource('pemberkasan', FilingController::class);
    Route::get('data-pemberkasan', [FilingController::class, 'pemberkasan'])->name('data.pemberkasan');

    Route::get('/bavaPDF/{branch}', [PDFController::class, 'bavaPDF'])->name('bavaPDF');
    Route::post('uploadBava', [DataController::class, 'uploadBava'])->name('upload.bava');
});