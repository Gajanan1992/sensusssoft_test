<?php

namespace App\Http\Controllers;

use App\Library\LoanCalculatorInterface;
use App\Models\Loan;
use App\Models\User;
use Illuminate\Http\Request;

class LoanController extends Controller
{
    public function __construct(LoanCalculatorInterface $loanCalculator)
    {
        $this->loanCalculator = $loanCalculator;
    }

    public function applyLoan()
    {
        return view('loan.apply-loan');
    }

    public function loanDetails(User $user)
    {
        $user = User::with(['loan.loanTransactions'])->where('id', $user->id)->first();


        $loanPaymentDetails = $this->loanCalculator->calculateLoanAmount($user->loan)->getPaymentDetails();

        // dd($amountTobePaid);

        // $paymentDetails = $users->loan->loanTransactions;
        return view('loan.loan-details', compact('user', 'loanPaymentDetails'));
    }

    public function pay(Loan $loan)
    {
        $loanPaymentDetails = $this->loanCalculator->calculateLoanAmount($loan)->getPaymentDetails();
        // dd($loanPaymentDetails);

        $loan->loanTransactions()->create([
            'date' => $loanPaymentDetails['due_date'],
            'transaction_type' => 'payment',
            'amount' => $loanPaymentDetails['amount'],
            'payment_method' => 'bank',
        ]);

        if ($loanPaymentDetails['due_amount'] != 0) {
            $loan->loanTransactions()->create([
                'date' => $loanPaymentDetails['date'],
                'transaction_type' => 'charge',
                'amount' => $loanPaymentDetails['due_amount'],
                'payment_method' => 'bank',
            ]);
        }
        return back();
    }
}
