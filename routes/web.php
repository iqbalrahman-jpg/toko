<?php

use Illuminate\Support\Facades\Route;

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
