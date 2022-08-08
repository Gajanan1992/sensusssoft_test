@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header d-flex justify-content-between">
                        <h5>User Loan details</h5>
                        {{-- <a href="{{ route('apply-loan') }}" class="btn btn-primary ">Loan Application</a> --}}
                    </div>

                    <div class="card-body">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>User Name</th>
                                    <th>Loan Amount</th>
                                    <th>Loan Duration</th>
                                    <th>Amount Paid</th>
                                    <th>Loan Status</th>
                                    <th>Loan Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($users as $user)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td><a href="/loan-details/{{ $user->id }}"> {{ $user->name }}</a></td>
                                        <td>{{ $user->loan?->amount ?? '--' }}</td>
                                        <td>{{ $user->loan?->duration ?? '--' }}</td>
                                        <td>{{ $user->loan?->loanTransactions?->sum('amount') ?? '--' }}</td>
                                        <td>{{ $user->loan?->isActive ? 'Active' : 'Inactive' }}</td>
                                        <td>{{ $user->loan?->start_date }}</td>
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
