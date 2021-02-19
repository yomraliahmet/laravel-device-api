<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MockApiController;

Route::post("android",[MockApiController::class, "android"]);
Route::post("ios",[MockApiController::class, "ios"]);
