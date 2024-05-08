<?php

use App\Http\Controllers\MailController;
use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BillingController;

Route::get('/', function () {
    return view('home');
});
Route::get('/contact', function () {
    return view('contact_form');
});

Route::post('/save',[BillingController::class,'save']);
Route::post('/getproductdata',[BillingController::class,'getProductData']);
Route::post('/sendemail',[BillingController::class,'sendEmail']);

Route::get("/products",[ProductController::class,"getProducts"])->name('products');
Route::get("/add",[ProductController::class,"createProduct"]);
Route::post("/storeproduct",[ProductController::class,"storeProduct"]);
Route::get("edit/{id}",[ProductController::class,"edit"]);
Route::post("update/{id}",[ProductController::class,"updateProduct"]);
Route::get("delete/{id}",[ProductController::class,"delete"]);
