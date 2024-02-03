<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $casts = [
        'date' => 'date',
        'time_in' => 'datetime:HH:MM',
        'time_out' => 'datetime:HH:MM',
    ];

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }

    public function calculateRenderedTime()
    {
        if ($this->time_in && $this->time_out) {
            $timeIn = Carbon::parse($this->time_in);
            $timeOut = Carbon::parse($this->time_out);

            $totalHoursPerDay = 9;

            $minutesDifference = $timeOut->diffInMinutes($timeIn);

            $renderedTime = number_format($minutesDifference / 60, 2);

            $this->update(['time_rendered' => $renderedTime]);

            $diffInHours = $minutesDifference / 60;

            if ($diffInHours < $totalHoursPerDay) {
                $underTime = $totalHoursPerDay - $diffInHours;
                $this->update(['under_time' => number_format($underTime, 2)]);
                $this->update(['over_time' => 0]);
            } else {
                $overTime = $diffInHours - $totalHoursPerDay;
                $this->update(['over_time' => number_format($overTime, 2)]);
                $this->update(['under_time' => 0]);
            }
        }
    }
}
