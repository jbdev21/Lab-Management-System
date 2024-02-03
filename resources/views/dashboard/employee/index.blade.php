@extends('dashboard.includes.layouts.app')

@section('page-title', 'Employee')

@section('content')

<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('dashboard.index') }}">Dashboard</a></li>
        <li class="breadcrumb-item" aria-current="page">HR Management</li>
        <li class="breadcrumb-item active" aria-current="page">Employee</li>
    </ol>
</nav>
<div class="row gx-5 gy-3">
    <div class="col-lg-12">
        <div class="app-card shadow-sm mb-4 border-left-decoration">
            <div class="inner">
                <div class="app-card-body p-4">
                    <h4 class="text-success">Employees List</h4>
                    <div class="row">
                        <div class="col-lg-8">
                            <form>
                                <div class="input-group mb-3">
                                    <input type="text" class="form-control" placeholder="Search for Code, Name, Quantity, Unit...." name="q" value="{{ request('q') }}">
                                    <button class="btn btn-primary text-white" type="submit"><i class="fa fa-search"></i></button>
                                    <a href="{{ route('dashboard.employee.index') }}" data-toggle="tooltip" title="Clear Filter" class="btn btn-secondary text-white" type="submit">
                                        <i class="fa fa-ban"></i>
                                    </a>
                                </div>
                            </form>
                        </div>
                        <div class="col-lg-4 text-end">
                            <button type="button" class="btn btn-primary text-white" data-bs-toggle="modal" data-bs-target="#addNewEmployee">
                                <i class="fa fa-plus"></i> Add New Employee
                             </button>
                        </div>
                    </div>
                    {{ $employees->appends([
                        'q' => Request::get('q'),
                        'perPage' => Request::get('perPage'),
                        ])
                        ->links()
                    }}
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Code</th>
                                <th>Full Name</th>
                                <th>Rate Type</th>
                                <th>Rate Amount</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($employees as $employee)
                                <tr>
                                    <td>{{ $employee->code }}</td>
                                    <td>
                                        <a href="{{ route('dashboard.employee.show', $employee->id) }}"> {{ $employee->full_name }}</a>
                                    </td>
                                    <td>{{ ucFirst($employee->rate_type) }}</td>
                                    <td>{{ toPeso($employee->rate) }}</td>
                                    <td class="text-end">
                                        {{-- @can("update accounts") --}}
                                        <a href="{{ route('dashboard.employee.edit', $employee->id) }}" class="btn-sm btn-primary py-0 btn text-white px-2"> <i class="fa fa-pencil"></i></a>
                                        {{-- @endcan --}}
                                        {{-- @can("delete accounts") --}}
                                            <a href="#" onclick="if(confirm('Are you sure to delete?')){ document.getElementById('delete-{{ $employee->id }}').submit() }" class="btn-sm btn-danger py-0 btn text-white px-2"><i class="fa fa-trash"></i></a>
                                            <form id="delete-{{ $employee->id }}" action="{{ route('dashboard.employee.destroy', $employee->id) }}" method="POST">@csrf @method('DELETE')</form>
                                        {{-- @endcan --}}
                                    </td>
                                </tr>
                            @empty
                                <tr class="text-center">
                                    <td colspan="5">No Records Found!</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                    {{ $employees->appends([
                        'q' => Request::get('q'),
                        'perPage' => Request::get('perPage'),
                        ])
                        ->links()
                    }}
                </div>
            </div>                            
        </div><!--//app-card-body-->
    </div><!--//inner-->
</div><!--//app-card-->

<div class="modal fade" id="addNewEmployee" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">

            <form action="{{ route('dashboard.employee.store') }}" method="POST">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Register Employee</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="department_id">Departments</label>
                        <select class="form-control mb-2" name="department_id" id="department_id" required>
                            <option value="">Select Department</option>
                            @foreach($departments as $department)
                                <option value="{{ $department->id }}">{{ $department->name }}</option>
                            @endforeach
                        </select>
                    </div>
                
                    <div class="mb-3">
                        <label for="code">Code</label>
                        <input type="text" class="form-control mb-2" name="code" id="code" value="{{ old('code') }}" required>
                    </div>
                
                    <div class="mb-3">
                        <label for="first_name">First Name</label>
                        <input type="text" class="form-control mb-2" name="first_name" id="first_name" value="{{ old('first_name') }}" required>
                    </div>
                
                    <div class="mb-3">
                        <label for="last_name">Last Name</label>
                        <input type="text" class="form-control mb-2" name="last_name" id="last_name" value="{{ old('last_name') }}" required>
                    </div>
                
                    <div class="mb-3">
                        <label for="middle_name">Middle Name</label>
                        <input type="text" class="form-control mb-2" name="middle_name" id="middle_name" value="{{ old('middle_name') }}">
                    </div>

                    <div class="mb-3">
                        <label for="email">Email Address</label>
                        <input type="email" class="form-control mb-2" name="email" id="email" value="{{ old('email') }}">
                    </div>
                
                    <div class="mb-3">
                        <label for="rate_type">Rate Type</label>
                        <select class="form-control mb-2" name="rate_type" id="rate_type" required>
                            <option value="monthly">Monthly</option>
                            <option value="daily">Daily</option>
                        </select>
                    </div>
                
                    <div class="mb-3">
                        <label for="rate">Rate</label>
                        <input type="number" step="0.01" class="form-control mb-2" name="rate" id="rate" value="{{ old('rate') }}" required>
                    </div>

                    <div class="mb-3">
                        <label for="paid_leave">Paid Leave</label>
                        <input type="number" step="0.01" class="form-control mb-2" name="paid_leave" id="paid_leave" value="{{ old('paid_leave') ?? 0 }}">
                    </div>
                
                    <button type="submit" class="btn btn-primary text-white mt-3"><i class="fa fa-save"></i> Save</button>
                    <a href="{{ route('dashboard.employee.index') }}" class="btn btn-secondary text-white mt-3"><i class="fa fa-ban"></i> Cancel</a>
                </div>
            </form>
             
        </div>
    </div>
</div>
@endsection
