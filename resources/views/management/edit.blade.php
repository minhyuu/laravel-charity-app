@extends('layouts.app')

@section('content')

<!-- banner -->
<div class="banner text-center">
    <div class="container">
        <h1>Administration</h1>
    </div>
</div>

<div class="edit-project-page">
    <div class="container">
        <h5>Update Project</h5>
        <form action="{{ secure_url('/update', $project->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="mb-4">
                <label for="projectTitle" class="form-label" style="font-weight: bold;">Title</label>
                <input type="text" name="name" class="form-control" id="projectTitle" placeholder="Project's Title"
                    value="{{ $project->name }}" required>
            </div>
            <div class="mb-4">
                <label class="form-label fw-semibold">Fundraising Target</label>
                <div class="input-group mb-3">
                    <span class="input-group-text">$</span>
                    <input type="number" name="goal_amount" class="form-control"
                        aria-label="Amount (to the nearest dollar)" value="{{ $project->goal_amount }}" required>
                   
                </div>
            </div>
            <div class="mb-4 form-group">
                <label for="projectCategory">Category</label>
                @if (isset(Auth::user()->id) && Auth::user()->role == "Manager")
                <select name="category" id="projectCategory" class="form-control">
                    @else
                    <input type="hidden" name="category" id="hiddenProjectCategory" value="{{ $project->category }}">
                    <select name="category" id="projectCategory" class="form-control" disabled>
                        @endif
                        <option value="">Choose...</option>
                        <option value="Health" {{ $project->category == 'Health' ? 'selected' : '' }}>Health</option>
                        <option value="Environment" {{ $project->category == 'Environment' ? 'selected' : '' }}>
                            Environment</option>
                        <option value="Education" {{ $project->category == 'Education' ? 'selected' : '' }}>Education
                        </option>
                    </select>
            </div>
            <div class="mb-4 form-group">
                <label for="projectStatus">Status</label>
                @if (isset(Auth::user()->id) && Auth::user()->role == "Manager")
                <select name="status" id="projectStatus" class="form-control">
                    @else
                    <input type="hidden" name="status" id="hiddenProjectStatus" value="{{ $project->status }}">
                    <select name="status" id="projectStatus" class="form-control" disabled>
                        @endif
                        <option value="ongoing" {{ $project->status == 'ongoing' ? 'selected' : '' }}>Ongoing</option>
                        <option value="completed" {{ $project->status == 'completed' ? 'selected' : '' }}>Completed
                        </option>
                    </select>

            </div>
            <div class="mb-4">
                <label class="form-label fw-semibold">Upload images</label>
                <div class="input-group mb-3">
                    <input type="file" name="image" class="form-control" id="inputGroupFile">
                </div>
                @if ($project->image)
                <img src="{{ asset('images/' . $project->image) }}" alt="Project Image"
                    style="max-width: 200px; margin-top: 10px;">
                @endif
            </div>
            <div class="mb-4">
                <label for="projectDescription" class="form-label fw-semibold">Description</label>
                <textarea name="description" class="form-control" id="projectDescription" rows="8"
                    placeholder="Description" required>{{ $project->description }}</textarea>
            </div>
            <div class="save-changes">
                <button type="submit" class="btn btn-primary">Save changes</button>
                <a href="{{ secure_url('/manage') }}" class="btn btn-secondary">Cancel</a>
            </div>
        </form>
    </div>
</div>

@endsection