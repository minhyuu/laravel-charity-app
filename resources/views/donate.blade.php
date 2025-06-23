@extends('layouts.app')

@section('content')

<!-- banner -->
<div class="banner text-center">
    <div class="container">
        <h1>Make a Donation</h1>
    </div>
</div>

<div class="donate-page">
    <div class="container">
        <h2 class="text-center">Your Donation Is Changing Lives</h2>

        <!-- Project information -->
        <div class="row justify-content-center mt-4">
            <div class="col-md-8">
                <!-- Project name -->
                <div class="form-row">
                    <div class="form-group col-md-4 mb-0">
                        <strong>Project Name: </strong>
                    </div>
                    <div class="form-group col-md-6 mb-0">
                        <p>{{$project->name}}</p>
                    </div>
                </div>

                <!-- Project category -->
                <div class="form-row">
                    <div class="form-group col-md-4 mb-0">
                        <strong>Project Category: </strong>
                    </div>
                    <div class="form-group col-md-6 mb-0">
                        <p>{{$project->category}}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Donation details -->
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card mt-3">

                    <!-- Card header -->
                    <div class="card-header">
                        <h4 class="mb-0">Credit Card</h4>
                    </div>

                    <!-- Card body -->
                    <div class="card-body">
                        <!-- Forms go here -->
                        <form action="{{ secure_url('/create_donate', $project->id) }}" method="POST">
                            @csrf

                            <!-- Card Holder's Name -->
                            <div class="row mb-3">
                                <label for="name" class="col-md-4 col-form-label text-md-end">Card Holder's Name</label>
                                <div class="col-md-6">
                                    <input id="name" type="text"
                                        class="form-control @error('name') is-invalid @enderror" name="name"
                                        pattern="[A-Za-z\s]+"
                                        title="Card Holder's Name should only contain letters and spaces." required>
                                </div>
                            </div>

                            @error('name')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror

                            <!-- Card number -->
                            <div class="row mb-3">
                                <label for="CardNumber" class="col-md-4 col-form-label text-md-end">Card Number</label>
                                <div class="col-md-6">
                                    <input id="CardNumber" type="text"
                                        class="form-control @error('CardNumber') is-invalid @enderror" name="CardNumber"
                                        required pattern="[0-9]+"
                                        title="Card number should only contain numbers.">
                                </div>
                            </div>

                            @error('CardNumber')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror

                            <!-- Card Expiry Date -->
                            <div class="row mb-3">
                                <label for="cardexpire" class="col-md-4 col-form-label text-md-end">Card Expiry
                                    Date</label>
                                <div class="col-md-6">
                                    <input id="cardexpire" type="text"
                                        class="form-control @error('cardexpire') is-invalid @enderror" name="cardexpire"
                                        placeholder="MM/YY" required pattern="^(0[1-9]|1[0-2])\/\d{2}$"
                                        title="Card Expiry Date should be in MM/YY format">
                                </div>
                            </div>

                            @error('cardexpire')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror

                            <!-- Card CVV -->
                            <div class="row mb-3">
                                <label for="cardcvv" class="col-md-4 col-form-label text-md-end">CVV</label>
                                <div class="col-md-6">
                                    <input id="cardcvv" type="text"
                                        class="form-control @error('cardcvv') is-invalid @enderror" name="cardcvv"
                                        required pattern="\d{3}"
                                        title="Card CVV should only contain 3 numbers">
                                </div>
                            </div>

                            @error('cardcvv')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror

                            <!-- Donation Amount -->
                            <div class="row mb-3">
                                <label for="amount" class="col-md-4 col-form-label text-md-end">Donation Amount</label>
                                <div class="col-md-6">
                                    <input id="amount" type="text"
                                        class="form-control @error('cardexpire') is-invalid @enderror" name="amount"
                                        placeholder="$" required pattern="[0-9]+">
                                </div>
                            </div>

                            @error('amount')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror

                            <!-- Form buttons -->
                            <div class="row mb-0">
                                <div class="col-md-8 offset-md-4">
                                    <button type="submit" class="btn btn-primary">Donate</button>
                                    <a href="{{ route('charity_list') }}" class="btn btn-secondary">Cancel</a>
                                </div>
                            </div>
                        </form>
                    </div>

                </div>
            </div>
        </div>

    </div>
</div>

@endsection