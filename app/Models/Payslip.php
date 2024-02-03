<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payslip extends Model
{
    use HasFactory;

    protected $fillable = [
        'employee_id',
        'date_from',
        'date_to',
        'due_date',
        'total_working_days',
        'total_report_days',
        'employee_daily_rate',
        'total_salary',
        'total_deductions',
        'net_salary',
    ];

    protected $casts = [
        'date_from' => 'date',
        'date_to' => 'date',
        'due_date' => 'date',
    ];

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }

    public function deductionHistories()
    {
        return $this->hasMany(DeductionHistory::class);
    }
}
