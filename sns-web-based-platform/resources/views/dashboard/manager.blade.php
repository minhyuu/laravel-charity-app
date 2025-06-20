@extends('layouts.app')

@section('content')

<div class="banner text-center">
    <div class="container">
        <h1>System Manager Dashboard</h1>
    </div>
</div>

<div class="dashboard">
    <div class="container">
        <!-- User Summary -->
        <div class="card mb-3">
            <div class="card-header">
                <h4 class="mb-0 text-center">User Summary</h4>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-12 col-lg-6 mb-3 mb-lg-0 text-center">
                        <div class="h5">Registered Donators</div>
                        <div class="display-4">{{ $donatorCount }}</div>
                    </div>
                    <div class="col-12 col-lg-6 mb-3 mb-lg-0 text-center">
                        <div class="h5">Project Administrators</div>
                        <div class="display-4">{{ $administratorCount }}</div>
                    </div>
                </div>
            </div>
        </div>
        <!--/.card -->

        <!-- Charity Project Summary -->
        <div class="card mb-3">
            <div class="card-header">
                <h4 class="mb-0 text-center">Charity Project Summary</h4>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-12 col-lg-6 mb-3 mb-lg-0 text-center">
                        <div class="h5">Completed Projects</div>
                        <div class="display-4">{{ $completedCount }}</div>
                    </div>
                    <div class="col-12 col-lg-6 mb-3 mb-lg-0 text-center">
                        <div class="h5">Ongoing Projects</div>
                        <div class="display-4">{{ $ongoingCount }}</div>
                    </div>
                </div>
            </div>
        </div>
        <!--/.card -->
    </div>
</div>
<!--/.dashboard -->
@endsection