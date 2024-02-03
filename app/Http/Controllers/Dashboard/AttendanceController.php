<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Imports\Attendance\AttendanceImport;
use App\Models\Attendance;
use App\Models\Employee;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;

class AttendanceController extends Controller
{
    public function index(Request $request)
    {
        $selected = Carbon::create($request->input('year', now()->year), $request->input('month', now()->month));

        $employees = Employee::with(['attendances' => function ($query) use ($selected) {
                                $query->whereMonth('date', $selected->month)
                                        ->whereYear('date', $selected->year)->get();
                            }])
                            ->when($request->search, function($q) use ($request){
                                $q->where("first_name", "like", '%' . $request->search . '%');
                            })->get();

        return view('dashboard.attendance.index', compact('employees', 'selected'));
    }

    public function create()
    {
        return view('dashboard.attendance.create');
    }

    // Show the form for uploading attendance data
    public function uploadForm()
    {
        return view('attendance.upload');
    }

    // Process the uploaded attendance data
    public function upload(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:csv,xlsx,xls',
        ]);        

        try {
            Excel::import(new AttendanceImport, $request->file('file'));
        
            flash()->success('Attendance data uploaded successfully');
        } catch (\Exception $e) {
            flash()->error('Error uploading attendance data: ' . $e->getMessage());
        }
        
        return redirect()->back();
    }


}
