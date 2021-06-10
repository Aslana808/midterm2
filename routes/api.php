<?php

use App\Http\Controllers\api\TestController;
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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/register', [TestController::class, 'register']);

Route::post('/login', [TestController::class, 'login']);

Route::post('/fill-balance', [TestController::class, 'fill_balance']);

Route::get('/balance/history',[TestController::class, 'history']);


Route::prefix('/')->middleware('auth:api')->group(function (){
    Route::post('/transfer/', [TestController::class, 'transfer']);
    Route::get('/my-transactions', [TestController::class, 'showBalance']);
    Route::get('/transactions', [TestController::class, 'transactions']);
});


