<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

//Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
   // return $request->user();
//});

Route::prefix('personas')->group(function(){

    Route::put('/crear',[PersonasController::class,'crear']);
    Route::delete('/desactivar/{id}',[PersonasController::class,'borrar']);
    Route::post('/editar/{id}',[PersonasController::class,'editar']);
    Route::get('/listar',[PersonasController::class,'listar']);
    Route::get('/ver/{id}',[PersonasController::class,'ver']);
    
});
