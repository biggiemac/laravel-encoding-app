<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\JobController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group that
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Job submission and status check routes
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/jobs', [JobController::class, 'submitJob']); // Submit a new job
    Route::get('/jobs/{job_id}', [JobController::class, 'checkJobStatus']); // Check job status
});

// Public test route (optional)
Route::get('/test', function () {
    return response()->json(['message' => 'API is working']);
});