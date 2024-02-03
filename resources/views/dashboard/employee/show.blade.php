@extends('dashboard.includes.layouts.app')

@section('page-title', 'Department')

@section('content')
<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('dashboard.index') }}">Dashboard</a></li>
        <li class="breadcrumb-item" aria-current="page">HR Management</li>
        <li class="breadcrumb-item active" aria-current="page">Employee Attendance</li>
    </ol>
</nav>
<div class="row gx-5 gy-3">
    <div class="col-lg-12">
         <div class="app-card shadow-sm mb-4 border-left-decoration">
             <div class="inner">
                 <div class="app-card-body p-4">
                     <div class="app-card">
                        <div class="row gx-1">
                            <div class="col-2">
                                <img @if(Auth::user()->thumbnail) src="{{ Auth::user()->thumbnail }}" @endif alt="user profile" class="img-responsive rounded-circle">
                            </div>
                            <div class="col-4">
                                <h3 class="user-name mb-1">{{ $employee->full_name }}</h3>
                                <h6 class="text-muted">{{ $employee->department?->name }}</h6>
                                <small class="text-muted">{{ $employee->department?->name }} Department</small>
                                <div class="mt-3">Employee ID | CODE : {{ $employee->code }}</div>
                                <div class="small text-muted">Date of Join : {{ $employee->created_at }}</div>
                                <a class="btn btn-sm btn-primary mt-3" href="{{ route('dashboard.employee.edit', $employee->id) }}">Update Profile</a>
                            </div>
                            <div class="col-4">
                                <ul>
                                    <li>
                                        <div class="text-info">Phone:</div>
                                        <div class="text"><a href="">9876543210</a></div>
                                    </li>
                                    <li>
                                        <div class="text-info">Email:</div>
                                        <div class="text"><a href="">{{ $employee->email }}</a></div>
                                    </li>
                                    <li>
                                        <div class="text-info">Birthday:</div>
                                        <div class="text">24th July</div>
                                    </li>
                                    <li>
                                        <div class="text-info">Rate Type:</div>
                                        <div class="text">{{ ucFirst($employee->rate_type) }}</div>
                                    </li>
                                    <li>
                                        <div class="text-info">Rate :</div>
                                        <div class="text">{{ toPeso($employee->rate) }}</div>
                                    </li>
                                </ul>
                            </div>
                        </div>
                     </div>
                 </div>
             </div>
         </div>
    </div>
</div>
<div class="row gx-5 gy-3">
   <div class="col-lg-12">
        <div class="app-card shadow-sm mb-4 border-left-decoration">
            <div class="inner">
                <div class="app-card-body p-4">
                    <div class="app-card">
                        <div class="app-card-header">
                            <h4 class="text-success">Attendance of {{ $selected->format('F Y') }}</h4>
                        </div>
                        <div class="app-card-body">
                            <form method="get" action="{{ route('dashboard.employee.show', $employee->id) }}">
                                <div class="row mt-3">
                                    @csrf
                                    <div class="col-2">
                                        <label for="month" class="form-label">Select Month:</label>
                                        <select name="month" class="form-select" onchange="this.form.submit()">
                                            @for ($i = 1; $i <= 12; $i++)
                                                <option value="{{ $i }}" {{ $selected->month == $i ? 'selected' : '' }}>
                                                    {{ date('F', mktime(0, 0, 0, $i, 1)) }}
                                                </option>
                                            @endfor
                                        </select>
                                    </div>
                                    <div class="col-2">
                                        <label for="year" class="form-label">Select Year:</label>
                                        <select class="form-select" name="year" onchange="this.form.submit()">
                                            @for ($year = now()->year; $year >= now()->subYears(10)->year; $year--)
                                                <option value="{{ $year }}" {{ $selected->year == $year ? 'selected' : '' }}>{{ $year }}</option>
                                            @endfor
                                        </select>
                                    </div>
                                </div>
                            </form>
                    
                            <!-- Attendance Table -->
                            <div class="mt-4">
                                
                                <table class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th colspan="7">
                                                <h2 class="text-secondary text-center">{{ $selected->format('F Y') }}</h2>
                                            </th>
                                        </tr>
                                        <tr>
                                            @for ($day = 1; $day <= 7; $day++)
                                                <th class="{{ in_array($selected->copy()->startOfMonth()->next(Carbon\Carbon::MONDAY)->addDays($day - 1)->dayOfWeek, [0, 6]) ? 'text-danger' : 'text-info' }}">
                                                    {{ $selected->copy()->startOfMonth()->next(Carbon\Carbon::MONDAY)->addDays($day - 1)->format('l') }}
                                                </th>
                                            @endfor
                                        </tr>
                                    </thead>
                                    
                                    <tbody>
                                        @php
                                            $startDay = $selected->copy()->startOfMonth()->startOfWeek();
                                            $endDay = $selected->copy()->endOfMonth()->endOfWeek();
                                        @endphp
                                
                                        @for ($currentDate = $startDay; $currentDate->lte($endDay); $currentDate->addDay())
                                            @if ($currentDate->dayOfWeek == 1)
                                                <tr>
                                            @endif
                                            <td class="{{ in_array($currentDate->dayOfWeek, [0, 6]) ? 'text-danger' : 'text-info' }}">
                                                <b>{{ $currentDate->format('d') }}</b>  | &nbsp;
                                                @php
                                                    $formattedDate = $currentDate->toDateString();
                                                    $attendance = $attendances->first(function ($attendance) use ($formattedDate) {
                                                        return substr($attendance->date, 0, 10) == $formattedDate;
                                                    });
                                                @endphp
                                                @if ($attendance)
                                                    <span class="badge bg-success">Present</span>
                                                @else
                                                    <span class="badge bg-danger">Absent</span>
                                                @endif
                                            </td>
                                            @if ($currentDate->dayOfWeek == 0)
                                                </tr>
                                            @endif
                                        @endfor
                                    </tbody>
                                </table>
                                
                            </div>
                        </div>
                    </div>
                </div><!--//col-->
            </div><!--//row-->
        </div><!--//app-card-body-->
    </div><!--//inner-->
</div>
@endsection
