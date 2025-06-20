@extends('layouts.app')

@section('content')

<!-- banner -->
<div class="banner text-center">
    <div class="container">
        <h1>Dashboard</h1>
    </div>
</div>

<div class="registered-user">



    <!-- Tabs Navigation -->
    <div class="container">
        <!-- Messasge -->
        @if(session()->has('message'))
        <div class="alert alert-success text-center">
            {{ session()->get('message') }}
        </div>
        @endif
        <ul class="nav nav-tabs" id="myTab" role="tablist">

            <li class="nav-item" role="presentation">
                <a class="nav-link active" id="donation-history-tab" data-bs-toggle="tab" href="#donation-history"
                    role="tab" aria-controls="donation-history" aria-selected="true">Donation History</a>
            </li>

            <li class="nav-item" role="presentation">
                <a class="nav-link" id="charity-project-tab" data-bs-toggle="tab" href="#charity-project" role="tab"
                    aria-controls="charity-project" aria-selected="false">Ongoing Projects</a>
            </li>
        </ul>

        <div class="tab-content" id="myTabContent">

            <!-- Donation History Table -->
            <div class="tab-pane fade show active" id="donation-history" role="tabpanel"
                aria-labelledby="donation-history-tab">
                <h3 class="text-center mb-3">Donation History</h3>
                <table id="donation_history_table" class="table table-hover table-bordered table-responsive">

                    <thead class="table-success">
                        <tr>
                            <th scope="col">ID</th>
                            <th scope="col">Name</th>
                            <th scope="col">Category</th>
                            <th scope="col">Description</th>
                            <th scope="col">Progress</th>
                            <th scope="col">Donation amount</th>
                            <th scope="col">Donate at</th>
                        </tr>
                    </thead>

                    <tbody class="table-group-divider">
                        @foreach ($donations as $donation)
                        <tr>
                            <td>{{  $donation->project->id }}</td>
                            <td>{{  $donation->project->name }}</td>
                            <td>{{  $donation->project->category }}</td>
                            <td>{{  $donation->project->description }}</td>
                            <td>
                                <div class="progress w-75" role="progressbar"
                                    aria-valuenow="{{ ($donation->project->collected_amount / $donation->project->goal_amount) * 100 }}"
                                    aria-valuemin="0" aria-valuemax="100">
                                    <div class="progress-bar bg-success"
                                        style="width: {{ ($donation->project->collected_amount / $donation->project->goal_amount) * 100 }}%">
                                        {{ round(($donation->project->collected_amount / $donation->project->goal_amount) * 100, 2) }}%
                                    </div>
                                </div>
                            </td>
                            <td>${{ $donation->amount }}</td>
                            <td>{{ $donation->created_at }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Charity Project Table -->
            <div class="tab-pane fade" id="charity-project" role="tabpanel" aria-labelledby="charity-project-tab">
                <h3 class="text-center mb-3">Ongoing Projects</h3>
                <table id="charity_project_table" class="table table-hover table-bordered table-responsive">
                    <thead class="table-success">
                        <tr>
                            <th scope="col">ID</th>
                            <th scope="col">Name</th>
                            <th scope="col">Category</th>
                            <th scope="col">Description</th>
                            <th scope="col">Status</th>
                            <th scope="col">Goal Amount</th>
                            <th scope="col">Progress</th>
                        </tr>
                    </thead>
                    <tbody class="table-group-divider">
                        @foreach ($donations as $donation)
                        @if ($donation->project->status == 'ongoing')
                        <tr>
                            <td>{{ $donation->project->id }}</td>
                            <td>{{ $donation->project->name }}</td>
                            <td>{{ $donation->project->category }}</td>
                            <td>{{ $donation->project->description }}</td>
                            <td>{{ $donation->project->status }}</td>
                            <td>${{ $donation->project->goal_amount }}</td>
                            <td>
                                <div class="progress w-75" role="progressbar"
                                    aria-valuenow="{{ ($donation->project->collected_amount / $donation->project->goal_amount) * 100 }}"
                                    aria-valuemin="0" aria-valuemax="100">
                                    <div class="progress-bar bg-success"
                                        style="width: {{ ($donation->project->collected_amount / $donation->project->goal_amount) * 100 }}%">
                                        {{ round(($donation->project->collected_amount / $donation->project->goal_amount) * 100, 2) }}%
                                    </div>
                                </div>
                            </td>
                        </tr>
                        @endif
                        @endforeach
                    </tbody>
                </table>
            </div>

        </div>
    </div>
</div>
<!--/.registered-user -->

@endsection