@extends('layouts.app')

@section('content')

<!-- banner -->
<div class="banner text-center">
    <div class="container">
        <h1>Admin Dashboard</h1>
    </div>
</div>

<!-- Headline -->
<div class="container mt-5 mb-5">
	<div class="container">
    	<h2 class="text-center">Project Administrator</h2>


		<!-- Filter menu -->
		<div id= "myBtnContainer">
    		<button class="btn btn-secondary mb-2" onclick="filter_all()">Show all</button>
    		<button class="btn btn-secondary mb-2" onclick="filter_ongoing()">Ongoing</button>
    		<button class="btn btn-secondary mb-2" onclick="filter_completed()">Completed</button>
    	</div>

		<!-- Project Administrator List Table -->
		<div class="charity-table table-responsive">
    		<table id="project_admin_table" class="mt-3 table table-hover table-bordered">
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

        		@foreach ($projects as $project)
				@if($project->category == Auth::User()->category)
				<tbody class="table-group-divider">
            		<tr>
                		<td>{{$project->id}}</td>
                		<td>{{$project->name}}</td>
                		<td>{{$project->category}}</td>
                		<td>{{$project->description}}</td>
						<td>{{$project->status}}</td>
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
            		</tr>
				</tbody>
				@endif
				@endforeach
    		</table>
		</div>
	</div>
</div>

@endsection



