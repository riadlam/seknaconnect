<?php

use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\ProjectController;
use App\Http\Controllers\API\ProjectImageController;
use App\Http\Controllers\API\InquiryController;
use App\Http\Controllers\API\ProjectFilterController;
use App\Http\Controllers\API\LocationController;
use Illuminate\Support\Facades\Route;

// Public Routes
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login',    [AuthController::class, 'login']);

Route::get('/projects', [ProjectController::class, 'index']);
Route::get('/projects/search', [ProjectController::class, 'searchByName']);
Route::get('/projects/filter', [ProjectFilterController::class, 'filter']);
Route::get('/projects/{id}', [ProjectController::class, 'show']);
Route::post('/projects/{id}/inquiries', [InquiryController::class, 'store']);

// Location routes
Route::get('/locations/wilayas', [LocationController::class, 'getWilayas']);
Route::get('/locations/baladias/{wilaya}', [LocationController::class, 'getBaladias']);
Route::get('/locations/dairas/{wilaya}/{baladia}', [LocationController::class, 'getDairas']);

// Authenticated Routes
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/user', [AuthController::class, 'user']);
    Route::post('/logout', [AuthController::class, 'logout']);
    
    // Get authenticated user's projects
    Route::get('/user/projects', [ProjectController::class, 'userProjects']);

    // Professional-only routes
    Route::post('/projects', [ProjectController::class, 'store']);
    Route::put('/projects/{id}', [ProjectController::class, 'update']);
    Route::delete('/projects/{id}', [ProjectController::class, 'destroy']);

    Route::post('/projects/{id}/images', [ProjectImageController::class, 'store']);
    Route::delete('/project-images/{id}', [ProjectImageController::class, 'destroy']);

    Route::get('/professional/inquiries', [InquiryController::class, 'index']);
    
    // Admin routes
    Route::get('/admin/users', [AuthController::class, 'getUsers']);
    Route::delete('/admin/users/{id}', [AuthController::class, 'deleteUser']);
    Route::post('/admin/users/{id}/verify', [AuthController::class, 'verifyUser']);
});
