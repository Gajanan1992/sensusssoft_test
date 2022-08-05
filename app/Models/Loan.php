<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Loan extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'amount',
        'interest_rate',
        'term',
        'start_date',
        'end_date',
        'isActive',
        'purpose',
    ];

    protected $casts = [
        'isActive' => 'boolean',
        'start_date' => 'datetime',
        'end_date' => 'datetime',
    ];
    // belongs to user

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // has many loan transactions

    public function loanTransactions()
    {
        return $this->hasMany(LoanTransaction::class);
    }
}
