<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ReportController; // Diperlukan untuk rute report PDF

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

// Rute 1: Mengalihkan halaman utama (root) ke panel admin
Route::redirect('/', '/admin');

// Rute 2: Menangani permintaan download laporan PDF
Route::get('/report/transactions/{year}/{month}', [ReportController::class, 'downloadTransactionsPdf'])
    ->name('report.transactions.pdf');

// Rute 3: Diperlukan oleh Render untuk memeriksa apakah aplikasi berjalan (Health Check)
Route::get('/up', function() {
    return response('OK', 200);
});