<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;

Route::get("/login", [LoginController::class, "showLoginForm"])->name("login");
Route::post("/login", [LoginController::class, "login"]);
Route::post("/logout", [LoginController::class, "logout"])->name("logout");

Route::get("register", [
    RegisterController::class,
    "showRegistrationForm",
])->name("register");
Route::post("register", [RegisterController::class, "register"]);

Route::middleware(["auth"])->group(function () {
    Route::get("/", function () {
        return view("pages.home");
    })->name("home");

    Route::get("/keuangan", function () {
        return view("pages.keuangan");
    })->name("keuangan");

    Route::get("/penjualan", function () {
        return view("pages.penjualan");
    })->name("penjualan");

    Route::get("/stok", function () {
        return view("pages.stok");
    })->name("stok");

    Route::get("/barang", function () {
        return view("pages.barang");
    })->name("barang");

    Route::get("/kategori", function () {
        return view("pages.kategori");
    })->name("kategori");
});
