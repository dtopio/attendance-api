<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AttendanceRecord extends Model
{
    protected $fillable = [
        "employee_name",
        "check_in_time",
        "check_out_time",
        "date",
    ];
}
