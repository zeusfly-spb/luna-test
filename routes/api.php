<?php

use App\Http\Controllers\ActionController;
use App\Http\Controllers\BuildingController;
use App\Http\Controllers\OrgController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/orgs', [OrgController::class, 'index']);

Route::get('/buildings', [BuildingController::class, 'index']);
Route::get('/buildings/orgs/{id}', [BuildingController::class, 'orgs']);
Route::post('/buildings/nearby', [BuildingController::class, 'nearbyBuildings']);
Route::post('/buildings/nearby/orgs', [BuildingController::class, 'nearbyOrgs']);

Route::get('/actions', [ActionController::class, 'index']);
Route::get('/actions/orgs/{id}', [ActionController::class, 'orgs']);
