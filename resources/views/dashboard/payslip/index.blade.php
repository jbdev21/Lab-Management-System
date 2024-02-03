@extends('dashboard.includes.layouts.app')

@section('page-title', 'Payslip')

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
                    <h4 class="text-success">Employee Payslip List</h4>
                    <div class="row">
                        <div class="col-lg-6">
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
                            <form id="deleteForm" method="POST" action="{{ route('dashboard.payslip.multiple-delete') }}">
                                @csrf
                                @method('DELETE')
                                <input type="hidden" id="selectedPayslips" name="selectedPayslips" value="">
                                <input type="password" id="password" name="password" hidden>
                                <button type="button" class="btn btn-danger pull-right" onclick="confirmDelete();">
                                    <i class="fa fa-trash"></i> Delete Selected Payslips
                                </button>
                            </form>
                        </div>
                        <div class="col-lg-2">
                            <button type="button" class="btn btn-primary text-white" data-bs-toggle="modal" data-bs-target="#createPayslip">
                                <i class="fa fa-plus"></i> Create Payslip
                             </button>
                        </div>
                    </div>
                    {{ $payslips->appends([
                        'q' => Request::get('q'),
                        'perPage' => Request::get('perPage'),
                        ])
                        ->links()
                    }}
                     <div class="p-1">
                        Legend: 
                        <span class="bg-danger rounded-circle">&nbsp;&nbsp;&nbsp;&nbsp;</span> Not Paid &nbsp;&nbsp;
                        <span class="bg-success rounded-circle">&nbsp;&nbsp;&nbsp;&nbsp;</span> Paid &nbsp;&nbsp;
                        <span class="bg-secondary rounded-circle">&nbsp;&nbsp;&nbsp;&nbsp;</span> Rejected
                    </div>
                    <table class="table">
                        <thead>
                            <tr>
                                <th>
                                    <input type="checkbox" id="selectAll" onclick="toggleCheckboxes()">
                                </th>
                                <th></th>
                                <th>Full Name</th>
                                <th>Cut-Off</th>
                                <th>Total Work Days</th>
                                <th>No. Work Days</th>
                                <th>Rate Type</th>
                                <th>Rate</th>
                                <th>Total Salary</th>
                                <th>Total Deduction</th>
                                <th>Total Net</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($payslips as $payslip)
                                <tr>
                                    <td>
                                        <input type="checkbox" class="checkbox" name="selectedPayslips[]" value="{{ $payslip->id }}" onclick="toggleCheckbox('{{ $payslip->id }}')">
                                    </td>
                                    <td>
                                        <span class="bg-danger rounded-circle">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>
                                    </td>
                                    <td>
                                        <a href="{{ route('dashboard.payslip.show', $payslip->id) }}"> {{ $payslip->employee?->full_name }}</a>
                                    </td>
                                    <td>{{ $payslip->date_from?->format('M d, Y'). ' ~ '. $payslip->date_to?->format('M d, Y') }}</td>
                                    <td class="text-center">{{ $payslip->total_working_days }}</td>
                                    <td class="text-center">{{ $payslip->total_report_days }}</td>
                                    <td>{{ ucFirst($payslip->employee->rate_type) }}</td>
                                    <td>{{ toPeso($payslip->employee_daily_rate) }}</td>
                                    <td class="text-primary">{{ toPeso($payslip->total_salary) }}</td>
                                    <td class="text-danger">{{ toPeso($payslip->total_deductions) }}</td>
                                    <td class="text-info fw-bold">
                                        {{ toPeso($payslip->net_salary) }}  
                                    </td>
                                </tr>
                            @empty
                                <tr class="text-center">
                                    <td colspan="11">No Records Found!</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                    {{ $payslips->appends([
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

{{-- Create Employee Payslip --}}
<div class="modal fade" id="createPayslip" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">

            <form action="{{ route('dashboard.payslip.calculator') }}" class="overlayed-form" method="POST">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Create Payslip</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="date_from">Date From</label>
                        <input type="date" class="form-control mb-2" name="date_from" id="date_from" value="{{ old('date_from') }}" required>
                    </div>
                    <div class="mb-3">
                        <label for="date_to">Date To</label>
                        <input type="date" class="form-control mb-2" name="date_to" id="date_to" value="{{ old('date_to') }}" required>
                    </div>
                    <div class="mb-3">
                        <label for="due_date">Due Date</label>
                        <input type="date" class="form-control mb-2" name="due_date" id="due_date" value="{{ old('due_date') }}" required>
                    </div>
                    
                    <div class="mb-3">
                        <label for="deduction" class="text-danger">** Select Deductions to apply for this cut-off</label>
                        @foreach ($deductions as $deduction)
                            <div class="form-check form-switch">
                                <input class="form-check-input" name="deduction_id[]" value="{{ $deduction->id }}" type="checkbox" id="deduction-id-{{ $deduction->id }}">
                                <label class="form-check-label" for="deduction-id-{{ $deduction->id }}">{{ $deduction->name }}</label>
                            </div>
                        @endforeach
                    </div>                    
                    <div class="mb-3">
                        <label for="send-mail" class="text-danger">** Send Bulk Mail of Payslip to Employee</label>
                        <div class="form-check form-switch">
                            <input class="form-check-input" name="is_send_mail" type="checkbox" id="send-mail">
                            <label class="form-check-label" for="send-mail">Send Mail</label>
                        </div>
                    </div>
                
                    <button type="submit" class="btn btn-primary text-white mt-3"><i class="fa fa-save"></i> Save</button>
                    <a href="{{ route('dashboard.employee.index') }}" class="btn btn-secondary text-white mt-3"><i class="fa fa-ban"></i> Cancel</a>
                </div>
            </form>
             
        </div>
    </div>
</div>
@endsection
@push('scripts')
<script>
   function toggleCheckboxes() {
        var checkboxes = document.querySelectorAll('.checkbox');
        var selectedPayslipsInput = document.getElementById('selectedPayslips');
        
        var selectedPayslips = [];

        checkboxes.forEach(function (checkbox) {
            checkbox.checked = document.getElementById('selectAll').checked;
            if (checkbox.checked) {
                selectedPayslips.push(parseInt(checkbox.value)); // Parse value as an integer
            }
        });

        selectedPayslipsInput.value = JSON.stringify(selectedPayslips); // Convert the array to JSON string
    }

    function toggleCheckbox(payslipId) {
        var checkbox = document.querySelector('.checkbox[value="' + payslipId + '"]');
        var selectedPayslipsInput = document.getElementById('selectedPayslips');
        var selectedPayslips = JSON.parse(selectedPayslipsInput.value || '[]'); // Parse JSON string to array

        if (checkbox.checked) {
            selectedPayslips.push(parseInt(payslipId)); // Parse value as an integer
        } else {
            selectedPayslips = selectedPayslips.filter(id => id !== parseInt(payslipId)); // Parse value as an integer
        }

        selectedPayslipsInput.value = JSON.stringify(selectedPayslips); // Convert the array back to JSON string
    }

    function generateRandomString(length) 
    {
        const charset = "ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
        let result = "";
        for (let i = 0; i < length; i++) {
            result += charset.charAt(Math.floor(Math.random() * charset.length));
        }
        return result;
    }

    function confirmDelete() 
    {
        var randomPassword = generateRandomString(6);
        var password = prompt("To confirm deletion, enter the following code: " + randomPassword);
        if (password !== null && password === randomPassword) {
            document.getElementById('password').value = password;
            document.getElementById('deleteForm').submit();
        } else {
            alert("Incorrect code. Deletion canceled.");
        }
    }
</script>
@endpush
