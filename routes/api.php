<?php

use App\Http\Controllers\Api\Importm1Controller;
use App\Http\Controllers\Api\StorageManagerController;
use Illuminate\Support\Facades\Route;


Route::group(["prefix" => "file-manager"], function () {
    Route::get("/{uuid?}", [StorageManagerController::class, 'manager']);
});


Route::group(["prefix" => "import-v1"], function () {
    Route::get("/", [Importm1Controller::class, 'index']);
});
