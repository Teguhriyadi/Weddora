<?php

use App\Http\Controllers\AppController;
use App\Http\Controllers\Authentication\LoginController;
use App\Http\Controllers\Master\RoleController;
use Illuminate\Support\Facades\Route;

Route::middleware(["web", "guest"])->group(function () {
    Route::prefix("login")->group(function () {
        Route::get("/", [LoginController::class, "login"]);
        Route::post("/", [LoginController::class, "post_login"]);
    });
});

Route::middleware(["web", "autentikasi"])->group(function () {
    Route::prefix("modules")->group(function () {
        Route::get("/dashboard", [AppController::class, "dashboard"]);

        Route::resource("role", RoleController::class);
    });

    Route::get("/logout", [LoginController::class, "logout"]);
});
