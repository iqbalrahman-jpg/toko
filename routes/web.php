<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\StokController;
use App\Http\Controllers\BarangController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\PreviewController;
use Illuminate\Support\Facades\Route;

// Authentication Routes...
Route::get("login", [LoginController::class, "showLoginForm"])->name("login");
Route::post("login", [LoginController::class, "login"]);
Route::post("logout", [LoginController::class, "logout"])->name("logout");

// Registration Routes...
Route::get("register", [
    RegisterController::class,
    "showRegistrationForm",
])->name("register");
Route::post("register", [RegisterController::class, "register"]);

// Protected Routes (Requires Authentication)
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

    // stok
    Route::get("/stok", [StokController::class, "index"])->name("stok.index");
    Route::post("/stok", [StokController::class, "store"])->name("stok.store");
    Route::put("/stok/{stok}", [StokController::class, "update"])->name(
        "stok.update"
    );
    Route::delete("/stok/{stok}", [StokController::class, "destroy"])->name(
        "stok.destroy"
    );
    Route::put("/stok/{stok}/toggle-status", [
        StokController::class,
        "toggleStatus",
    ])->name("stok.toggleStatus");

    // barang
    Route::get("/barang", [BarangController::class, "index"])->name(
        "barang.index"
    );
    Route::post("/barang", [BarangController::class, "store"])->name(
        "barang.store"
    );
    Route::put("/barang/{barang}", [BarangController::class, "update"])->name(
        "barang.update"
    );
    Route::delete("/barang/{barang}", [
        BarangController::class,
        "destroy",
    ])->name("barang.destroy");
    Route::put("/barang/{barang}/toggle-status", [
        BarangController::class,
        "toggleStatus",
    ])->name("barang.toggleStatus");

    // kategori
    Route::get("/kategori", [CategoryController::class, "index"])->name(
        "kategori.index"
    );
    Route::post("/kategori", [CategoryController::class, "store"])->name(
        "kategori.store"
    );
    Route::put("/kategori/{category}", [
        CategoryController::class,
        "update",
    ])->name("kategori.update");
    Route::delete("/kategori/{category}", [
        CategoryController::class,
        "destroy",
    ])->name("kategori.destroy");
    Route::put("/kategori/{category}/toggle-status", [
        CategoryController::class,
        "toggleStatus",
    ])->name("kategori.toggleStatus");

    Route::get("/preview", [
        App\Http\Controllers\PreviewController::class,
        "show",
    ])->name("preview.show");
});
