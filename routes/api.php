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

Route::prefix('v1')->group(function (){
    Route::get('/invoice', [\App\Http\Controllers\Api\v1\InvoicesController::class, 'index']);
    Route::get('/invoice/statuses', [\App\Http\Controllers\Api\v1\InvoicesController::class, 'invoicesStatuses']);
    Route::get('/location', [\App\Http\Controllers\Api\v1\LocationsController::class, 'index']);
});
