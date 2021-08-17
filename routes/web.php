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
/*
Route::get('/', function () {
    return redirect('my-pastes');
});*/

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

Route::resource('pastes', \App\Http\Controllers\PasteController::class)->middleware(['auth']);

Route::get('/my-pastes', [\App\Http\Controllers\PasteController::class, 'index'])->middleware(['auth'])->name('pastes.myPastes');
Route::get('/', [\App\Http\Controllers\PasteController::class, 'create'])->middleware(['auth'])->name('pastes.newPaste');
/*
Route::get('/pastes', function (){
    return redirect(\route('pastes.myPastes'));
});*/

require __DIR__.'/auth.php';
