@extends('layouts.app')

@section('content')

<!-- banner -->
<div class="banner text-center">
    <div class="container">
        <h1>Charity List</h1>
    </div>
</div>

<!-- Headline -->
<div class="charity-list-page">
    <div class="container">
        <h2 class="text-center mb-3">Charity List</h2>

        <!-- Search Function -->
        <div class="search-filter">
            <form action="{{ route('charity_list') }}" method="GET" class="row g-3">
                <!-- Search bar -->
                <div class="col-lg-6 col-12">
                    <input type="text" name="search" class="form-control" id="search" placeholder="Search for project.."
                        title="Type in a name" value="{{ request('search') }}">
                </div>
                <!-- choose category -->
                <div class="col-lg-6 col-12 my-3 my-lg-0">
                    <div class="filter">
                        <div class="filter-options">
                            <label for="category" class="form-label d-none">Category</label>
                            <select id="category" name="category" class="form-select">
                                <option value="">Show all</option>
                                <option value="Health" {{ request('category') == 'Health' ? 'selected' : '' }}>Health
                                </option>
                                <option value="Environment"
                                    {{ request('category') == 'Environment' ? 'selected' : '' }}>
                                    Environment</option>
                                <option value="Education" {{ request('category') == 'Education' ? 'selected' : '' }}>
                                    Education
                                </option>
                            </select>
                        </div>
                        <!--/.filter-options -->

                        <div class="filter-btn">
                            <button type="submit" class="btn btn-success h-100 w-100">Filter</button>
                        </div>
                        <!--/.filter-button- -->
                    </div>
                </div>
                <!-- Filter button -->
            </form>
        </div>

        <!-- Charity List Table -->
        <div class="charity-table table-responsive mt-2 mt-lg-4">
            <table id="charity_list_table" class="table table-hover table-bordered">
                <thead class="table-success">
                    <tr>
                        <th scope="col">ID</th>
                        <th scope="col">Name</th>
                        <th scope="col">Category</th>
                        <th scope="col">Description</th>
                        <th scope="col">Goal Amount</th>
                        <th scope="col">Progress</th>
                        <th scope="col">Donate</th>
                    </tr>
                </thead>

                @foreach ($projects as $project)
                <tbody class="table-group-divider">
                    <tr>
                        <td>{{$project->id}}</td>
                        <td>{{$project->name}}</td>
                        <td>{{$project->category}}</td>
                        <td>{{$project->description}}</td>
                        <td>${{$project->goal_amount}}</td>
                        <td>
                            <div class="progress w-75" role="progressbar"
                                aria-valuenow="{{ ($project->collected_amount / $project->goal_amount) * 100 }}"
                                aria-valuemin="0" aria-valuemax="100">
                                <div class="progress-bar bg-success"
                                    style="width: {{ ($project->collected_amount / $project->goal_amount) * 100 }}%">
                                    {{ round(($project->collected_amount / $project->goal_amount) * 100, 2) }}%
                                </div>
                            </div>
                        </td>
                        <td>
                            <button type="button" class="btn btn-primary col-auto"
                                onclick="window.location='{{ route('donate', $project->id) }}'">
                                Donate
                            </button>
                        </td>
                    </tr>
                </tbody>
                @endforeach

            </table>
        </div>
    </div>
</div>
<!--/.charity-list -->

@endsection