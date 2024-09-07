<?php

use App\Http\Controllers\BukuController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('buku', [BukuController::class, 'index'])->name('buku');
Route::post('buku', [BukuController::class, 'store'])->name('tambah.buku');
Route::get('buku/{id}', [BukuController::class, 'edit'])->name('edit.buku');
Route::put('buku/{id}', [BukuController::class, 'update'])->name('update.buku');
Route::delete('buku/{id}', [BukuController::class, 'destroy'])->name('delete.buku');
