@extends('dashboard.includes.layouts.app')

@section('page-title', 'Leave')

@section('content')

<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('dashboard.index') }}">Dashboard</a></li>
        <li class="breadcrumb-item" aria-current="page">HR Management</li>
        <li class="breadcrumb-item active" aria-current="page">Leave</li>
    </ol>
</nav>
<div class="row gx-5 gy-3">
    <div class="col-lg-12">
        <div class="app-card shadow-sm mb-4 border-left-decoration">
            <div class="inner">
                <div class="app-card-body p-4">
                    <h4 class="text-success">Leaves List</h4>
                    <div class="row">
                        <div class="col-lg-8">
                            <form>
                                <div class="input-group mb-3">
                                    <input type="text" class="form-control" placeholder="Search for Code, Name, Quantity, Unit...." name="q" value="{{ request('q') }}">
                                    <button class="btn btn-primary text-white" type="submit"><i class="fa fa-search"></i></button>
                                    <a href="{{ route('dashboard.leave.index') }}" data-toggle="tooltip" title="Clear Filter" class="btn btn-secondary text-white" type="submit">
                                        <i class="fa fa-ban"></i>
                                    </a>
                                </div>
                            </form>
                        </div>
                        <div class="col-lg-4 text-end">
                            <button type="button" class="btn btn-primary text-white" data-bs-toggle="modal" data-bs-target="#createLeave">
                                <i class="fa fa-plus"></i> Create Leave
                             </button>
                        </div>
                    </div>
                    {{ $leaves->appends([
                        'q' => Request::get('q'),
                        'perPage' => Request::get('perPage'),
                        ])
                        ->links()
                    }}
                    <div class="p-1">
                        Legend: 
                        <span class="bg-warning rounded-circle">&nbsp;&nbsp;&nbsp;&nbsp;</span> Subject for Approval &nbsp;&nbsp;
                        <span class="bg-success rounded-circle">&nbsp;&nbsp;&nbsp;&nbsp;</span> Approved
                        <span class="bg-danger rounded-circle">&nbsp;&nbsp;&nbsp;&nbsp;</span> Rejected
                    </div>
                    <table class="table">
                        <thead>
                            <tr>
                                <th></th>
                                <th>Employee</th>
                                <th>Date From</th>
                                <th>Date To</th>
                                <th>No of Days</th>
                                <th>Details</th>
                                <th>Status</th>
                                <th>Paid</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($leaves as $leave)
                                <tr>
                                    <td>
                                        <span class="bg-{{ $leave->status_color }} rounded-circle">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>
                                    </td>
                                    <td>
                                        <a href="{{ route('dashboard.leave.show', $leave->id) }}">
                                            {{ $leave->employee->full_name }}
                                        </a>
                                    </td>
                                    <td>{{ $leave->date_from?->format('F d, Y') }}</td>
                                    <td>{{ $leave->date_to?->format('F d, Y') }}</td>
                                    <td>{{ $leave->no_days }}</td>
                                    <td>{{ Str::limit($leave->details, 15) }}</td>
                                    <td>{{ $leave->status }}</td>
                                    <td class="{{ $leave->is_paid ? 'text-info' : 'text-danger' }}">
                                        {{ $leave->is_paid ? 'Yes' : 'No' }}
                                    </td>
                                    <td class="text-end">
                                        <a href="{{ route('dashboard.leave.edit', $leave->id) }}" class="btn-sm btn-warning py-0 btn text-white px-2">
                                            <i class="fa fa-pencil"></i>
                                        </a>
                                        <a href="#" onclick="if(confirm('Are you sure to delete?')){ document.getElementById('delete-{{ $leave->id }}').submit() }" class="btn-sm btn-danger py-0 btn text-white px-2">
                                            <i class="fa fa-trash"></i>
                                        </a>
                                        <form id="delete-{{ $leave->id }}" action="{{ route('dashboard.leave.destroy', $leave->id) }}" method="POST">@csrf @method('DELETE')</form>
                                    </td>
                                </tr>
                            @empty
                                <tr class="text-center">
                                    <td colspan="9">No Records Found!</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                    
                    {{ $leaves->appends([
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

{{-- Create Employee Leaves --}}
<div class="modal fade" id="createLeave" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">

            <form action="{{ route('dashboard.leave.store') }}" class="overlayed-form" method="POST">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Create Leave</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="employee_id">Employee</label>
                        <select class="form-select" name="employee_id" id="employee_id" required>
                            @foreach ($employees as $employee)
                                <option value="{{ $employee->id }}">{{ $employee->full_name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="category_id">Type of Leave</label>
                        <select class="form-select" name="category_id" id="category_id" required>
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="date_from">Date From</label>
                        <input type="date" class="form-control mb-2" name="date_from" id="date_from" value="{{ old('date_from') ?? now()->format('Y-m-d') }}" required>
                    </div>
                    <div class="mb-3">
                        <label for="date_to">Date To</label>
                        <input type="date" class="form-control mb-2" name="date_to" id="date_to" value="{{ old('date_to') ?? now()->format('Y-m-d') }}" required>
                    </div>
                    <div class="mb-3">
                        <label for="no_days">Number of Days</label>
                        <small class="text-danger">** Will auto calculate the date range you provide.</small>
                        <input type="number" class="form-control mb-2" name="no_days" id="no_days" value="{{ old('no_days') ?? 1 }}" readonly>
                    </div>
                    <div class="mb-3">
                        <label for="details">Details</label>
                        <textarea class="form-control mb-2" name="details" id="details" rows="3">{{ old('details') }}</textarea>
                    </div>
                    <div class="mb-3">
                        <label for="is_paid">Is Paid</label>
                        <div class="form-check form-switch">
                            <input class="form-check-input" name="is_paid" type="checkbox" value="1" id="is_paid">
                            <label class="form-check-label" for="is_paid">Paid</label>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary text-white mt-3"><i class="fa fa-save"></i> Save</button>
                    <button type="button" class="btn btn-secondary text-white mt-3" data-bs-dismiss="modal"><i class="fa fa-ban"></i> Cancel</button>
                </div>
            </form>

        </div>
    </div>
</div>

@endsection
@push('scripts')
<script>
    $(document).ready(function () {
        $('#date_from, #date_to').change(function () {
            var dateFrom = new Date($('#date_from').val());
            var dateTo = new Date($('#date_to').val());

            console.log(dateFrom);

            // Calculate the difference in days, ensuring it counts the full days
            var timeDiff = dateTo.getTime() - dateFrom.getTime();
            var daysDiff = Math.floor(timeDiff / (1000 * 3600 * 24)) + 1;

            $('#no_days').val(daysDiff);
        });
    });
</script>
@endpush