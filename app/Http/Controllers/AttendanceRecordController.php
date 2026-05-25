<?php

namespace App\Http\Controllers;

use App\Models\AttendanceRecord;
use Illuminate\Http\Request;

class AttendanceRecordController extends Controller
{
    public function index()
    {
        return AttendanceRecord::all();
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'employee_name' => ['required', 'string', 'max:255'],
            'date' => ['required', 'date'],
            'check_in_time' => ['required', 'date_format:H:i'],
            'check_out_time' => ['nullable', 'date_format:H:i'],
        ]);

        $attendance = AttendanceRecord::create($validated);

        return response()->json($attendance, 201);
    }

    public function show(AttendanceRecord $attendance)
    {
        return $attendance;
    }

    public function update(Request $request, AttendanceRecord $attendance)
    {
        $validated = $request->validate([
            'employee_name' => ['required', 'string', 'max:255'],
            'date' => ['required', 'date'],
            'check_in_time' => ['required', 'date_format:H:i'],
            'check_out_time' => ['nullable', 'date_format:H:i'],
        ]);

        $attendance->update($validated);

        return $attendance;
    }

    public function destroy(AttendanceRecord $attendance)
    {
        $attendance->delete();

        return response()->noContent();
    }
}
