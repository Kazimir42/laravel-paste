<?php

use App\Http\Controllers\PasteController;
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
    return redirect('pastes');
})->middleware(['auth']);

Route::get('/pastes/create', [PasteController::class, 'create'])->name('pastes.create');
Route::post('/pastes', [PasteController::class, 'store'])->name('pastes.store');


Route::get('/pastes', [PasteController::class, 'index'])->name('pastes.index');
Route::get('/pastes/public', [PasteController::class, 'public'])->name('pastes.public');

Route::get('/pastes/{not_listed_id}', [PasteController::class, 'show'])->name('pastes.show');

Route::get('/pastes/{not_listed_id}/edit', [PasteController::class, 'edit'])->name('pastes.edit');
Route::put('/pastes/{not_listed_id}', [PasteController::class, 'update'])->name('pastes.update');


Route::delete('/pastes/{not_listed_id}', [PasteController::class, 'destroy'])->name('pastes.destroy');


//Route::resource('pastes', \App\Http\Controllers\PasteController::class);



require __DIR__.'/auth.php';
