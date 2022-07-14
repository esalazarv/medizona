<?php

use App\Http\Controllers\Api\CustomerController;
use App\Http\Controllers\Api\ItemController;
use App\Http\Controllers\Api\NoteController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['prefix' => 'customers'], function () {
    Route::get('/', [CustomerController::class, 'index'])->name('customer:list');
});

Route::group(['prefix' => 'items'], function () {
    Route::get('/', [ItemController::class, 'index'])->name('item:list');
});

Route::group(['prefix' => 'notes'], function () {
    Route::get('/', [NoteController::class, 'index'])->name('api.note.list');;
    Route::post('/', [NoteController::class, 'store'])->name('api.note.store');;
    Route::get('/{note}', [NoteController::class, 'show'])->name('api.note.show');;
    Route::patch('/{note}', [NoteController::class, 'update'])->name('api.note.update');;
    Route::delete('/{note}', [NoteController::class, 'destroy'])->name('api.note.delete');;
});
