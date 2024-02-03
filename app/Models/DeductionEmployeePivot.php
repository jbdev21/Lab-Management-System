<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class DeductionEmployeePivot extends Pivot
{
    protected $table = 'deduction_employee';

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }

    public function deduction()
    {
        return $this->belongsTo(Deduction::class);
    }
}

