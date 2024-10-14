<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\{PermissionController,RoleController,BookTranslationController,UserController};
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;


Route::get('/', function () {
    if (Auth::check()) {
        return redirect()->route('admin.dashboard');
    } else {
        return view('auth.login');
    }
});

Route::get('/test-s3', function () {
    try {
        $disk = Storage::disk('s3');

        // Test by listing files in the bucket
        $files = $disk->files();

        return response()->json($files);
    } catch (\Exception $e) {
        return response()->json(['error' => $e->getMessage()], 500);
    }
});


Route::middleware('guest')->prefix('auth')->group(function () {
    Route::get('login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('login', [AuthController::class, 'login']);

});
Route::post('logout', [AuthController::class, 'logout'])->name('logout');

Route::middleware(['auth'])->group(function () {
    Route::get('dashboard', [AuthController::class, 'showDashboard'])->name('admin.dashboard');
    // Route::resource('permissions',PermissionController::class);
    // Route::resource('roles', RoleController::class);

    Route::resource('roles', RoleController::class);
    Route::resource('users', UserController::class);
    Route::resource('permissions', PermissionController::class);

    Route::post('/upload-temp',[UserController::class, 'uploadImage'])->name('upload.image');


    Route::get('/book/create',[BookTranslationController::class, 'create'])->name('book.create');
    Route::get('/book/index',[BookTranslationController::class, 'index'])->name('book.index');
    Route::post('/book/store',[BookTranslationController::class, 'store'])->name('book.store');
    Route::post('/book/update/{id}',[BookTranslationController::class, 'update'])->name('book.update');
    Route::post('/book/delete/{id}',[BookTranslationController::class, 'delete'])->name('book.delete');
    Route::get('/book/edit/{id}',[BookTranslationController::class, 'edit'])->name('book.edit');
    Route::get('/book/comment/{id}',[BookTranslationController::class, 'book_comment'])->name('book.comment');
    Route::post('/book/comment/store/{id}',[BookTranslationController::class, 'storeComment'])->name('book.comment.store');
    Route::post('/book/comment/status/update/{id}',[BookTranslationController::class, 'statusUpdate'])->name('book.comment.status.update');
    Route::post('/book/comment/status/audioupdate/{id}',[BookTranslationController::class, 'AudiostatusUpdate'])->name('book.comment.status.audioupdate');




});
