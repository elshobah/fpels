<?php

use Illuminate\Support\Facades\Route;
use Modules\Report\Http\Controllers\ReportController;
use Modules\Payment\Http\Controllers\PaymentController;

Route::prefix('report')->as('report.')->middleware(['auth', 'verified', 'installed'])->group(function () {
    Route::get('/', [ReportController::class, 'index'])->name('index');
    Route::get('/student', [ReportController::class, 'student'])->name('student');
    Route::get('/finance', [ReportController::class, 'finance'])->name('finance');
    Route::get('/report2', [PaymentController::class, 'report2'])->name('report2');
    Route::get('print-yearly/{params?}', [PaymentController::class, 'printYearly'])->name('print-yearly');
    Route::get('print-monthly/{params?}', [PaymentController::class, 'printMonthly'])->name('print-monthly');
    Route::get('print-not-monthly/{params?}', [PaymentController::class, 'printNotMonthly'])->name('print-not-monthly');
});

