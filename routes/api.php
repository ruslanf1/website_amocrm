<?php

use App\Http\Controllers\SiteController;
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

Route::get('exchange', [SiteController::class, 'exchange']);
Route::post('status', [SiteController::class, 'updateStatus'])->middleware('status.log');
Route::get('index/{lead:lead_id}', [SiteController::class, 'getStatus']);
Route::post('lead', [SiteController::class, 'lead']);
