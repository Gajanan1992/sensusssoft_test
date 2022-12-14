<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LoanTransaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'loan_id',
        'date',
        'transaction_type',
        'amount',
        'payment_method',
    ];

    protected $casts = [
        'date' => 'datetime',
    ];
}
