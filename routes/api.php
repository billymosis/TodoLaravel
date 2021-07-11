<?php

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('siswa',[SiswaController::class, 'index']);
Route::post('siswa',[SiswaController::class, 'create']);
Route::put('/siswa/{id}',[SiswaController::class, 'update']);
Route::delete('/siswa/{id}',[SiswaController::class, 'delete']);

Route::get('todo',[TodoController::class, 'index']);
Route::get('/todo/{id}',[TodoController::class, 'show']);
Route::post('todo',[TodoController::class, 'store']);
Route::put('/todo/{id}',[TodoController::class, 'update']);
Route::delete('/todo/{id}',[TodoController::class, 'destroy']);
