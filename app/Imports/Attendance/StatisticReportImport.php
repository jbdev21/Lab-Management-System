<?php

namespace App\Imports\Attendance;

use App\Models\Attendance;
use App\Models\Employee;
use Carbon\Carbon;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class StatisticReportImport implements ToCollection, WithHeadingRow
{

    public function headingRow(): int
    {
        return 5;
    }

    public function collection(Collection $rows)
    {
        foreach ($rows as $row) {
            $data = Arr::flatten($row->toArray());
            $employeeCode = (integer)$data[0];
            $date = $data[3];
            $timeIn = $data[4] ?? null; // Use null as default when timeIn is not provided
            $timeOut = $data[7] ?? '00:00';

            $employee = Employee::where('code', $employeeCode)->first();

            if ($employee && $timeIn !== null) {
                // Check if attendance already exists for the given date and employee
                $existingAttendance = Attendance::where('employee_id', $employee->id)
                    ->where('date', $date)
                    ->first();

                if (!$existingAttendance) {
                    $attendance = new Attendance([
                        'employee_id' => $employee->id,
                        'date' => $date,
                        'time_in' => $timeIn,
                        'time_out' => $timeOut,
                        'time_rendered' => 1, // Assuming you have a default value
                    ]);

                    // Save the attendance record to the database
                    $attendance->save();

                    // Calculate and update rendered_time
                    $attendance->calculateRenderedTime();
                }
            }
        }

        return null; // Skip if any required field is missing or employee not found
    }



    protected function calculateTimeRendered($timeIn, $timeOut)
    {
        $timeIn = Carbon::createFromFormat('H:i:s', $timeIn);
        $timeOut = Carbon::createFromFormat('H:i:s', $timeOut);

        // Calculate the difference in hours
        $timeDifference = $timeOut->diffInHours($timeIn);

        return $timeDifference;
    }
}
