<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\TaskController;
use App\Http\Controllers\Api\JobRoleController;
use App\Http\Controllers\Api\UserJobRoleController;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/



Route::middleware('auth:sanctum')->apiResource('v1/users', UserController::class);

Route::middleware('auth:sanctum')->apiResource('v1/tasks', TaskController::class);

Route::middleware('auth:sanctum')->apiResource('v1/job_roles', JobRoleController::class);

Route::middleware('auth:sanctum')->apiResource('v1/user_job_roles', UserJobRoleController::class);