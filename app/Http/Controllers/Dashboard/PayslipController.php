<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Mail\PayslipInvoice;
use App\Models\Attendance;
use App\Models\Deduction;
use App\Models\DeductionEmployeePivot;
use App\Models\DeductionHistory;
use App\Models\Employee;
use App\Models\Payslip;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class PayslipController extends Controller
{
    public function index()
    {
        $payslips = Payslip::with(['employee'])->latest()->paginate(30);
        $deductions = Deduction::all();

        return view('dashboard.payslip.index', [
            'payslips' => $payslips,
            'deductions' => $deductions
        ]);
    }

    public function show(Payslip $payslip)
    {
        $payslip->load(['deductionHistories' => function ($query) {
            $query->with('deduction');
        }]);

        $attendances = $this->getAttendancesForDateRange($payslip->employee_id, $payslip->date_from, $payslip->date_to);

        return view('dashboard.payslip.show', [
            'payslip' => $payslip,
            'attendances' => $attendances,
        ]);
    }

    public function multipleDelete(Request $request)
    {
        $selectedPayslips = explode(',', $request->selectedPayslips);
        $selectedPayslips = array_map('intval', $selectedPayslips);

        // Delete the selected payslips
        Payslip::whereIn('id', $selectedPayslips)->delete();

        flash()->warning('Authorized! Payslips deleted successfully');
        return redirect()->back();
    }

    public function calculatePayslip(Request $request)
    {
        $dateFrom = Carbon::parse($request->input('date_from'));
        $dateTo = Carbon::parse($request->input('date_to'));
        $dueDate = Carbon::parse($request->input('due_date'));
        $isSendMail = $request->input('is_send_mail');
        $selectedDeductions = $request->input('deduction_id', []); 

        // Get all employees
        $employees = Employee::all();

        // Loop through each employee
        foreach ($employees as $employee) {
            // Check if the payslip entry already exists for the specified period
            $existingPayslip = Payslip::where('employee_id', $employee->id)
                            ->where(function ($query) use ($dateFrom, $dateTo) {
                                $query->whereBetween('date_from', [$dateFrom, $dateTo])
                                    ->orWhereBetween('date_to', [$dateFrom, $dateTo]);
                            })
                            ->first();

            if (!$existingPayslip) {
                // If the payslip entry doesn't exist, proceed with the DB transaction
                DB::transaction(function () use ($employee, $dateFrom, $dateTo, $dueDate, $isSendMail, $selectedDeductions) {
                    // Retrieve  attendance, and deductions data
                    $attendances = $this->getAttendancesForDateRange($employee->id, $dateFrom, $dateTo);

                    // Filter deductions based on selected ones
                    $deductionEmployees = DeductionEmployeePivot::with(['deduction'])
                                        ->where('employee_id', $employee->id)
                                        ->whereIn('deduction_id', $selectedDeductions)
                                        ->get();

                    // Calculate total working days and employee daily rate
                    $totalWorkingDays = $this->countWorkingDaysInDateRange($dateFrom, $dateTo);
                    $totalReportDays = $attendances->count();
                    $employeeDailyRate = $this->calculateEmployeeDailyRate($employee, $dateFrom);

                    // Calculate total Payslip
                    $totalPayslip = $this->calculateTotalPayslip($totalReportDays, $employeeDailyRate);

                    // Deduct employee deductions from the total Payslip
                    $totalDeductions = $this->calculateTotalDeductions($deductionEmployees);

                    // Calculate net Payslip
                    $netPayslip = $totalPayslip - $totalDeductions;


                    // Store the calculated payslip in the database
                    $payslip = Payslip::create([
                        'employee_id' => $employee->id,
                        'date_from' => $dateFrom,
                        'date_to' => $dateTo,
                        'due_date' => $dueDate,
                        'total_working_days' => $totalWorkingDays,
                        'total_report_days' => $totalReportDays,
                        'total_salary' => $totalPayslip,
                        'employee_daily_rate' => $employeeDailyRate,
                        'total_deductions' => $totalDeductions,
                        'net_salary' => $netPayslip,
                        'status' => 'pending',
                    ]);

                    // Store deduction history
                    $this->storeDeductionHistory($employee->id, $deductionEmployees, $payslip->id);

                    // Send email if the flag is set
                    if ($isSendMail) {
                        Mail::to($employee->email)->send(new PayslipInvoice($employee, $attendances, $totalPayslip, $totalDeductions, $netPayslip, $totalWorkingDays, $employeeDailyRate, $deductionEmployees, $totalReportDays, $payslip));
                    }
                }, 5);
            }
        }

        flash()->success('Generate Employee Payslips Successfully!');
        return redirect()->back();
    }
  

    private function countWorkingDaysInDateRange($dateFrom, $dateTo)
    {
        $workingDays = 0;
    
        for ($currentDay = Carbon::parse($dateFrom); $currentDay->lte(Carbon::parse($dateTo)); $currentDay->addDay()) {
            if ($currentDay->isWeekday()) {
                $workingDays++;
            }
        }
    
        return $workingDays;
    }

    private function getAttendancesForDateRange($employeeId, $dateFrom, $dateTo)
    {
        return Attendance::where('employee_id', $employeeId)
            ->whereNotNull('time_rendered')
            ->where(function ($query) use ($dateFrom, $dateTo) {
                $query->whereBetween('date', [$dateFrom, $dateTo])
                    ->orWhereBetween('date', [$dateFrom, $dateTo]);
            })
            ->get();
    }    

    private function calculateEmployeeDailyRate($employee, $dateFrom)
    {
        $firstDayOfMonth = $dateFrom->copy()->startOfMonth();
        $lastDayOfMonth = $dateFrom->copy()->endOfMonth();
        $totalWorkingDayCounts = 0;

        for ($currentDay = $firstDayOfMonth; $currentDay->lte($lastDayOfMonth); $currentDay->addDay()) {
            if ($currentDay->isWeekday()) {
                $totalWorkingDayCounts++;
            }
        }

        if ($totalWorkingDayCounts > 0) {
            return ($employee->rate_type === 'monthly') ? ($employee->rate / $totalWorkingDayCounts) : $employee->rate;
        }

        return 0;
    }


    private function calculateTotalPayslip($totalReportDays, $employeeDailyRate)
    {
        return $employeeDailyRate * $totalReportDays;
    }

    private function calculateTotalDeductions($deductionEmployees)
    {
        return $deductionEmployees->sum('amount');
    }

    private function storeDeductionHistory($employeeId, $deductionEmployees, $payslipId)
    {
        foreach ($deductionEmployees as $deductionEmployee) {
            DeductionHistory::create([
                'employee_id' => $employeeId,
                'deduction_id' => $deductionEmployee->deduction_id,
                'payslip_id' => $payslipId,
                'amount' => $deductionEmployee->amount,
                'month' => now()->firstOfMonth(),
                'note' => $deductionEmployee->note,
            ]);
        }
    }
}
