<?php

use App\Http\Controllers\AuthController;
use App\Models\Siswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SiswaController;
use App\Http\Controllers\TodoController;

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


// Public Route
Route::get('/todo', [TodoController::class, 'index']);
Route::get('/todo/{id}', [TodoController::class, 'show']);
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
// Protected routes
Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::post('/todo', [TodoController::class, 'store']);
    Route::put('/todo/{id}', [TodoController::class, 'update']);
    Route::delete('/todo/{id}', [TodoController::class, 'destroy']);
    Route::post('/todo/date', [TodoController::class, 'date']);
    Route::post('/todo/merge', [TodoController::class, 'merge']);
    Route::post('/todo/deleteall', [TodoController::class, 'destroyAll']);
    Route::post('/todo/sync', [TodoController::class, 'sync']);
    Route::post('/logout', [AuthController::class, 'logout']);
});

Route::get('/siswa', [SiswaController::class, 'index']);
Route::post('/siswa', [SiswaController::class, 'create']);
Route::put('/siswa/{id}', [SiswaController::class, 'update']);
Route::delete('/siswa/{id}', [SiswaController::class, 'delete']);
