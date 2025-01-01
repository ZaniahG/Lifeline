<?php

use App\Http\Controllers\GalleryController;
use App\Http\Controllers\IdolImageController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

require __DIR__ . '/auth.php';

Route::get('/', function () {
    return redirect()->route('login');
});


Route::middleware('auth')->group(function () {
    Route::get('/photocards', [IdolImageController::class, 'index'])->name('photocards');
    
    Route::post('/photocard/upload', [GalleryController::class, 'upload'])->name('photocard.upload');
    Route::get('/photocard/delete/{id}', [GalleryController::class, 'delete'])->name('photocard.delete');
    
    Route::post('/idol/upload', [IdolImageController::class, 'idolUpload'])->name('idol.upload');
    Route::get('/edit-idol-name', [IdolImageController::class, 'editIdolName'])->name('edit.idol.name');
    Route::post('/store-idol-name', [IdolImageController::class, 'storeIdolName'])->name('store.idol.name');

});
