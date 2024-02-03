<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Deduction extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function employees()
    {
        return $this->belongsToMany(Employee::class, 'deduction_employee')
            ->withPivot('amount', 'note')
            ->withTimestamps();
    }

    public function deductionHistories()
    {
        return $this->hasMany(DeductionHistory::class);
    }
}
