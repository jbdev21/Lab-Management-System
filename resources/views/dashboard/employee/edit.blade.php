@extends('dashboard.includes.layouts.app')

@section('page-title', 'Edit Employee')

@section('content')
<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('dashboard.index') }}">Dashboard</a></li>
        <li class="breadcrumb-item" aria-current="page">HR Management</li>
        <li class="breadcrumb-item active" aria-current="page">Edit Employee</li>
    </ol>
</nav>
<div class="row gx-5 gy-3">
   <div class="col-lg-6">
        <div class="app-card shadow-sm mb-4 border-left-decoration">
            <div class="inner">
                <div class="app-card-body p-4">
                    <div class="app-card">
                        <div class="app-card-body">
                            <form action="{{ route('dashboard.employee.update', $employee->id) }}" method="POST">
                                    @csrf @method('PUT')
                                <div class="mb-3">
                                    <label for="department_id">Department</label>
                                    <select class="form-control mb-2" name="department_id" id="department_id" required>
                                        <option value="">Select Department</option>
                                        @foreach($departments as $department)
                                            <option value="{{ $department->id }}" @if($employee->department_id == $department->id) selected @endif>{{ $department->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            
                                <div class="mb-3">
                                    <label for="code">Code</label>
                                    <input type="text" class="form-control mb-2" name="code" id="code" value="{{ $employee->code }}" required>
                                </div>
                            
                                <div class="mb-3">
                                    <label for="first_name">First Name</label>
                                    <input type="text" class="form-control mb-2" name="first_name" id="first_name" value="{{ $employee->first_name }}" required>
                                </div>
                            
                                <div class="mb-3">
                                    <label for="last_name">Last Name</label>
                                    <input type="text" class="form-control mb-2" name="last_name" id="last_name" value="{{ $employee->last_name }}" required>
                                </div>
                            
                                <div class="mb-3">
                                    <label for="middle_name">Middle Name</label>
                                    <input type="text" class="form-control mb-2" name="middle_name" id="middle_name" value="{{ $employee->middle_name }}">
                                </div>
                                                   
                                <div class="mb-3">
                                    <label for="email">Email Address</label>
                                    <input type="email" class="form-control mb-2" name="email" id="email" value="{{ $employee->email }}">
                                </div>

                                <div class="mb-3">
                                    <label for="rate_type">Rate Type</label>
                                    <select class="form-control mb-2" name="rate_type" id="rate_type">
                                        <option value="monthly">Monthly</option>
                                        <option value="daily" @if($employee->rate_type == 'daily') selected @endif>Daily</option>
                                    </select>
                                </div>
                            
                                <div class="mb-3">
                                    <label for="rate">Rate</label>
                                    <input type="number" step="0.01" class="form-control mb-2" name="rate" id="rate" value="{{ $employee->rate }}">
                                </div>

                                <div class="mb-3">
                                    <label for="rate">Paid Leave</label>
                                    <input type="number" step="0.01" class="form-control mb-2" name="paid_leave" id="rate" value="{{ $employee->paid_leave }}">
                                </div>
                            
                                <button type="submit" class="btn btn-primary text-white mt-3"><i class="fa fa-save"></i> Update</button>
                                <a href="{{ route('dashboard.employee.index') }}" class="btn btn-secondary text-white mt-3"><i class="fa fa-ban"></i> Cancel</a>
                            </form>
                        </div>
                    </div>
                </div><!--//col-->
            </div><!--//row-->
        </div><!--//app-card-body-->
    </div><!--//inner-->
</div><!--//app-card-->
@endsection
