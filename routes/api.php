<?php

use App\Http\Controllers\Api\ApiController;
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

Route::prefix('v1')->group(function () {
    Route::get('/categories', [ApiController::class, 'categories'])->name('api.categories');
    Route::get('/category/{id}', [ApiController::class, 'types'])->name('api.product');
    Route::post('/buy', [ApiController::class, 'buy'])->name('api.buy');
    Route::post('/orders', [ApiController::class, 'orders'])->name('api.list_order');
    Route::post('/order', [ApiController::class, 'detail_order'])->name('api.detail_order');
    Route::post('/balance', [ApiController::class, 'balance'])->name('api.balance');
    Route::post('/import', [ApiController::class, 'import'])->name('api.import');
});
