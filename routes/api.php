<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AttendanceRecordController;

Route::apiResource('attendance', AttendanceRecordController::class);