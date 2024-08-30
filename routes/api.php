<?php

use App\Http\Controllers\ArticleController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BranchController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\DoctorController;
use App\Http\Controllers\MedicalDeviceController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\NavItemsController;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\UserController;
use App\Models\Reservation;
use Illuminate\Support\Facades\Route;

// ****************** Public Routes ****************** \\
Route::post('login', [AuthController::class, 'login']);
Route::post('register', [AuthController::class, 'register']);
Route::get('nav-items', [NavItemsController::class, 'index']);
Route::apiResource('users', UserController::class);
Route::apiResource('messages', MessageController::class)->only('store');
Route::apiResource('reservations', ReservationController::class)->only(['store']);
Route::post('reservation-doctors', [ReservationController::class, 'get_reservation_doctors']);
Route::apiResource('branches', BranchController::class)->only('index');
Route::apiResource('departments', DepartmentController::class)->only('index');
// ****************** Authenticated Routes ****************** \\
Route::group(['middleware' => 'auth:sanctum'], function () {
    Route::apiResource('messages', MessageController::class)->except('store');
    Route::get('auth-user', [UserController::class, 'show_auth_user']);
    Route::get('user-roles', [UserController::class, 'get_user_roles']);
    Route::get('logout', [AuthController::class, 'logout']);
    Route::apiResource('branches', BranchController::class)->except('index');
    Route::apiResource('departments', DepartmentController::class)->except('index');
    Route::apiResource('doctors', DoctorController::class);
    Route::apiResource('reservations', ReservationController::class)->except(['store']);
    Route::get('today-reservations', [ReservationController::class, 'today_reservations']);
    Route::get('doctor-reservations', [ReservationController::class, 'doctor_reservations']);
    Route::apiResource('medical-devices', MedicalDeviceController::class);
    Route::apiResource('articles', ArticleController::class);
});
