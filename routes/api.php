<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ApartmentTypeController;
use App\Http\Controllers\ApartmentController;
use Illuminate\Support\Facades\Route;

Route::post('/register', [AuthController::class, 'register']);
Route::get('/register', [AuthController::class, 'register']);

Route::get('/users', [AuthController::class, 'getUsers']);

Route::post('/login', [AuthController::class, 'login']);

Route::get('/types', [ApartmentTypeController::class, 'index']);

Route::post('/apartments', [ApartmentController::class, 'store']);
