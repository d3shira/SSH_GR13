<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PropertyController;
use App\Http\Controllers\AgentController;
use App\Http\Controllers\UserController;



Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::get('/properties', [PropertyController::class, 'getProperties']);
Route::get('/agents', [AgentController::class, 'getAgents']);

Route::post('/register', [UserController::class, 'register']);




