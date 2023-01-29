<?php

// use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RPA\GetAndSaveTableDataController;

Route::prefix('rpa')->group(function () {
    Route::get('/table-data', [GetAndSaveTableDataController::class, 'init']);
});
