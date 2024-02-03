<?php

namespace App\Observers;

use App\Models\Leave;

class LeaveObserver
{
    public function created(Leave $leave)
    {
        $employee = $leave->employee;

        if ($employee && $leave->is_paid) {
            $employee->paid_leave -= $leave->no_days;
            $employee->save();
        }
    }

    public function updating(Leave $leave)
    {
        $leave->original_no_days = $leave->getOriginal('no_days');
    }

    public function updated(Leave $leave)
    {
        if ($leave->isDirty('no_days') && $leave->no_days) {
            $this->updatePaidLeave($leave);
        }
    }

    public function deleting(Leave $leave)
    {
        $employee = $leave->employee;

        $employee->paid_leave += $leave->no_days; // Corrected the operator here
        $employee->save();
    }

    private function updatePaidLeave(Leave $leave)
    {
        $employee = $leave->employee;

        if ($employee && $leave->is_paid) {
    
            if (isset($leave->original_no_days) && $leave->original_no_days > $leave->no_days) {
                $employee->paid_leave += ($leave->original_no_days - $leave->no_days);
            } else {
                $employee->paid_leave -= ($leave->no_days - ($leave->original_no_days ?? 0));
            }
    
            $employee->save();
        }
    }
}
