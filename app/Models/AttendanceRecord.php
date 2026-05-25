<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AttendenceRecord extends Model
{
    protected $fillable = [
        "employee_id",
        "check_in_time",
        "check_out_time",
        "date",
    ];
}
