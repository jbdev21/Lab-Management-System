@extends('dashboard.includes.layouts.app')

@section('page-title', 'Deduction')

@section('content')
<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('dashboard.index') }}">Dashboard</a></li>
        <li class="breadcrumb-item" aria-current="page">HR Management</li>
        <li class="breadcrumb-item active" aria-current="page">Deductions</li>
    </ol>
</nav>
<div class="app-card shadow-sm mb-4 border-left-decoration">
    <div class="inner">
        <div class="app-card-body p-4">
            <div class="row gx-5 gy-3">
                    <div class="col-lg-4">
                        <div class="app-card mb-4">
                            <div class="app-card-body">
                                <form action="{{ route('dashboard.deduction_employee.store') }}" method="POST">
                                    @csrf
                                
                                    <div class="mb-3">
                                        <label for="employee_id">Employee</label>
                                        <select class="form-control mb-2" name="employee_id" required>
                                            @foreach ($employees as $employee)
                                                <option value="{{ $employee->id }}">{{ $employee->full_name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                
                                    <div class="mb-3">
                                        <label for="deduction_id">Deduction</label>
                                        <select class="form-control mb-2" name="deduction_id" required>
                                            @foreach ($deductions as $deduction)
                                                <option value="{{ $deduction->id }}">{{ $deduction->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                
                                    <div class="mb-3">
                                        <label for="amount">Amount</label>
                                        <input type="number" class="form-control mb-2" name="amount" required>
                                    </div>
                                
                                    <div class="mb-3">
                                        <label for="note">Note</label>
                                        <textarea class="form-control mb-2" name="note" rows="3"></textarea>
                                    </div>
                                
                                    <button type="submit" class="btn btn-primary text-white mt-3"><i class="fa fa-save"></i> Save</button>
                                </form>                                
                            </div>
                        </div>
                    </div><!--//col-->

                <div class="col-lg-8">
                    <form>
                        <div class="row">
                            <div class="col-lg-4">
                                <div class="input-group mb-3">
                                    <input type="text" class="form-control" placeholder="Search for name" value="{{ Request::get("q") }}" name="q">
                                    <button class="btn btn-primary text-white" type="submit"><i class="fa fa-search"></i></button>
                                </div>
                            </div>
                        </div>
                    </form>
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Full Name</th>
                                <th>Deductions Amount</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($lists as $list)
                                @if(count($list->deductions) > 0)
                                    <tr>
                                        <td rowspan="{{ count($list->deductions) + 1 }}">{{ $list->full_name }}</td>
                                    </tr>
                                @else
                                    <tr>
                                        <td rowspan="2">{{ $list->full_name }}</td>
                                    </tr>
                                @endif
                                @forelse($list->deductions as $deduction)
                                    <tr>
                                        <td>
                                            {{ $deduction->name }} - {{ $deduction->pivot->amount }} ({{ $deduction->pivot->note }})
                                        </td>
                                        <td class="text-end">
                                            <a href="{{ route('dashboard.deduction.edit', $deduction->id) }}" class="btn-sm btn-primary py-0 btn text-white px-2"> <i class="fa fa-pencil"></i></a>
                                            <a href="#" onclick="if(confirm('Are you sure to delete?')){ document.getElementById('delete-{{ $deduction->id }}').submit() }" class="btn-sm btn-danger py-0 btn text-white px-2"><i class="fa fa-trash"></i></a>
                                            {{-- <form id="delete-{{ $deduction->id }}" action="{{ route('dashboard.deduction_employee.destroy', $deduction->pivot) }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                            </form> --}}
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="2">No Deductions Found!</td>
                                    </tr>
                                @endforelse
                            @empty
                                <tr>
                                    <td colspan="3">No Deductions Found!</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                    <div style="margin-left: 20px;">
                        {{ $lists->appends([
                            'q' => Request::get('q'),
                            ])
                            ->links()
                        }}
                    </div>
                </div><!--//col-->
            </div><!--//row-->
        </div><!--//app-card-body-->
    </div><!--//inner-->
</div><!--//app-card-->
@endsection