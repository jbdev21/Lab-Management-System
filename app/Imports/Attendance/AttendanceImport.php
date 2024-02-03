<?php

// AttendanceImport.php

namespace App\Imports\Attendance;

use App\Models\Attendance;
use App\Models\Employee;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class AttendanceImport implements WithMultipleSheets
{
    public function sheets(): array
    {
        return [
            3 => new StatisticReportImport(),
        ];
    }

    // public function model(array $row)
    // {
    //     $employeeCode = (integer)$row['id'];
    //     $date = $row['date'];
    //     $timeIn =  $row['in'];
    //     $timeOut =  $row['out'];


    //     $employee = Employee::where('code', $employeeCode)->first();

    //     if ($employee) {
    //         $attendance = new Attendance([
    //             'employee_id' => $employee->id,
    //             'date' => $date,
    //             'time_in' => $timeIn,
    //             'time_out' => $timeOut,
    //             'time_rendered' => 1, // Assuming you have a default value
    //         ]);
        
    //         // Save the attendance record to the database
    //         $attendance->save();
        
    //         // Calculate and update rendered_time
    //         $attendance->calculateRenderedTime();
        
    //     }

    //     return null; // Skip if any required field is missing or employee not found
    // }


    // protected function calculateTimeRendered($timeIn, $timeOut)
    // {
    //     $timeIn = Carbon::createFromFormat('H:i:s', $timeIn);
    //     $timeOut = Carbon::createFromFormat('H:i:s', $timeOut);

    //     // Calculate the difference in hours
    //     $timeDifference = $timeOut->diffInHours($timeIn);

    //     return $timeDifference;
    // }
}

