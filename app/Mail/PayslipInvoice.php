<?php
// SalaryInvoice.php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class PayslipInvoice extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public $employee;
    public $payslip;
    public $attendances;
    public $totalSalary;
    public $totalDeductions;
    public $netSalary;
    public $totalWorkingDays;
    public $employeeDailyRate;
    public $deductionEmployees;
    public $totalReportDays;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($employee, $attendances, $totalSalary, $totalDeductions, $netSalary, $totalWorkingDays, $employeeDailyRate, $deductionEmployees, $totalReportDays, $payslip)
    {
        $this->employee = $employee;
        $this->payslip = $payslip;
        $this->attendances = $attendances;
        $this->totalSalary = $totalSalary;
        $this->totalDeductions = $totalDeductions;
        $this->netSalary = $netSalary;
        $this->totalWorkingDays = $totalWorkingDays;
        $this->employeeDailyRate = $employeeDailyRate;
        $this->deductionEmployees = $deductionEmployees;
        $this->totalReportDays = $totalReportDays;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('emails.salary-invoice')
                    ->subject('Employee Salary Invoice')
                    ->to($this->employee->email)
                    ->cc('johnwealth@mail.com')
                    ->bcc('john@example.com')
                    ->with([
                        'employee' => $this->employee,
                        'employee' => $this->payslip,
                        'attendances' => $this->attendances,
                        'totalSalary' => $this->totalSalary,
                        'totalDeductions' => $this->totalDeductions,
                        'netSalary' => $this->netSalary,
                        'totalWorkingDays' => $this->totalWorkingDays,
                        'employeeDailyRate' => $this->employeeDailyRate,
                        'deductionEmployees' => $this->deductionEmployees,
                        'totalReportDays' => $this->totalReportDays,
                    ]);

    }
}
