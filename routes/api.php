<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::namespace("Api")->group(function () {

    //Product Route
    Route::prefix('product')->group(function () {
        Route::get("/", "ProductController@index")->name("product.api.index");
        Route::post("/search", "ProductController@search")->name("product.api.search");
        Route::post("/", "ProductController@store")->name("product.api.store");
        Route::delete("/delete/{id}", "ProductController@delete")->name("product.api.delete");
        Route::post("/update/{id}", "ProductController@update")->name("product.api.update");
        Route::get("/price/{id}", "ProductController@getPrice")->name("product.api.price");
        Route::get("/size/{id}", "ProductController@getsize")->name("product.api.size");
        Route::get("/{id}", "ProductController@show")->name("product.api.show");
    });
});
