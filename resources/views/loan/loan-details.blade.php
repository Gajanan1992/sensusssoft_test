@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header d-flex justify-content-between">
                        <h5> Welcome {{ $user->name }}</h5>
                    </div>

                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <h5>Loan Amount : {{ $user->loan->amount }}</h5>
                            <h5>Amount Paid: {{ $user->loan->loanTransactions->sum('amount') ?? '--' }}</h5>

                        </div>

                        <div class="d-flex justify-content-between">
                            <h5>Loan start date : {{ $user->loan->start_date->format('d M Y') }}</h5>
                            <h5>Loan end date: {{ $user->loan->end_date->format('d M Y') ?? '--' }}</h5>

                        </div>
                        <div class="d-flex justify-content-between">
                            <h5>Loan Duration : {{ $user->loan->duration }}</h5>
                            <h5>Loan interest Rate: {{ $user->loan->interest_rate ?? '--' }} %</h5>

                        </div>
                        <hr>
                        <h3>Payment Details</h3>
                        <hr>
                        @if ($loanPaymentDetails['status'] == 'unpaid')
                            <h5>Amount : {{ number_format($loanPaymentDetails['amount'], 2) }}</h5>
                            <h5>Due Date : {{ $loanPaymentDetails['due_date'] }}</h5>
                            <h5>Due Charge: {{ number_format($loanPaymentDetails['due_amount'], 2) ?? '--' }} </h5>

                            <a href="/pay/{{ $user->loan->id }}" class="btn btn-primary">Pay</a>
                        @else
                            <h5>Todays EMI Paid</h5>
                        @endif
                        <hr>
                        <h3>Transactions details</h3>
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Date</th>
                                    <th>Amount</th>
                                    <th>Payment Method</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($user->loan->loanTransactions as $transaction)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $transaction->date->format('d M Y') ?? '--' }}</td>
                                        <td>{{ $transaction->amount ?? '--' }}</td>
                                        <td>{{ $transaction->payment_method ?? '--' }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
