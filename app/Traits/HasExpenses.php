<?php

namespace App\Traits;

use App\Models\Expense;

trait HasExpenses{

    public function expenses(){
        return $this->morphMany(Expense::class, 'expensable');
    }

}