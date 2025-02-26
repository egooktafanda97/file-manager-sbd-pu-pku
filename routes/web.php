<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\FileManagerController;
use App\Http\Controllers\FileShareController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', [UserController::class, 'login'])->name('login');
Route::get('/login', [UserController::class, 'login'])->name('login');
Route::post('/login', [UserController::class, '_login'])->name('login.post');
Route::get('/logout', [UserController::class, 'logout'])->name('logout');


// dashboard

Route::group(["prefix" => "dashboard", "middleware" => "auth:web"], function () {
    Route::get(
        '/',
        [DashboardController::class, 'index']
    )->name('dashboard');
});

Route::group(["prefix" => "file-manager", "middleware" => "auth:web"], function () {

    Route::post('/upload', [FileManagerController::class, 'upload'])->name('file-manager.upload');
    Route::post('/new-folder', [FileManagerController::class, 'newFolder'])->name('file-manager.new-folder');
    // deleted
    Route::delete('/{uuid}', [FileManagerController::class, 'destroy'])->name('file-manager.destroy');

    Route::get('/{uuid}/preview', [FileManagerController::class, 'getPreview'])->name('file-manager.preview');
    // read
    Route::get('/{uuid}/first', [FileManagerController::class, 'getFirst'])->name('file-manager.get-first');

    // info
    Route::get('/{uuid}/file-info', [FileManagerController::class, 'getFileInfo'])->name('file-manager.info');

    //toggleFavorite
    Route::get('/{uuid}/toggle-favorite', [FileManagerController::class, 'toggleFavorite'])->name('file-manager.toggle-favorite');

    // getUserSharedInFile
    Route::get('/{uuid}/shared', [FileManagerController::class, 'getUserSharedInFile'])->name('file-manager.shared');

    // showFavorite
    Route::get('/favorite', [FileManagerController::class, 'showFavorite'])->name('file-manager.favorite');

    //post update
    Route::post('/updated', [FileManagerController::class, 'update'])->name('file-manager.updated');
    //downlaod
    Route::get('/{uuid}/download', [FileManagerController::class, 'downloadFile'])->name('file-manager.file-download');

    Route::post('/delete-bulk', [FileManagerController::class, 'bulkDelete'])->name('file-manager.delete-bulk');

    // file share
    Route::get('/share', [FileManagerController::class, 'fileShared'])->name('file-manager.share');

    // search
    Route::get('/search-files', [FileManagerController::class, 'searchFiles'])->name('file-manager.search');

    Route::get('/{uuid?}', [FileManagerController::class, 'index'])->name('file-manager.index');
});


// user
Route::group(["prefix" => "users"], function () {
    Route::get('/', [UserController::class, 'index'])->name('user.index');
    Route::post('/store', [UserController::class, 'store'])->name('user.store');
    Route::delete('/destroy/{uuid}', [UserController::class, 'destroy'])->name('user.destroy');

    //permissions
    Route::get('/permissions', [UserController::class, 'permissions'])->name('user.permissions');
    Route::post('/role-store', [UserController::class, 'storeRole'])->name('user.role-store');
    Route::delete('/role-destroy/{id}', [UserController::class, 'destroyRole'])->name('user.role-destroy');
    // set permission
    Route::post('/set-permission', [UserController::class, 'setPermission'])->name('user.set-permission');
    //set role
    Route::get('/set-user-role/{id}', [UserController::class, 'getUserRole'])->name('user.set-user-role');
    // user role
    Route::post('/user-role', [UserController::class, 'setUserRole'])->name('user.user-role');

    Route::put('/{id}', [UserController::class, 'update'])->name('user.update');
    Route::get('/{uuid}', [UserController::class, 'show'])->name('user.show');
});

// shared
Route::group(["prefix" => "file-share", "middleware" => "auth:web"], function () {
    Route::post('/share', [FileShareController::class, 'share'])->name('file-share.share');
    Route::get('/remove-share/{id}/{file_id}', [FileShareController::class, 'removeShare'])->name('file-share.remove-share');
});
