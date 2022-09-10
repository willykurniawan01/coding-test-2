<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::namespace("App")->group(function () {
    Route::get("/", "DashboardController@index")->name("dashboard.index");

    //Product Route
    Route::prefix('product')->group(function () {
        Route::get("/", "ProductController@index")->name("product.index");
        Route::get("/create", "ProductController@create")->name("product.create");
        Route::post("/store", "ProductController@store")->name("product.store");
        Route::get("/edit/{id}", "ProductController@edit")->name("product.edit");
        Route::post("/update/{id}", "ProductController@update")->name("product.update");
        Route::post("/save-price/{id}", "ProductController@savePrice")->name("product.save-price");
    });
});
