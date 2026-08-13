<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AttendanceController;

Route::get('/', [AttendanceController::class, 'index']);
Route::get('/admin', [AttendanceController::class, 'admin']);
Route::post('/absen', [AttendanceController::class, 'store']);
