<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FE\FEController;

Route::get('/', [FEController::class, 'index'])->name('fe.index');

require __DIR__ . '/auth.php';
