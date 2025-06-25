@extends('layouts.app')

@section('content')

<!-- banner -->
<div class="banner text-center">
    <div class="container">
        @if (isset(Auth::user()->id) && Auth::user()->role == "Manager")
        <h1>System Management</h1>
        @else
        <h1>Administrator</h1>
        @endif
    </div>
</div>

<!-- Page content -->
<div class="master-page">
    <div class="container content">

        <!-- Alert -->
        @if (session('success'))
        <div class="alert alert-success" id="flash-message">
            {{ session('success') }}
        </div>
        @endif

        <!-- New Project -->
        @if (isset(Auth::user()->id) && Auth::user()->role == 'Administrator')
        <div class="new-project mb-4">
            <button type="button" class="btn btn-primary"
                style="--bs-btn-padding-y: .4rem; --bs-btn-padding-x: 1.25rem; --bs-btn-font-size: 1rem;"
                onclick="window.location='{{ URL::route('create') }}'">Create new project</button>
        </div>
        @endif

        <!-- Search Function -->
        <div class="search-filter">
            <form action="{{ secure_url('/manage') }}" method="GET" class="row g-3">
                <div class="col-lg-4 col-12">
                    <input type="text" name="search" class="form-control" id="search" placeholder="Search for project.."
                        title="Type in a name" value="{{ request('search') }}">
                </div>
                <div class="col-lg-3 col-6 my-3 my-lg-0">
                    <label for="category" class="form-label d-none">Category</label>
                    <select id="category" name="category" class="form-select">
                        <option value="">Choose category</option>
                        <option value="Health" {{ request('category') == 'Health' ? 'selected' : '' }}>Health</option>
                        <option value="Environment" {{ request('category') == 'Environment' ? 'selected' : '' }}>
                            Environment</option>
                        <option value="Education" {{ request('category') == 'Education' ? 'selected' : '' }}>Education
                        </option>
                    </select>
                </div>
                <div class="col-lg-3 col-6 my-3 my-lg-0">
                    <label for="status" class="form-label d-none">Status</label>
                    <select id="status" name="status" class="form-select">
                        <option value="">Choose status</option>
                        <option value="ongoing" {{ request('status') == 'ongoing' ? 'selected' : '' }}>Ongoing</option>
                        <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Completed
                        </option>
                    </select>
                </div>
                <div class="col-lg-2 col-12 filter">
                    <button type="submit" class="btn btn-success h-100 w-100">Filter</button>
                </div>
            </form>
        </div>

        <!-- Charity List -->
        <div class="project-table table-responsive" id="charity-list" style="margin-top: 2rem;">
            <table class="table table-hover mb-0">
                <!-- Table head -->
                <thead>
                    <tr>
                        <th scope="col">ID</th>
                        <th scope="col">Charity Project</th>
                        <th scope="col">Category</th>
                        <th scope="col">Target</th>
                        <th scope="col">Progress</th>
                        <th scope="col">Status</th>
                        <th scope="col">Action</th>
                    </tr>
                </thead>
                <!-- Table body -->
                <tbody class="table-group-divider">
                    @foreach ($projects as $project)
                    <tr>
                        <!-- ID -->
                        <th scope="row">{{ $project->id }}</th>

                        <!-- Charity Project -->
                        <td>
                            <a href="#" data-toggle="modal"
                                data-target="#donationModal-{{ $project->id }}">{{ $project->name }}</a>
                        </td>

                        <!-- Category -->
                        <td>{{ $project->category }}</td>

                        <!-- Target -->
                        <td>{{ number_format($project->goal_amount, 0) }}</td>

                        <!-- Progress -->
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

                        <!-- Status -->
                        <td>{{ $project->status == 'ongoing' ? "Ongoing" : 'Completed' }}</td>

                        <!-- Action -->
                        <td>
                            <div class="action-btn">
                                <!-- Edit button -->
                                @if ($project->status == 'ongoing')
                                <button type="button" class="btn btn-primary col-auto"
                                    onclick="window.location='{{ secure_url('/edit', $project->id) }}'">Edit</button>
                                @endif

                                <!-- Delete button -->
                                <form action="{{ secure_url('/deleteAndReset', $project->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    @if ($project->status == 'ongoing' &&
                                        $project->collected_amount != 0 &&
                                        isset(Auth::user()->id) && Auth::user()->role == 'Manager')
                                        <button type="button" class="btn btn-danger" data-toggle="modal"
                                            data-target="#deleteModal-{{ $project->id }}">Delete</button>
                                    @else
                                        @if ($project->collected_amount == 0)
                                            <button type="submit" class="btn btn-danger">Delete</button>
                                        @else
                                            <button type="button" class="btn btn-danger no-permission" disabled>Delete</button>
                                        @endif
                                    @endif
                                </form>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <!-- Existing modals for each project -->
    @foreach ($projects as $project)
    <div class="modal fade" id="donationModal-{{ $project->id }}" tabindex="-1" role="dialog"
        aria-labelledby="donationModalLabel-{{ $project->id }}" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="donationModalLabel-{{ $project->id }}">Project Details</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <h3 class="mb-3">
                        {{ $project->name }}</h3>
                    <div>
                        <p class="label-value-pair"><strong class="emphasized-text"
                                style="color: green;">Category:</strong>{{ $project->category }}</p>
                        <p class="label-value-pair"><strong class="emphasized-text" style="color: green;">Goal
                                Amount:</strong>${{ number_format($project->goal_amount, 0) }}</p>
                        <p class="label-value-pair"><strong class="emphasized-text" style="color: green;">Collected
                                Amount:</strong>${{ number_format($project->collected_amount, 0) }}</p>
                        <p class="label-value-pair"><strong class="emphasized-text"
                                style="color: green;">Status:</strong>{{ $project->status == 'ongoing' ? 'Ongoing' : ($project->status == 'completed' ? 'Completed' : '') }}
                        </p>
                    </div>
                    <div class="description mt-3">
                        <p><strong class="emphasized-text d-block mb-1" style="color: green;">Description:</strong>
                            {{ $project->description }}</p>
                    </div>
                    <!--/.description -->
                    <div class="donor-details">
                        <p><strong class="emphasized-text" style="color: green;">Donation Details</strong></p>
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Donor</th>
                                    <th>Amount</th>
                                    <th>Date of Donation</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($donations->where('project_id', $project->id) as $donation)
                                <tr>
                                    <td>{{ optional($donation->user)->name ?? 'Unknown' }}</td>
                                    <td>${{ number_format($donation->amount, 0) }}</td>
                                    <td>{{ $donation->created_at->format('d-m-Y') }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <!--/.donor-details -->
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
    @endforeach


    <!-- Modal for Showing Project Details and Confirming Deletion -->
    @foreach ($projects as $project)
    <div class="modal fade" id="deleteModal-{{ $project->id }}" tabindex="-1" role="dialog"
        aria-labelledby="deleteModalLabel-{{ $project->id }}" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteModalLabel-{{ $project->id }}">Project Details</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="alert-danger alert">
                        <span>The project will be deleted permanently. All the donation will be refunded to the donors.<br>Are you sure you want to delete it?</span>
                    </div>
                    <h3>{{ $project->name }}</h3>
                    <div>
                        <p class="label-value-pair"><strong class="emphasized-text"
                                style="color: green;">Category:</strong>{{ $project->category }}</p>
                        <p class="label-value-pair"><strong class="emphasized-text" style="color: green;">Goal
                                Amount:</strong>${{ number_format($project->goal_amount, 0) }}</p>
                        <p class="label-value-pair"><strong class="emphasized-text" style="color: green;">Collected
                                Amount:</strong>${{ number_format($project->collected_amount, 0) }}</p>
                        <p class="label-value-pair"><strong class="emphasized-text"
                                style="color: green;">Status:</strong>{{ $project->status == 'ongoing' ? 'Ongoing' : 'Completed' }}
                        </p>
                    </div>
                    <div class="description mt-3">
                        <p><strong class="emphasized-text d-block mb-1"
                                style="color: green;">Description:</strong>{{ $project->description }}</p>
                    </div>
                    <div class="donation mt-3">
                        <p><strong class="emphasized-text" style="color: green;">Donation Details:</strong></p>
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Date</th>
                                    <th>Receiver</th>
                                    <th>Date of Donation</th>
                                    <th>Amount</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($donations->where('project_id', $project->id) as $donation)
                                <tr>
                                    <td>{{ $donation->created_at->format('d-m-Y') }}</td>
                                    <td>{{ optional($donation->user)->name ?? 'Unknown' }}</td>
                                    <td>{{ $donation->created_at->format('d-m-Y') }}</td>
                                    <td style="color: red;">${{ number_format($donation->amount, 0) }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="modal-footer">
                    <form action="{{ secure_url('/deleteAndReset', $project->id) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">Delete</button>
                    </form>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal"
                        onclick="window.location.href='{{ secure_url('/manage') }}'">Close</button>
                </div>
            </div>
        </div>
    </div>
    @endforeach

</div>
<!--/.master-page -->

<script>
setTimeout(function() {
    $('#flash-message').hide();
}, 5000); // 5 seconds

$(document).ready(function() {
    $('.no-permission').on('click', function() {
        alert("You don't have permission for this action !!!");
    });

    @if(session('deletedProjectDetails'))
    $('#deletedProjectModal').modal('show');
    @endif
});
</script>

@endsection