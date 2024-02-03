<?php

namespace App\Http\Controllers\dashboard;

use App\Http\Controllers\Controller;
use App\Models\Deduction;
use App\Models\Department;
use App\Models\Employee;
use Carbon\Carbon;
use Illuminate\Http\Request;

class EmployeeController extends Controller
{
    public function index()
    {
        $departments = Department::get();
        $employees = Employee::paginate(20);

        return view('dashboard.employee.index', compact('employees', 'departments'));
    }

    public function create()
    {
        $departments = Department::get();

        return view('dashboard.employee.create', [ 'departments' => $departments]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'department_id' => 'required|exists:departments,id',
            'code' => 'required|unique:employees,code',
            'first_name' => 'required|string',
            'last_name' => 'required|string',
            'middle_name' => 'nullable|string',
            'email' => 'nullable|string',
            'rate_type' => 'required|in:monthly,daily',
            'rate' => 'required|numeric|between:0.01,999999.99',
        ]);

        Employee::create($request->except('_token'));

        flash()->success('New Employee created successfully');
        return redirect()->back();
    }

    

    public function show(Employee $employee, Request $request)
    {
        $employee->load(['payslips']);
        return match ($request->tab) {
            default => $this->attendanceTab($employee, $request),
            'payslip' => $this->payslipTab($employee, $request),
        };
    }

    function attendanceTab(Employee $employee, Request $request)
    {
        $employee->load(['payslips']);
        $selected = Carbon::create($request->input('year', now()->year), $request->input('month', now()->month), 1);

        $attendances = $employee->attendances()
                        ->get();
        return view('dashboard.employee.show.attendance', compact('employee', 'attendances', 'selected'));
    }

    function payslipTab(Employee $employee, Request $request)
    {
        $employee->load(['payslips']);

        return view('dashboard.employee.show.payslip', compact('employee'));
    }

    public function edit($id)
    {
        $employee = Employee::findOrFail($id);
        $departments = Department::get();
        
        return view('dashboard.employee.edit', compact('employee', 'departments'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'department_id' => 'required|exists:departments,id',
            'first_name' => 'required|string',
            'last_name' => 'required|string',
            'middle_name' => 'nullable|string',
            'rate_type' => 'required|in:monthly,daily',
            'rate' => 'required|numeric|between:0.01,999999.99',
        ]);

        $employee = Employee::findOrFail($id);
        $employee->update($request->except('_token'));

        flash()->success('Employee updated successfully');
        return redirect()->route('dashboard.employee.index');
    }

    public function destroy($id)
    {
        $employee = Employee::findOrFail($id);
        $employee->delete();

        flash()->success('Employee deleted successfully');
        return redirect()->back();
    }
}
