<?php

use App\Http\Controllers\AdminController;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\AdminAuth;


// ─── Guest-only routes (redirect to /Articles if already logged in) ───────────

Route::get("/", function () {
    if (session('admin_id')) return redirect('/Articles');
    return view("Login");
});

Route::get("/new-user", function () {
    if (session('admin_id')) return redirect('/Articles');
    return view("register");
});

Route::post('/register', [AdminController::class, 'register']);
Route::post('/login',    [AdminController::class, 'login']);


// ─── Logout ───────────────────────────────────────────────────────────────────

Route::post('/logout', function () {
    session()->forget('admin_id');
    return redirect('/');
})->name('logout');


// ─── Protected routes (require admin session) ─────────────────────────────────

Route::middleware([AdminAuth::class])->group(function () {

    Route::get('/Articles', [AdminController::class, 'readGroup']);
    Route::get('/Articles/{id}', [AdminController::class, 'readOne'])->whereNumber('id');

    Route::get('/add', function () {
        return view('Add');
    });

    Route::post('/add',            [AdminController::class, 'save']);
    Route::put('/Articles/{id}',   [AdminController::class, 'update']);
    Route::delete('/Articles/{id}', [AdminController::class, 'delete']);

    Route::get('/test', function () {
        return response()->json(['status' => 200]);
    });
});