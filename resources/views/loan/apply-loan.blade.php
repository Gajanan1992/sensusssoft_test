@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header d-flex justify-content-between">
                        <h5> Loan Application</h5>
                    </div>

                    <div class="card-body">
                        <form action="{{ route('approve-loan') }}" method="POST">
                            @csrf

                            <div class="form-group">
                                <label for="amount">Amount</label>
                                <input type="number" class="form-control" id="amount" name="amount"
                                    placeholder="Enter amount">
                            </div>
                            <div class="form-group">
                                <label for="duration">Duration</label>
                                <input type="number" class="form-control" id="duration" name="duration"
                                    placeholder="Enter duration">
                            </div>
                            <div class="form-group">
                                <label for="interest">Interest</label>
                                <input type="number" class="form-control" id="interest" name="interest"
                                    placeholder="Enter interest">
                            </div>
                            <div class="form-group">
                                <label for="purpose">Purpose</label>
                                <input type="text" class="form-control" id="purpose" name="purpose"
                                    placeholder="Enter purpose">
                            </div>
                            <button type="submit" class=" mt-4 btn btn-primary">Submit</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
