@extends('dashboard.includes.layouts.app')

@section('page-title', 'PaySlip')

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
    <a class="btn btn-success text-end text-white mb-4" onclick="printDiv('printableArea', '{{ Request::get("redirect") }}')" target="_blank"><i class="fa fa-print"></i> Print</a>
        <div id="printableArea" class="app-card shadow-sm mb-4 border-left-decoration">
            <div class="inner">
                <div class="app-card-body p-4">
                    <div class="app-card">
                        <div class="app-card-header">
                            <span class="display-6 pull-right">Salary Invoice</span>
                                <img class="logo-icon" src="/images/logo.png" alt="logo" style="width:200px; height:50px;">
                        </div>
                        <div class="app-card-body">
                            <div class="row">
                                <div class="col-4 mt-4 mb-4">
                                    <h5>Bill To:</h5>
                                    <p class="mb-2"><b>Full Name:</b> {{ $payslip->employee->full_name }}</p>
                                    <p class="mb-2"><b>Email Address:</b> {{ $payslip->employee->email }}</p>
                                </div>
                                
                                <div class="col-4 mt-4 mb-4">
                                    <h5>Bill From:</h5>
                                    <p class="mb-2"><b>John Wealth Lab. Corp.</b></p>
                                    <p class="mb-2"><b>Email Address:</b> johnwealth@mail.com</p>
                                </div>
                                
                                <div class="col-4 mt-4 mb-4">
                                    <h5>Invoice Details:</h5>
                                    <p class="mb-2"><b>Invoice No:</b> {{ $payslip->date_from?->format('md').$payslip->date_to?->format('dy') }}</p>
                                    <p class="mb-2"><b>Invoice Date:</b> {{ $payslip->date_from?->format('F d, Y') }} - {{ $payslip->date_to?->format('F d, Y') }}</p>
                                    <p class="mb-2"><b>Due Date:</b> {{ $payslip->due_date?->format('F d, Y') }}</p>
                                </div>                                
                                <hr/>
                                <div class="col-6">
                                    <h3>Items</h3>
                                    <table class="table table-striped">
                                        <thead>
                                            <tr>
                                                <td colspan="4">
                                                    <small class="text-danger">
                                                        <p class="mb-2">
                                                            Note: Total Working Days: {{ $payslip->total_working_days }}
                                                            | Total Working Day Reported: {{ $payslip->total_report_days }}
                                                            <br />
                                                            The table below shows the daily rate for each working day.
                                                        </p>
                                                    </small>
                                                </td>
                                            </tr>
                                            <tr>
                                                <th>Description</th>
                                                <th>No. Day Works</th>
                                                <th>Rate</th>
                                                <th>Total Amount</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>
                                                    Total Working Day Reported: {{ $payslip->total_report_days }}
                                                </td>
                                                <td>{{ $payslip->total_report_days }}</td>
                                                <td>{{ toPeso($payslip->employee_daily_rate) }}</td>
                                                <td>{{ toPeso($payslip->total_salary) }}</td>
                                            </tr>
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <td colspan="3">
                                                    <b>Total Basic Salary:</b>
                                                </td>
                                                <td class="text-info">
                                                    <b>{{ toPeso($payslip->total_salary) }}</b>
                                                </td>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                                
                    
                                <div class="col-6">
                                    <h3>Deductions</h3>
                                    <table class="table table-striped">
                                        <thead>
                                            <tr>
                                                <td colspan="2">
                                                    <small class="text-danger">
                                                        <p class="mb-2">
                                                            Note: Deductions listed below include Benefits Deduction
                                                        </p>
                                                    </small>
                                                </td>
                                            </tr>
                                            <tr>
                                                <th>Particulars/Items</th>
                                                <th>Amount</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse($payslip->deductionHistories as $deduction)
                                                <tr>
                                                    <td>{{ $deduction->deduction->name }}</td>
                                                    <td>{{ toPeso($deduction->amount) }}</td>
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td colspan="2">No Deductions</td>
                                                </tr>
                                            @endforelse
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <td>
                                                    <b>Total Deductions:</b>
                                                </td>
                                                <td class="text-danger">
                                                    <b>{{ toPeso($payslip->total_deductions) }}</b>
                                                </td>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                                
                                <hr />
                                <div class="col-6">
                                    <table class="table table-striped">
                                        <tbody>
                                            <tr>
                                                <td>Total Basic Salary:</td>
                                                <td class="text-end text-info">
                                                    <b>{{ toPeso($payslip->total_salary) }}</b>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Deductions:</td>
                                                <td class="text-end text-danger">
                                                    <b>{{ toPeso($payslip->total_deductions) }}</b>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Tax:</td>
                                                <td class="text-end text-danger">
                                                    {{ toPeso(0) }}
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Net Salary:</td>
                                                <td>
                                                    <h5 class="text-end text-success">{{ toPeso($payslip->net_salary) }}</h5>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                
                            </div>
                        </div>
                    </div>
                </div><!--//col-->
            </div><!--//row-->
        </div><!--//app-card-body-->
    </div><!--//inner-->
</div><!--//app-card-->
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

