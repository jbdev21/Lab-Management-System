<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Employee;
use App\Models\Leave;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class LeaveController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $leaves = Leave::with(['employee', 'category'])->paginate(30);
        $employees = Employee::all();
        $categories = Category::whereType('Employee Leaves Type')->get();

        return view('dashboard.leave.index', compact('leaves', 'employees', 'categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // return $request->all();
        $request->validate([
            'employee_id' => [
                'required',
                Rule::exists('employees', 'id'),
            ],
            'category_id' => [
                'required',
                Rule::exists('categories', 'id'),
            ],
            'date_from' => 'required|date',
            'date_to' => 'required|date|after_or_equal:date_from',
            'no_days' => 'required|integer|min:1',
        ]);

        if ($request->input('is_paid')) {
            $employee = Employee::find($request->input('employee_id'));
    
            $remainingPaidLeaves = $employee->paid_leave;
    
            if ($remainingPaidLeaves < $request->input('no_days')) {
                flash()->error('Not enough paid leaves remaining for the employee.');
                return redirect()->back();
            }
        }

        $leave = Leave::create([
            'employee_id' => $request->input('employee_id'),
            'category_id' => $request->input('category_id'),
            'date_from' => $request->input('date_from'),
            'date_to' => $request->input('date_to'),
            'no_days' => $request->input('no_days'),
            'details' => $request->input('details'),
            'is_paid' => $request->input('is_paid', false),
        ]);

        // Redirect or return response as needed
        return redirect()->route('dashboard.leave.show', $leave->id);
    }

    /**
     * Display the specified resource.
     */
    public function show(Leave $leave)
    {
        $leave->load(['category', 'approvals'])->loadCount(['approvals']);
        
        return view('dashboard.leave.show', array('leave' => $leave));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Leave $leave)
    {
        $leave->load(['employee', 'category']);
        $employees = Employee::all();
        $categories = Category::whereType('Employee Leaves Type')->get();

        return view('dashboard.leave.edit', array('leave' => $leave, 'employees' => $employees, 'categories' => $categories));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Leave $leave)
    {
        $request->validate([
            'date_from' => 'required|date',
            'date_to' => 'required|date|after_or_equal:date_from',
            'no_days' => 'required|integer|min:1',
        ]);
    
        $employee = $leave->employee;
        $totalPaidLeave = $employee->paid_leave + $leave->no_days;
    
        $request->validate([
            'no_days' => "lte:{$totalPaidLeave}",
        ], [
            'no_days.lte' => 'The number of leave days exceeds the available paid leave balance.',
        ]);
    
        $leave->update([
            'employee_id' => $request->input('employee_id'),
            'category_id' => $request->input('category_id'),
            'date_from' => $request->input('date_from'),
            'date_to' => $request->input('date_to'),
            'no_days' => $request->input('no_days'),
            'details' => $request->input('details'),
            'is_paid' => $request->input('is_paid', false),
        ]);
    
        flash()->success('Leave was successfully updated!');
        return redirect()->route('dashboard.leave.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Leave $leave)
    {
        $leave->approvals()->delete();
        $leave->delete();

        flash()->success('Leave was successfully deleted!');
        return redirect()->back();
    }
}
