<?php

use App\Http\Controllers\ProductController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
   return $request->user();
});

Route::get('/get_all_product',[ProductController::class,'index']);
Route::post('/add_product',[ProductController::class, 'store']);
Route::get('/get_edit_product/{id}',[ProductController::class, 'edit']);
Route::post('/update_product/{id}',[ProductController::class,'update']);
Route::get('/delete_product/{id}',[ProductController::class, 'destroy']);