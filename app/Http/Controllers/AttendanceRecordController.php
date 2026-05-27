<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AttendanceRecord as AttendanceRecord;

class AttendanceRecordController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json(AttendanceRecord::all(), 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'employee_name' => 'required|string|max:255|unique:attendance_records,employee_name',
            'check_in_time' => 'required|date_format:H:i:s',
            'check_out_time' => 'nullable|date_format:H:i:s|after:check_in_time',
            'date' => 'required|date_format:Y-m-d',
        ]);

        $newRecord = AttendanceRecord::create($validated);

        return response()->json($newRecord, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(AttendanceRecord $attendance)
    {
        // show the specified attendance report
        return response()->json($attendance, 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, AttendanceRecord $attendance)
    {
        // validate the request data
        $validated = $request->validate([
            'employee_name' => 'required|string|max:255|unique:attendance_records,employee_name,' . $attendance->id,
            'check_in_time' => 'required|date_format:H:i:s',
            'check_out_time' => 'sometimes|nullable|date_format:H:i:s|after:check_in_time',
            'date' => 'required|date_format:Y-m-d',
        ]);

        $attendance->update($validated);

        return response()->noContent();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(AttendanceRecord $attendance)
    {
        $attendance->delete();

        return response()->noContent();
    }
}
