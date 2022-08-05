<?php

namespace App\Library;

use App\Models\Loan;

class LoanCalculator implements LoanCalculatorInterface
{
    private $loanAmount;
    public Loan $loanmodel;

    public function calculateLoanAmount(Loan $loan)
    {
        $this->loanmodel = $loan;
        $interestRate = $loan->interest_rate / 100;
        $dailyRate = $interestRate / 365;
        $dailyInterestAmount = $loan->amount * $dailyRate;
        $totalInterestAmount = $dailyInterestAmount * $loan->duration;
        $totalLoanAmount = $loan->amount + $totalInterestAmount;
        $this->loanAmount = $totalLoanAmount / $loan->duration;
        //amount in two decimal places
        return $this;
    }

    public function getPaymentDetails()
    {
        $checkIfPaid = $this->checkIfPaid();
        // dd($checkIfPaid);
        $overdue = $this->checkOverDue();

        return [
            'due_date' => now(),
            'amount' => $this->loanAmount,
            'due_amount' => $overdue,
            'status' => $checkIfPaid ? 'paid' : 'unpaid',
        ];
    }

    // public function getLoanEmi()
    // {
    //     return $this->loanAmount;
    // }

    public function checkOverdue()
    {

        $lastLoanTransaction = $this->loanmodel->loanTransactions()->orderBy('date', 'desc')->first();
        if ($lastLoanTransaction) {
            if ($lastLoanTransaction->date->diffInDays(now()) > 0) {
                return ($this->loanAmount * 1) / 100;
            } else {
                return 0;
            }
        }
        return 0;
    }

    public function checkIfPaid()
    {
        $lastLoanTransaction = $this->loanmodel->loanTransactions()->orderBy('date', 'desc')->first();
        if ($lastLoanTransaction) {
            if ($lastLoanTransaction->date->diffInDays(now()) == 0) {
                return true;
            } else {
                return false;
            }
        }
        return false;
    }
}
