<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Salary Invoice</title>
</head>
<body>
    <div style="font-family: Arial, sans-serif; padding: 20px;">
        <div style="background-color: #f5f5f5; padding: 20px; text-align: center;">
            <h1 style="color: #333;">Salary Invoice</h1>
            <img src="data:image/png;base64,{{ base64_encode(file_get_contents(public_path('/images/logo.png'))) }}" alt="logo" style="width: 200px; height: 50px;">
        </div>
        <div style="margin-top: 20px;">
            <div style="display: flex; justify-content: space-between;">
                <div style="width: 30%;">
                    <h5>Bill To:</h5>
                    <p><b>Full Name:</b> {{ $employee->full_name }}</p>
                    <p><b>Email Address:</b> {{ $employee->email }}</p>
                </div>
                <div style="width: 30%;">
                    <h5>Bill From:</h5>
                    <p><b>John Wealth Lab. Corp.</b></p>
                    <p><b>Email Address:</b> johnwealth@mail.com</p>
                </div>
                <div style="width: 30%;">
                    <h5>Invoice Details:</h5>
                    <p class="mb-2"><b>Invoice No:</b> {{ $payslip?->date_from?->format('md').$payslip?->date_to?->format('dy') }}</p>
                    <p class="mb-2"><b>Invoice Date:</b> {{ $payslip?->date_from?->format('F d, Y') }} - {{ $payslip?->date_to?->format('F d, Y') }}</p>
                    <p class="mb-2"><b>Due Date:</b> {{ $payslip?->due_date?->format('F d, Y') }}</p>
                </div>
            </div>
            <hr>
            <div style="display: flex; justify-content: space-between;">
                <div style="width: 48%;">
                    <h3>Items</h3>
                    <table style="width: 100%; border-collapse: collapse;">
                        <thead>
                            <tr>
                                <th style="border: 1px solid #ddd; padding: 8px;">Description/Days Work</th>
                                <th style="border: 1px solid #ddd; padding: 8px;">Rate Amount</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($attendances as $attendance)
                                <tr>
                                    <td style="border: 1px solid #ddd; padding: 8px;">{{ $attendance->date->format('M d, Y') }}</td>
                                    <td style="border: 1px solid #ddd; padding: 8px;">{{ toPeso($employeeDailyRate) }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <td style="border: 1px solid #ddd; padding: 8px;"><b>Total Basic Salary:</b></td>
                                <td style="border: 1px solid #ddd; padding: 8px; text-align: right;"><b>{{ toPeso($totalSalary) }}</b></td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
                <div style="width: 48%;">
                    <h3>Deductions</h3>
                    <table style="width: 100%; border-collapse: collapse;">
                        <thead>
                            <tr>
                                <th style="border: 1px solid #ddd; padding: 8px;">Particulars/Items</th>
                                <th style="border: 1px solid #ddd; padding: 8px;">Amount</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($deductionEmployees as $deduction)
                                <tr>
                                    <td style="border: 1px solid #ddd; padding: 8px;">{{ $deduction->deduction->name }}</td>
                                    <td style="border: 1px solid #ddd; padding: 8px;">{{ toPeso($deduction->amount) }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="2" style="border: 1px solid #ddd; padding: 8px;">No Deductions</td>
                                </tr>
                            @endforelse
                        </tbody>
                        <tfoot>
                            <tr>
                                <td style="border: 1px solid #ddd; padding: 8px;"><b>Total Deductions:</b></td>
                                <td style="border: 1px solid #ddd; padding: 8px; text-align: right; color: red;"><b>{{ toPeso($totalDeductions) }}</b></td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
            <hr>
            <div style="width: 100%; text-align: end;">
                <h4>Total Basic Salary: <span style="color: blue;">{{ toPeso($totalSalary) }}</span></h4>
                <h4>Deductions: <span style="color: red;">{{ toPeso($totalDeductions) }}</span></h4>
                <h4>Tax: <span style="color: red;">{{ toPeso(0) }}</span></h4>
                <h4>Net Salary: <span style="color: green;">{{ toPeso($netSalary) }}</span></h4>
            </div>
        </div>
    </div>
</body>
</html>
