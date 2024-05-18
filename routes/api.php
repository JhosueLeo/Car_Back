<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CategoriaController;
Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');
Route::get('/categoria/get',[CategoriaController::class,'get']);
Route::get('/categoria/show/{isCategoria}',[CategoriaController::class,'show']);
Route::get('/categoria/create',[CategoriaController::class,'create']);
Route::get('/categoria/update/{idCategoria}',[CategoriaController::class,'update']);
