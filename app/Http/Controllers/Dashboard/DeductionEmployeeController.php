<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Deduction;
use App\Models\DeductionEmployeePivot;
use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class DeductionEmployeeController extends Controller
{
    public function index()
    {
        $lists = Employee::with('deductions')->paginate();
        
        $employees = Employee::all();
        $deductions = Deduction::all();
    
        return view('dashboard.deduction_employee.index', compact('lists', 'deductions', 'employees'));
    }

    // Show the form for creating a new employee deduction
    public function create()
    {
        $employees = Employee::all();
        $deductions = Deduction::all();
        return view('dashboard.deduction_employee.create', compact('employees', 'deductions'));
    }

    // Store a newly created employee deduction in the database
    public function store(Request $request)
    {
        $rules = [
            'employee_id' => [
                'required',
                'exists:employees,id',
            ],
            'deduction_id' => [
                'required',
                'exists:deductions,id',
                Rule::unique('deduction_employee')
                    ->where('employee_id', $request->input('employee_id'))
                    ->where('deduction_id', $request->input('deduction_id')),
            ],
            'amount' => [
                'required',
                'numeric',
            ],
            'note' => [
                'nullable',
                'string',
            ],
        ];
        
        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            $errorMessages = $validator->errors()->all();
            
            flash()->error(implode('<br>', $errorMessages));
        
            return redirect()->back()->withInput();
        }
        

        DeductionEmployeePivot::create([
            'employee_id' => $request->input('employee_id'),
            'deduction_id' => $request->input('deduction_id'),
            'amount' => $request->input('amount'),
            'note' => $request->input('note'),
        ]);

        flash()->success('Employee deduction added successfully');
        return redirect()->back();
    }

    public function destroy(Deduction $deduction, Employee $employee)
    {
        $employee->deductions()->detach($deduction->id);

        flash()->success('Employee deduction deleted successfully');
        return redirect()->back();
    }
}
