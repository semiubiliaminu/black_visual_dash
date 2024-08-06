<?php

use App\Http\Controllers\NewsController;
use App\Models\News;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::resource('/news', NewsController::class);

Route::get('/dashboard', [NewsController::class, 'display']);
Route::get('/dashboard', [NewsController::class, 'insight']);

Route::post('/filter', [NewsController::class,'filter']);
Route::get('/chart', [NewsController::class,'loadData']);
Route::get('/insight', [NewsController::class,'insight']);