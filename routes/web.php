<?php

use App\Http\Controllers\AdminController;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\AdminAuth;






Route::get("/", function(){
 return view("Article");
});


Route::post("/login", [AdminController::class,"login"]);

Route::get("/Articles", [AdminController::class,"readGroup"]);

Route::middleware([AdminAuth::class])->group(function () {

Route::get("/test", function(){
    return response()->json(["staus" => 200]);
});
    Route::post("/Articles", [AdminController::class, "save"]);
    Route::put("/Articles/{id}", [AdminController::class, "update"]);
    Route::delete("/Articles/{id}", [AdminController::class, "delete"]);
});