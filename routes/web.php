<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\App;

// API Routes
Route::prefix('api')->group(function () {
    // Your API routes will go here
    // Example: Route::get('/projects', 'ProjectController@index');
});

// Catch-all route for SPA
Route::get('/{any?}', function () {
    return view('welcome'); // Using welcome.blade.php as the main entry point
})->where('any', '.*');
