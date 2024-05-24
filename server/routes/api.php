<?php

use App\Http\Controllers\AddPropertyController;
use App\Http\Controllers\HomeController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PropertyController;
use App\Http\Controllers\AgentController;
use App\Http\Controllers\CareersController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ContactController;



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
//staff:
Route::get('/careers', [CareersController::class, 'getJobApplications']);
Route::put('/careers/{id}/approve', [CareersController::class, 'approveApplication']); // Route for approving application
Route::put('/careers/{id}/reject', [CareersController::class, 'rejectApplication']); // Route for rejecting application
Route::put('/careers/{id}/undo', [CareersController::class, 'undoApplicationStatus']);
Route::get('/property_types', [AddPropertyController::class, 'getPropertyTypes']);
Route::post('/add_properties', [AddPropertyController::class, 'store']);



