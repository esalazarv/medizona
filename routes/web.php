<?php

use App\Http\Controllers\Web\NoteController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

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



Route::group(['middleware' => ['auth', 'verified']], function (){
    Route::get('/', [NoteController::class, 'index'])->name('dashboard');

    /**
     * Note routes
     */
    Route::group(['prefix' => 'notes'], function () {
        Route::get('/create', [NoteController::class, 'create'])->name('note.create');
        Route::get('/{note}', [NoteController::class, 'edit'])->name('note.edit');
    });
});

require __DIR__.'/auth.php';
