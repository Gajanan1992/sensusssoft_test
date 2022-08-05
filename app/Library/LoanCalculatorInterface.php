<?php

namespace App\Library;

use App\Models\Loan;

interface LoanCalculatorInterface
{
    public function calculateLoanAmount(Loan $loan);
}
