<?php

namespace App\Http\Controllers;

use App\Library\LoanCalculatorInterface;
use App\Models\Loan;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LoanController extends Controller
{
    public function __construct(LoanCalculatorInterface $loanCalculator)
    {
        $this->loanCalculator = $loanCalculator;
    }

    public function loanDetails(User $user)
    {
        $user = User::with(['loan.loanTransactions'])->where('id', $user->id)->first();

        $loanPaymentDetails = $this->loanCalculator->calculateLoanAmount($user->loan)->getPaymentDetails();

        return view('loan.loan-details', compact('user', 'loanPaymentDetails'));
    }

    public function pay(Loan $loan)
    {
        try {
            DB::beginTransaction();

            $loanPaymentDetails = $this->loanCalculator->calculateLoanAmount($loan)->getPaymentDetails();
            // dd($loanPaymentDetails);
            $loan->loanTransactions()->create([
                'date' => $loanPaymentDetails->due_date,
                'transaction_type' => 'payment',
                'amount' => $loanPaymentDetails->amount,
                'payment_method' => 'bank',
            ]);

            if ($loanPaymentDetails->due_amount > 0) {
                // dd($loanPaymentDetails);
                $loan->loanTransactions()->create([
                    'date' => $loanPaymentDetails->due_date,
                    'transaction_type' => 'charge',
                    'amount' => $loanPaymentDetails->due_amount,
                    'payment_method' => 'bank',
                ]);
            }

            DB::commit();
            return back();
        } catch (\Exception $ex) {
            dd($ex);
            DB::rollback();
            return back()->withErrors(['error' => $ex->getMessage()]);
        }
    }
}
