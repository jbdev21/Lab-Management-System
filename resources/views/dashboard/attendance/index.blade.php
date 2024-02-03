@extends('dashboard.includes.layouts.app')

@section('page-title', 'attendance')

@section('content')
@php
    $modalIndex = 0;
@endphp
<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('dashboard.index') }}">Dashboard</a></li>
        <li class="breadcrumb-item" aria-current="page">HR Management</li>
        <li class="breadcrumb-item active" aria-current="page">Attendance</li>
    </ol>
</nav>
<div class="row gx-5 gy-3">
    <div class="col-lg-12">
        <div class="app-card shadow-sm mb-4 border-left-decoration">
            <div class="inner">
                <div class="app-card-body p-4">
                    <h4 class="text-success">Attendances List</h4>
                    <form>
                        <div class="row filter-row">
                                <div class="col-sm-6 col-md-5">  
                                    <div class="input-group mb-3">
                                        <input type="text" name="search" value="{{ Request::get('search') }}"  class="form-control floating">
                                        <button class="btn btn-primary text-white" type="submit"><i class="fa fa-search"></i></button>
                                    </div>
                                </div>
                                <div class="col-sm-6 col-md-2"> 
                                    <select class="form-select" name="month" onchange="this.form.submit()"> 
                                        @for ($i = 1; $i <= 12; $i++)
                                            <option value="{{ $i }}" {{ $selected->month == $i ? 'selected' : '' }}>
                                                {{ date('F', mktime(0, 0, 0, $i, 1)) }}
                                            </option>
                                        @endfor
                                    </select>
                                </div>
                                <div class="col-sm-6 col-md-2"> 
                                    <select class="form-select" name="year" onchange="this.form.submit()">
                                        @for ($year = now()->year; $year >= now()->subYears(10)->year; $year--)
                                            <option value="{{ $year }}" {{ $selected->year == $year ? 'selected' : '' }}>{{ $year }}</option>
                                        @endfor
                                    </select>
                                </div>
                            <div class="col-md-3">  
                                <button type="button" class="btn btn-primary text-white" data-bs-toggle="modal" data-bs-target="#addNewattendance">
                                    <i class="fa fa-upload"></i> Upload Attendance CSV File
                                </button>
                            </div>     
                        </div>
                    </form>
                    <table class="table table-responsive table-hover table-bordered">
                        <thead>
                            <tr>
                                <th rowspan="2" class="text-center">Employee</th>
                                <th colspan="{{ $selected->endOfMonth()->format('d') }}" class="text-center">
                                   {{ $selected->format('F Y') }}
                                </th>
                            </tr>
                            <tr>
                                @php
                                    $startDay = $selected->copy()->startOfMonth();
                                    $endDay = $selected->copy()->endOfMonth();
                                @endphp
                                @for ($currentDate = $startDay; $currentDate->lte($endDay); $currentDate->addDay())
                                    <th class="{{ in_array($currentDate->dayOfWeek, [0, 6]) ? 'bg-danger text-white' : '' }}">
                                        {{ $currentDate->format('d') }}
                                    </th>
                                @endfor
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($employees as $employee)
                                <tr>
                                    <td>
                                        {{ $employee->full_name }}
                                    </td>
                                    @for ($i = 1; $i <= $selected->endOfMonth()->format('d'); $i++)
                                        @php
                                            $attendanceFound = false;
                                            $modalId = 'attendance_info_' . $modalIndex;
                                            $modalIndex++;
                                            $currentDate = Carbon\Carbon::create($selected->year, $selected->month, $i);
                                        @endphp

                                        <td class="text-center {{ in_array($currentDate->dayOfWeek, [0, 6]) ? '' : '' }}">
                                            @foreach ($employee->attendances as $attendance)
                                                @if($attendance->date?->format('d') == $i)
                                                    @php
                                                        $attendanceFound = true;
                                                    @endphp
                                                    <a href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#{{ $modalId }}">
                                                        <i class="fa fa-check text-success"></i>
                                                    </a>

                                                    <!-- Attendance Modal -->
                                                    <div class="modal custom-modal fade" id="{{ $modalId }}" role="dialog">
                                                        <div class="modal-dialog modal-dialog-centered modal-md" role="document">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title">Attendance: {{ $employee->full_name }} - {{ $employee->code }}</h5>
                                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                </div>
                                                                <div class="modal-body">
                                                                    <div class="row">
                                                                        <div class="col-md-12">
                                                                            <div class="card-body">
                                                                                <h5 class="card-title text-center text-muted">
                                                                                    {{ $attendance->date?->format('F d, Y') }}
                                                                                </h5>
                                                                                <hr />
                                                                                <div class="statistics mt-1">
                                                                                    <div class="row">
                                                                                        <div class="col-md-6 col-6 text-center">
                                                                                            <div class="stats-box">
                                                                                                <p>TIME IN</p>
                                                                                                <h6>{{ $attendance->time_in?->format('h:i A') }}</h6>
                                                                                            </div>
                                                                                        </div>
                                                                                        <div class="col-md-6 col-6 text-center">
                                                                                            <div class="stats-box">
                                                                                                <p>TIME OUT</p>
                                                                                                <h6>{{ $attendance->time_out?->format('h:i A') }}</h6>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                    <hr />  
                                                                                    <div class="row mt-1">
                                                                                        <div class="col-md-4 col-4 text-center">
                                                                                            <div class="stats-box">
                                                                                                <p>RENDERED TIME</p>
                                                                                                <h6>{{ $attendance->time_rendered }}</h6>
                                                                                            </div>
                                                                                        </div>
                                                                                        <div class="col-md-4 col-4 text-center">
                                                                                            <div class="stats-box">
                                                                                                <p>UNDER TIME</p>
                                                                                                <h6>{{ $attendance->under_time }}</h6>
                                                                                            </div>
                                                                                        </div>
                                                                                        <div class="col-md-4 col-4 text-center">
                                                                                            <div class="stats-box">
                                                                                                <p>OVER TIME</p>
                                                                                                <h6>{{ $attendance->over_time }}</h6>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                    <hr/>
                                                                                    <div class="text-center">
                                                                                        <h6>NOTE</h6>
                                                                                        <p>{{ $attendance->note }}</p>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <!-- /Attendance Modal -->
                                                @endif
                                            @endforeach
                                            @if(!$attendanceFound)
                                                <i class="fa fa-close text-danger"></i>
                                            @endif
                                        </td>
                                    @endfor
                                </tr>
                            @empty
                                <tr class="text-center">
                                    <td colspan="{{ $selected->endOfMonth()->format('d') + 1 }}">No Records Found!</td>
                                </tr>
                            @endforelse
                                
                    </table>
                </div>
            </div>                            
        </div>
    </div>
</div>

<div class="modal fade" id="addNewattendance" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Upload Attendance CSV</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('dashboard.attendance.upload') }}" method="POST" class="overlayed-form" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="file">Upload</label>
                        <input type="file" class="form-control mb-2" name="file" id="file" accept=".csv, .xlsx, .xls" required>
                    </div>
                
                    <button type="submit" class="btn btn-primary text-white mt-3"><i class="fa fa-save"></i> Save</button>
                </div>
            </form> 
        </div>
    </div>
</div>


@endsection
