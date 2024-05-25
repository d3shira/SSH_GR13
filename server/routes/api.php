<?php

use App\Http\Controllers\HomeController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PropertyController;
use App\Http\Controllers\AgentController;
use App\Http\Controllers\CareersController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\ClientsController;






Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('/register', [UserController::class, 'register']);
Route::post('/login', [UserController::class, 'login']);
Route::get('/properties', [PropertyController::class, 'getProperties']);
Route::get('/agents', [AgentController::class, 'getAgents']);
Route::post('/home/properties/filter', [HomeController::class, 'filter']);
Route::post('/careers', [CareersController::class, 'store']);
Route::post('/properties/filter', [PropertyController::class, 'filterProperties']);
Route::post('/contact', [ContactController::class, 'store']);
Route::get('/users', [ClientsController::class, 'index']);
Route::delete('/users/{id}', [ClientsController::class, 'destroy']);
Route::put('/users/{id}', [ClientsController::class, 'update']);





