<?php

use App\Http\Controllers\OrgController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

//Route::get('/user', function (Request $request) {
//    return $request->user();
//})->middleware('auth:sanctum');

Route::get('/org/index', [OrgController::class, 'index']);
