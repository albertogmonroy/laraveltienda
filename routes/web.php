<?php

use App\Http\Controllers\ProductosController;
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

Route::get('/', function () {
    return view('welcome');
});

//Rutas de mi CRUD productos
Route::get('/obtener/productos', [ProductosController::class, 'obtenerProductos'])->name('obtener.productos');
Route::post('/guardar/productos', [ProductosController::class, 'guardarProducto'])->name('guardar.productos');
Route::get('/obtener/productos/{id}', [ProductosController::class, 'obtenerProducto'])->name('obtener.productos');
Route::put('/actualizar/productos/{id}', [ProductosController::class, 'actualizarProducto'])->name('actualizar.productos');
Route::delete('/eliminar/productos/{id}', [ProductosController::class, 'eliminarProducto'])->name('eliminar.productos');

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

