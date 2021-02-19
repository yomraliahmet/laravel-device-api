<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DeviceController;

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

Route::post("register",[DeviceController::class, "register"]);

Route::group(["middleware" => "auth:sanctum"], function(){
    Route::post("purchase",[DeviceController::class, "purchase"]);
    Route::post("check-subscription",[DeviceController::class, "checkSubscription"]);
});
