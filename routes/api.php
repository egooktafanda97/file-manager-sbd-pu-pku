<?php

use App\Http\Controllers\Api\StorageManagerController;
use Illuminate\Support\Facades\Route;


Route::group(["prefix" => "file-manager"], function () {
    Route::get("/{uuid?}", [StorageManagerController::class, 'manager']);
});
