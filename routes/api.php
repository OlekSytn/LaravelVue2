<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProdutoController;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('produtos',[ProdutoController::class,'store'])->name('apiProdutoStore');
Route::post('produtos/{id}',[ProdutoController::class,'update'])->name('apiProdutoUpdate');
Route::get('produtos',[ProdutoController::class,'index'])->name('apiProdutoIndex');