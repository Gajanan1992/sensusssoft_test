<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Library\LoanCalculatorInterface;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $users =  \App\Models\User::factory(10)->create();

        foreach ($users as $user) {
            $loan = \App\Models\Loan::factory()->for($user)->create([
                'amount' => rand(100, 1000000),
                'interest_rate' => config('loan.interest_rate'),
                'duration' => 30,
                'start_date' => now(),
                'end_date' => now()->addDays(30),
                'isActive' => true,
                'purpose' => 'Loan for personel use',
            ]);

            // each loan have five loan transactions
            // $loanAnount = $this->getLoanAmount($loan);

            // for ($i = 0; $i < $loan->duration; $i++) {
            //     // get last loan transaction
            //     $lastLoanTransaction = $loan->loanTransactions()->orderBy('date', 'desc')->first();
            //     $date = $lastLoanTransaction ?  $lastLoanTransaction->date->addDays(1) : Carbon::parse($loan->start_date)->addDays(1);

            //     $loan->loanTransactions()->create([
            //         'date' => $date,
            //         'transaction_type' => 'payment',
            //         'amount' => $loanAnount,
            //         'payment_method' => 'bank',
            //     ]);
            // }
        }
        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
    }

    private function getLoanAmount($loan)
    {
        $interestRate = $loan->interest_rate / 100;
        $dailyRate = $interestRate / 365;
        $dailyInterestAmount = $loan->amount * $dailyRate;
        $totalInterestAmount = $dailyInterestAmount * $loan->duration;
        $totalLoanAmount = $loan->amount + $totalInterestAmount;
        $dailyAmountToPay = $totalLoanAmount / $loan->duration;
        return $dailyAmountToPay;
    }
}
