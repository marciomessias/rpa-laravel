<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RPA\GetAndSaveTableDataController;
use App\Http\Controllers\RPA\FillAndSubmitFormController;

Route::prefix('rpa')->group(function () {
    Route::get('/table-data', [GetAndSaveTableDataController::class, 'init']);
    Route::get('/form', [FillAndSubmitFormController::class, 'init']);
});
