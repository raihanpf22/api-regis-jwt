<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\BukuController;

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
Route::post('register', [UserController::class, 'register']);
Route::post('login', [UserController::class, 'login']);
Route::post('logout', [UserController::class, 'logout']);
Route::get('bukuall', [BukuController::class, 'bukuAuth'])->middleware('jwt.verify');
Route::get('user', [BukuController::class, 'getAuthenticatedUser'])->middleware('jwt.verify');

Route::get('buku', [BukuController::class, 'index'])->middleware('jwt.verify');
Route::post('buku', [BukuController::class, 'simpan_buku'])->middleware('jwt.verify');
Route::get('buku/{kode_buku}', [BukuController::class, 'tampil'])->middleware('jwt.verify');