<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Deduction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class DeductionController extends Controller
{
    public function index()
    {
        $deductions = Deduction::paginate();

        return view('dashboard.deduction.index', compact('deductions'));
    }

    // Show the form for creating a new deduction
    public function create()
    {
        return view('dashboard.deduction.create');
    }

    // Store a newly created deduction in the database
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        Deduction::create([
            'name' => $request->input('name'),
        ]);

        flash()->success('Deductions added successfully');
        return redirect()->back();
    }

    // Show the form for editing the specified deduction
    public function edit($id)
    {
        $deduction = Deduction::findOrFail($id);
        return view('dashboard.deduction.edit', compact('deduction'));
    }

    // Update the specified deduction in the database
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $deduction = Deduction::findOrFail($id);
        $deduction->update([
            'name' => $request->input('name'),
        ]);

        flash()->success('Deduction updated successfully');

        return redirect()->route('dashboard.deduction.index');
    }

    // Remove the specified deduction from the database
    public function destroy($id)
    {
        $deduction = Deduction::findOrFail($id);
        $deduction->delete();

        flash()->success('Deduction deleted successfully');
        return redirect()->back();
    }
}
