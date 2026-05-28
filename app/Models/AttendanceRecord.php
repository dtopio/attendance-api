<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Database\Factories\AttendanceRecordFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class AttendanceRecord extends Model
{
    /** @use HasFactory<AttendanceRecordFactory> */
    use HasFactory;

    protected $fillable = [
        "employee_name",
        "check_in_time",
        "check_out_time",
        "date",
    ];
}
