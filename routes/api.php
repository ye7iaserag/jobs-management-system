<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use JMS\Job\Infrastructure\Http\Controllers\CreateJobController;
use JMS\Job\Infrastructure\Http\Controllers\DeleteJobController;
use JMS\Job\Infrastructure\Http\Controllers\GetJobByIdController;
use JMS\Job\Infrastructure\Http\Controllers\ListJobsController;
use JMS\Job\Infrastructure\Http\Controllers\UpdateJobController;
use JMS\Auth\Infrastructure\Http\Controllers\LoginController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/



Route::prefix('users')->group(function() {

    Route::post('actions/login', LoginController::class);

});

Route::prefix('jobs')->middleware('jwt.auth')->group(function() {

    Route::post('/', CreateJobController::class);

    Route::get('/{id}', GetJobByIdController::class);

    Route::patch('/{id}', UpdateJobController::class);

    Route::delete('/{id}', DeleteJobController::class);

    Route::get('/', ListJobsController::class);

});
