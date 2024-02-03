<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function attendances()
    {
        return $this->hasMany(Attendance::class);
    }

    public function deductions()
    {
        return $this->belongsToMany(Deduction::class, 'deduction_employee')
            ->withPivot(['amount', 'note'])
            ->withTimestamps();
    }

    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    public function deductionHistories()
    {
        return $this->hasMany(DeductionHistory::class);
    }

    public function payslips()
    {
        return $this->hasMany(Payslip::class);
    }

    public function getFullNameAttribute()
    {
        return $this->last_name. ', '.$this->first_name;
    }

    public function leaves()
    {
        return $this->hasMany(Leave::class);
    }

}
