@extends('dashboard.includes.layouts.app')

@section('page-title', 'Edit leave')

@section('content')
<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('dashboard.index') }}">Dashboard</a></li>
        <li class="breadcrumb-item" aria-current="page">HR Management</li>
        <li class="breadcrumb-item active" aria-current="page">Edit Leave</li>
    </ol>
</nav>
<div class="row gx-5 gy-3">
   <div class="col-lg-6">
        <div class="app-card shadow-sm mb-4 border-left-decoration">
            <div class="inner">
                <div class="app-card-body p-4">
                    <div class="app-card">
                        <div class="app-card-body">
                            <form method="post" action="{{ route('dashboard.leave.update', $leave->id) }}">
                                @csrf
                                @method('PATCH')
                        
                                <div class="mb-3">
                                    <label for="employee_id">Employee</label>
                                    <select class="form-select" name="employee_id" id="employee_id" required>
                                        @foreach ($employees as $employee)
                                            <option value="{{ $employee->id }}" {{ $employee->id == $leave->employee_id ? 'selected' : '' }}>
                                                {{ $employee->full_name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                        
                                <div class="mb-3">
                                    <label for="category_id">Type of Leave</label>
                                    <select class="form-select" name="category_id" id="category_id" required>
                                        @foreach ($categories as $category)
                                            <option value="{{ $category->id }}" {{ $category->id == $leave->category_id ? 'selected' : '' }}>
                                                {{ $category->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                        
                                <div class="mb-3">
                                    <label for="date_from">Date From</label>
                                    <input type="date" class="form-control" id="date_from" name="date_from" value="{{ $leave->date_from->format('Y-m-d') }}" required>
                                </div>
                                
                        
                                <div class="mb-3">
                                    <label for="date_to">Date To</label>
                                    <input type="date" class="form-control" id="date_to" name="date_to" value="{{ $leave->date_to->format('Y-m-d') }}" required>
                                </div>
                        
                                <div class="mb-3">
                                    <label for="no_days">Number of Days</label>
                                    <input type="number" class="form-control" id="no_days" name="no_days" value="{{ $leave->no_days }}" required>
                                </div>
                        
                                <div class="mb-3">
                                    <label for="no_days">Is Paid</label>
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" name="is_paid" type="checkbox" value="1" id="is_paid" {{ $leave->is_paid ? 'checked' : '' }}>
                                    </div>
                                </div>
                        
                                <div class="mb-3">
                                    <label for="details">Details</label>
                                    <textarea class="form-control" id="details" name="details" rows="3">{{ $leave->details }}</textarea>
                                </div>
                        
                                <button type="submit" class="btn btn-primary">Update</button>
                            </form>
                        </div>
                    </div>
                </div><!--//col-->
            </div><!--//row-->
        </div><!--//app-card-body-->
    </div><!--//inner-->
</div><!--//app-card-->
@endsection
@push('scripts')
<script>
    $(document).ready(function () {
        $('#date_from, #date_to').change(function () {
            var dateFrom = new Date($('#date_from').val());
            var dateTo = new Date($('#date_to').val());

            // Calculate the difference in days, ensuring it counts the full days
            var timeDiff = dateTo.getTime() - dateFrom.getTime();
            var daysDiff = Math.floor(timeDiff / (1000 * 3600 * 24)) + 1;

            $('#no_days').val(daysDiff);
        });
    });
</script>
@endpush