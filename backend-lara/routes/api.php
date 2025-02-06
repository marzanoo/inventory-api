<?php

use App\Http\Controllers\MerekController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/merek', [MerekController::class, 'index']);
Route::post('/merek', [MerekController::class, 'store']);
Route::get('/merek/{id}', [MerekController::class, 'show']);
Route::put('/merek/{id}', [MerekController::class, 'update']);
Route::delete('/merek/{id}', [MerekController::class, 'destroy']);
