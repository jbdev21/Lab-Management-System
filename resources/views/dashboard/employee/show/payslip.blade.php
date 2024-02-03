@extends('dashboard.includes.layouts.app')

@section('page-title', 'Employee Payslip')

@section('content')
@include('dashboard.employee.includes.head')

<div class="card">
    @include('dashboard.employee.includes.tab')
    <div class="app-card-body p-4">
        <table class="table">
            <thead>
                <tr>
                    <th>Cut-Off</th>
                    <th class="text-center">Total Work Days</th>
                    <th class="text-center">No. Work Days</th>
                    <th>Rate</th>
                    <th>Total Salary</th>
                    <th>Total Deduction</th>
                    <th>Total Net</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @forelse ($employee->payslips as $payslip)
                    <tr>
                        <td>{{ $payslip->date_from?->format('M d, Y'). ' ~ '. $payslip->date_to?->format('M d, Y') }}</td>
                        <td class="text-center">{{ $payslip->total_working_days }}</td>
                        <td class="text-center">{{ $payslip->total_report_days }}</td>
                        <td>{{ toPeso($payslip->employee_daily_rate) }}</td>
                        <td class="text-primary">{{ toPeso($payslip->total_salary) }}</td>
                        <td class="text-danger">{{ toPeso($payslip->total_deductions) }}</td>
                        <td class="text-info fw-bold">
                            {{ toPeso($payslip->net_salary) }}  
                        </td>
                        <td>
                            <a href="{{ route('dashboard.payslip.show', $payslip->id) }}" class="btn-sm btn-info py-0 btn text-white px-2">
                                <i class="fa fa-file"></i> Invoice
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="9" class="text-center">No Records</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection

@push("scripts")
    <script>
        
        function printDiv(divName, redirect = null){
            var printContents = document.getElementById(divName).innerHTML;
            var originalContents = document.body.innerHTML;

            document.body.innerHTML = printContents;
            window.print();
            
            if(redirect){
                window.open(redirect, '_self')
            }

            document.body.innerHTML = originalContents;
        }
    </script>
@endpush
