@extends('layouts.app')

@section('content')

<!-- banner -->
<div class="banner text-center">
    <div class="container">
        <h1>Administration</h1>
    </div>
</div>

<!-- Heading -->
<div class="create-page">
    <div class="container">
        <h5>Create New Project</h5>

        <!-- Display Validation Errors -->
        @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        <form action="{{ route('store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="mb-4">
                <label for="projectTitle" class="form-label" style="font-weight: bold;">Title</label>
                <input type="text" name="name" class="form-control" id="projectTitle" placeholder="Project's Title"
                    required>
            </div>
            <div class="mb-4 form-group">
                <label for="projectCategory">Category</label>
                <select name="category" id="projectCategory" class="form-control" required>
                    @if (auth()->user()->role == 'Administrator' && auth()->user()->category == 'Health')
                        <option value="Health">Health</option>
                    @elseif (auth()->user()->role == 'Administrator' && auth()->user()->category == 'Environment')
                        <option value="Environment">Environment</option>
                    @elseif (auth()->user()->role == 'Administrator' && auth()->user()->category == 'Education')
                        <option value="Education">Education</option>
                    @else
                    <option value="">Choose...</option>
                    <option value="Health">Health</option>
                    <option value="Environment">Environment</option>
                    <option value="Education">Education</option>
                    @endif
                </select>
            </div>
            <div class="mb-4">
                <label class="form-label fw-semibold">Fundraising Target</label>
                <div class="input-group mb-3">
                    <span class="input-group-text">$</span>
                    <input type="number" name="goal_amount" class="form-control"
                        aria-label="Amount (to the nearest dollar)" required>
                    <span class="input-group-text">.00</span>
                </div>
            </div>
            <div class="mb-4">
                <label class="form-label fw-semibold">Upload images</label>
                <div class="input-group mb-3">
                    <input type="file" name="image" class="form-control" id="inputGroupFile">
                </div>
            </div>
            <div class="mb-4">
                <label for="projectDescription" class="form-label fw-semibold">Description</label>
                <textarea name="description" class="form-control" id="projectDescription" rows="8"
                    placeholder="Description" required></textarea>
            </div>
            <div class="save-changes">
                <button type="submit" class="btn btn-primary">Save</button>
                <a href="{{ route('manage') }}" class="btn btn-secondary">Cancel</a>
            </div>
            <!--/.save-changes -->
        </form>
    </div>
</div>

@endsection