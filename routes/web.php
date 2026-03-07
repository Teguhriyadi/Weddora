<?php

use App\Http\Controllers\AppController;
use App\Http\Controllers\Authentication\LoginController;
use App\Http\Controllers\InputManual\InputAttendanceController;
use App\Http\Controllers\Master\GuestController;
use App\Http\Controllers\Master\KategoriController;
use App\Http\Controllers\Master\RoleController;
use App\Http\Controllers\Master\UserController;
use App\Http\Controllers\QRCode\ScanQRGuestController;
use App\Http\Controllers\Report\HistoryGuestController;
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
        Route::resource("users", UserController::class);

        Route::get("/kategori/{id}/change-status", [KategoriController::class, "change_status"]);
        Route::resource("kategori", KategoriController::class);

        Route::get("/guest/download", [GuestController::class, "download"]);
        Route::resource("guest", GuestController::class);

        Route::resource("scan-qr-guest", ScanQRGuestController::class);

        Route::prefix("history-guest")->group(function() {
            Route::get("/", [HistoryGuestController::class, "index"]);
        });

        Route::resource("input-attendance", InputAttendanceController::class);
    });

    Route::get("/logout", [LoginController::class, "logout"]);
});
