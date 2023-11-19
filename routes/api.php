<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use app\Http\Controllers\ProductoController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

//crud usuario
Route::post('register', [AuthController::class, "register"]);
Route::post('login', [AuthController::class, "login"]);
Route::post('updateData', [UserController::class, "updateData"]);
Route::post('deleteUser/{id}', [UserController::class, "deleteUser"]);
Route::get('user', [UserController::class, "showAll"]);




//crud producto

Route::post('crearProducto', [ProductoController::class, "crearProducto"]);
Route::get('producto/{id}', [ProductoController::class, "showId"]);
Route::get('productoNombre/{name}', [ProductoController::class, "findName"]);
Route::post('actualizarProducto', [ProductoController::class, "updateData"]);
Route::post('deleteProcusto/{id}', [ProductoController::class, "crearProducto"]);


Route::middleware('auth:sanctum')->group( function() {
    Route::get('logout', [AuthController::class, "logout"]);
});
