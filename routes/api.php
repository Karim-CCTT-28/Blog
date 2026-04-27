<?php

use App\Http\Controllers\AdminController;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\AdminAuth;




// Route::post("/secret-gate-login", [AdminController::class,"login"]);


// Route::middleware([AdminAuth::class])->group(function () {
//     Route::post("/posts", [AdminController::class, "store"]);
//     Route::put("/posts/{id}", [AdminController::class, "update"]);
//     Route::delete("/posts/{id}", [AdminController::class, "destroy"]);
// });