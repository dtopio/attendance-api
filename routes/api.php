<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AttendanceRecordController;

Route::middleware(['throttle:api'])->group(function () {
    Route::apiResource('attendance', AttendanceRecordController::class);
});
