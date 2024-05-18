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
Route::post('login', [AuthController::class, 'authenticate']);
Route::get('/categoria/get',[CategoriaController::class,'get']);
Route::get('/categoria/show/{idCategoria}',[CategoriaController::class,'show']);
Route::post('/categoria/create',[CategoriaController::class,'create']);
Route::post('/categoria/update/{idCategoria}',[CategoriaController::class,'update']);
Route::post('/categoria/delete/{idCategoria}',[CategoriaController::class,'delete']);
//Producto
Route::get('/producto/get',[ProductoController::class,'get']);
Route::get('/producto/show/{idProducto}',[ProductoController::class,'show']);
Route::post('/producto/create',[ProductoController::class,'create']);
Route::post('/producto/update/{idProducto}',[ProductoController::class,'update']);
Route::post('/producto/delete/{idProducto}',[ProductoController::class,'delete']);
//Inventario
Route::get('/inventario/get',[InventarioController::class,'get']);
Route::get('/inventario/show/{idInventario}',[InventarioController::class,'show']);
Route::post('/inventario/create',[InventarioController::class,'create']);
Route::post('/inventario/update/{idInventario}',[InventarioController::class,'update']);
Route::post('/inventario/delete/{idInventario}',[InventarioController::class,'delete']);
//Servicio
Route::get('/servicio/get',[ServicioController::class,'get']);
Route::get('/servicio/show/{idInventario}',[ServicioController::class,'show']);
Route::post('/servicio/create',[ServicioController::class,'create']);
Route::post('/servicio/update/{idInventario}',[ServicioController::class,'update']);
Route::post('/servicio/delete/{idInventario}',[ServicioController::class,'delete']);
//Cliente
Route::get('/cliente/get',[ClienteController::class,'get']);
Route::get('/cliente/show/{idCliente}',[ClienteController::class,'show']);
Route::post('/cliente/create',[ClienteController::class,'create']);
Route::post('/cliente/update/{idCliente}',[ClienteController::class,'update']);
Route::post('/cliente/delete/{idCliente}',[ClienteController::class,'delete']);
//Empleado
Route::get('/empleado/get',[EmpleadoController::class,'get']);
Route::get('/empleado/show/{idCliente}',[EmpleadoController::class,'show']);
Route::post('/empleado/create',[EmpleadoController::class,'create']);
Route::post('/empleado/update/{idCliente}',[EmpleadoController::class,'update']);
Route::post('/empleado/delete/{idCliente}',[EmpleadoController::class,'delete']);
Route::post('/empleado/asignar_rol/{idCliente}',[EmpleadoController::class,'asignarRol']);