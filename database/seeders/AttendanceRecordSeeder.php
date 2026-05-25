<?php

namespace Database\Seeders;

use App\Models\AttendanceRecord;
use Illuminate\Database\Seeder;

class AttendanceRecordSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $records = [
            [
                'employee_name' => 'Ada Lovelace',
                'date' => '2026-05-22',
                'check_in_time' => '08:55',
                'check_out_time' => '17:30',
            ],
            [
                'employee_name' => 'Grace Hopper',
                'date' => '2026-05-22',
                'check_in_time' => '09:10',
                'check_out_time' => '18:00',
            ],
            [
                'employee_name' => 'Katherine Johnson',
                'date' => '2026-05-23',
                'check_in_time' => '08:45',
                'check_out_time' => '17:15',
            ],
            [
                'employee_name' => 'Alan Turing',
                'date' => '2026-05-25',
                'check_in_time' => '09:00',
                'check_out_time' => null,
            ],
        ];

        foreach ($records as $record) {
            AttendanceRecord::updateOrCreate(
                [
                    'employee_name' => $record['employee_name'],
                    'date' => $record['date'],
                ],
                $record,
            );
        }
    }
}
