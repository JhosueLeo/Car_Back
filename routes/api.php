<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CategoriaController;
use App\Http\Controllers\ProductoController;
use App\Http\Controllers\InventarioController;
use App\Http\Controllers\ServicioController;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\EmpleadoController;
use App\Http\Controllers\AuthController;
Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');
//Categoria
Route::group(['prefix' => 'categoria'], function () {
    Route::get('/get',[CategoriaController::class,'get']);
    Route::get('/show/{idCategoria}',[CategoriaController::class,'show']);
    Route::post('/create',[CategoriaController::class,'create']);
    Route::post('/update/{idCategoria}',[CategoriaController::class,'update']);
    Route::post('/delete/{idCategoria}',[CategoriaController::class,'delete']);
});
Route::post('login', [AuthController::class, 'authenticate']);

//Producto
Route::group(['prefix' => 'producto'], function () {
    Route::get('/get',[ProductoController::class,'get']);
    Route::get('/show/{idProducto}',[ProductoController::class,'show']);
    Route::post('/create',[ProductoController::class,'create']);
    Route::post('/update/{idProducto}',[ProductoController::class,'update']);
    Route::post('/delete/{idProducto}',[ProductoController::class,'delete']);
});
//Inventario
Route::group(['prefix' => 'inventario'], function () {
    Route::get('/get',[InventarioController::class,'get']);
    Route::get('/show/{idInventario}',[InventarioController::class,'show']);
    Route::post('/create',[InventarioController::class,'create']);
    Route::post('/update/{idInventario}',[InventarioController::class,'update']);
    Route::post('/delete/{idInventario}',[InventarioController::class,'delete']);
});
//Servicio
Route::group(['prefix' => 'servicio'], function () {
    Route::get('/get',[ServicioController::class,'get']);
    Route::get('/show/{idInventario}',[ServicioController::class,'show']);
    Route::post('/create',[ServicioController::class,'create']);
    Route::post('/update/{idInventario}',[ServicioController::class,'update']);
    Route::post('/delete/{idInventario}',[ServicioController::class,'delete']);
});
//Cliente
Route::group(['prefix' => 'cliente'], function () {
    Route::get('/get',[ClienteController::class,'get']);
    Route::get('/show/{idCliente}',[ClienteController::class,'show']);
    Route::post('/create',[ClienteController::class,'create']);
    Route::post('/update/{idCliente}',[ClienteController::class,'update']);
    Route::post('/delete/{idCliente}',[ClienteController::class,'delete']);
});
//Empleado
Route::group(['prefix' => 'empleado'], function () {
    Route::get('/get',[EmpleadoController::class,'get']);
    Route::get('/show/{idCliente}',[EmpleadoController::class,'show']);
    Route::post('/create',[EmpleadoController::class,'create']);
    Route::post('/update/{idCliente}',[EmpleadoController::class,'update']);
    Route::post('/delete/{idCliente}',[EmpleadoController::class,'delete']);
    Route::post('/asignar_rol/{idCliente}',[EmpleadoController::class,'asignarRol']);
});