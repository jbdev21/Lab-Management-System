@extends('dashboard.includes.layouts.app')

@section('page-title', 'Employee')

@section('content')
@include('dashboard.employee.includes.head')

<div class="card">
    @include('dashboard.employee.includes.tab')
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
</div>
@endsection