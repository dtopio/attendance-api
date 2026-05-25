<?php

use App\Http\Controllers\AttendanceRecordController;
use Illuminate\Support\Facades\Route;

Route::apiResource('attendance', AttendanceRecordController::class);
