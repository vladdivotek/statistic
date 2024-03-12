<?php

use Illuminate\Support\Facades\Route;

Route::get('statistic', [\App\Http\Controllers\StatisticController::class, 'index'])->name('statistic.index');
Route::get('statistic/generate', [\App\Http\Controllers\StatisticController::class, 'generate'])->name('statistic.generate');
