<?php

namespace App\Library;

use App\Models\Loan;
use App\Models\LoanTransaction;

class LoanCalculator implements LoanCalculatorInterface
{
    private $loanAmount;
    public Loan $loanmodel;
    private $hasAnyRecentTransaction;
    private $dueAmount = 0;
    private $loanStatus = 'active';
    private $dueStatus = 'unpaid';

    public function calculateLoanAmount(Loan $loan)
    {
        $this->loanmodel = $loan;

        $this->checkHasAnyRecentTransaction();

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
        if ($this->hasAnyRecentTransaction) {
            $this->checkHasAnyDue();
            $this->getDueAmount();
            $this->checkIfLoanExpired();
        }

        return (object) [
            'due_date' => now(),
            'amount' => $this->loanAmount,
            'due_amount' => $this->dueAmount,
            'due_status' => $this->dueStatus,
            'loan_status' => $this->loanStatus,
        ];
    }

    public function getDueAmount()
    {
        $lastLoanTransaction = $this->getLastLoanTransaction();

        if ($lastLoanTransaction->date->diffInDays(now()) > 1) {
            return $this->dueAmount =  ($this->loanAmount * 1) / 100;
        }
    }

    public function checkHasAnyDue()
    {
        $lastLoanTransaction = $this->getLastLoanTransaction();

        if ($lastLoanTransaction->date->diffInDays(now()) == 0) {
            return $this->dueStatus = 'paid';
        }
    }

    public function checkIfLoanExpired()
    {
        $lastLoanTransaction = $this->getLastLoanTransaction();

        if ($this->loanmodel->end_date >= now()) {
            return $this->loanStatus = 'active';
        } else {

            return $this->loanStatus = 'expired';
        }
    }

    public function getLastLoanTransaction()
    {
        return $this->loanmodel
            ->loanTransactions()
            ->where('transaction_type', 'payment')
            ->orderBy('date', 'desc')
            ->first();
    }

    public function checkHasAnyRecentTransaction()
    {
        $lastLoanTransaction = $this->getLastLoanTransaction();
        $this->hasAnyRecentTransaction = $lastLoanTransaction ? true : false;
        return $this;
    }
}
