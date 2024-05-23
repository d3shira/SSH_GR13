<?php

use App\Http\Controllers\HomeController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PropertyController;
use App\Http\Controllers\CareersController;
use App\Http\Controllers\AgentController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ContactController;




Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::get('/properties', [PropertyController::class, 'getProperties']);
Route::post('/home/properties/filter', [HomeController::class, 'filter']);
Route::post('/careers', [CareersController::class, 'store']);
Route::get('/agents', [AgentController::class, 'getAgents']);
Route::post('/register', [UserController::class, 'register']);
Route::post('/contact', [ContactController::class, 'store']);





