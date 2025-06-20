@extends('layouts.app')

@section('content')

<!-- banner -->
<div class="banner text-center">
    <div class="container">
        <h1>User Management</h1>
    </div>
</div>

<!-- Headline -->
<div class="user-manage">
    <div class="container">
        <h2 class="text-center mb-3">User Management</h2>

        <!-- Filter -->
        <div class="search-filter">
            <form action="{{ route('user_management') }}" method="GET" class="row g-3">
                <!-- Search bar for name -->
                <div class="col-lg-4 col-12">
                    <input type="text" name="search" class="form-control" id="search" placeholder="Search for name.."
                        title="Type in a name" value="{{ request('search') }}">
                </div>
                <!-- Drop down for role -->
                <div class="col-lg-3 col-6 my-3 my-lg-0">
                    <label for="role" class="form-label d-none">Role</label>
                    <select id="role" name="role" class="form-select">
                        <option value="">All role</option>
                        <option value="Donator" {{ request('role') == 'Donator' ? 'selected' : '' }}>Donator</option>
                        <option value="Administrator" {{ request('role') == 'Administrator' ? 'selected' : '' }}>
                            Administrator</option>
                    </select>
                </div>
                <!-- Drop down for category -->
                <div class="col-lg-3 col-6 my-3 my-lg-0">
                    <label for="category" class="form-label d-none">Category</label>
                    <select id="category" name="category" class="form-select">
                        <option value="">All category</option>
                        <option value="Health" {{ request('category') == 'Health' ? 'selected' : '' }}>Health</option>
                        <option value="Environment" {{ request('category') == 'Environment' ? 'selected' : '' }}>
                            Environment</option>
                        <option value="Education" {{ request('category') == 'Education' ? 'selected' : '' }}>Education
                        </option>
                    </select>
                </div>
                <!-- Filter button -->
                <div class="col-lg-2 col-12 filter">
                    <button type="submit" class="btn btn-success h-100 w-100">Filter</button>
                </div>
            </form>
        </div>

        <!-- Messasge -->
        @if(session()->has('message'))
        <div class="alert alert-success my-3">
            {{ session()->get('message') }}
        </div>
        @endif

        <!--Table of Data-->
        <div id="charity-list">
            <table class="table table-hover table-responsive mb-0">
                <thead>
                    <tr>
                        <th scope="col">ID</th>
                        <th scope="col">Name</th>
                        <th scope="col">Email</th>
                        <th scope="col">Role</th>
                        <th scope="col">Category</th>
                        <th scope="col">Action</th>
                    </tr>
                </thead>

                <!-- Fetch data from User table -->
                @foreach ($users as $user)
                <tbody class="table-group-divider">
                    <tr>
                        <th scope="row">{{$user->id}}</th>
                        <td>{{$user->name}}</td>
                        <td>{{$user->email}}</td>
                        <td>{{$user->role}}</td>
                        <td>{{$user->category}}</td>
                        <td>
                            <button class="btn btn-primary edit-role-btn" data-toggle="modal"
                                data-target="#editRoleModal-{{ $user->id }}" data-id="{{ $user->id }}"
                                data-role="{{ $user->role }}">
                                Edit Role
                            </button>
                        </td>

                        <!-- Modal to update role -->
                        <div class="modal fade" id="editRoleModal-{{ $user->id }}" tabindex="-1"
                            aria-labelledby="editRoleModalLabel-{{ $user->id }}" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">

                                    <!-- Modal header -->
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="editRoleModalLabel-{{ $user->id }}">Edit Role</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>

                                    <!-- Modal body -->
                                    <div class="modal-body">
                                        <form action="{{ url('update_role/'.$user->id) }}" method="POST">
                                            @csrf
                                            @method('PUT')

                                            <!-- show name -->
                                            <div class="row mb-3">
                                                <label for="name"
                                                    class="col-md-4 col-form-label text-md-end">{{ __('Name') }}</label>

                                                <div class="col-md-6">
                                                    <input id="name" type="text" class="form-control" name="name"
                                                        value="{{ $user->name }}" disabled>
                                                </div>
                                            </div>

                                            <!-- show Email -->
                                            <div class="row mb-3">
                                                <label for="email"
                                                    class="col-md-4 col-form-label text-md-end">{{ __('Email Address') }}</label>

                                                <div class="col-md-6">
                                                    <input id="email" type="email" class="form-control" name="email"
                                                        value="{{ $user->email }}" disabled>
                                                </div>
                                            </div>

                                            <!-- Update role-->
                                            <div class="row mb-3">
                                                <label for="role"
                                                    class="col-md-4 col-form-label text-md-end">{{ __('Role') }}</label>

                                                <div class="col-md-6">
                                                    <select name="role" id="role" class="form-select" required>
                                                        <!-- <option value="">Choose...</option> -->
                                                        <option value="Donator"
                                                            {{ $user->role == 'Donator' ? 'selected' : '' }}>Donator
                                                        </option>
                                                        <option value="Administrator"
                                                            {{ $user->role == 'Administrator' ? 'selected' : '' }}>
                                                            Administrator</option>
                                                    </select>
                                                </div>
                                            </div>

                                            <!-- Update Category -->
                                            <div class="row mb-3">
                                                <label for="category"
                                                    class="col-md-4 col-form-label text-md-end">{{ __('Category') }}</label>

                                                <div class="col-md-6">
                                                    <select name="category" id="category" class="form-select">
                                                        <option value="None"
                                                            {{ $user->role == 'Donator' ? 'selected' : '' }}>None
                                                        </option>
                                                        <option value="Health"
                                                            {{ $user->category == 'Health' ? 'selected' : '' }}>Health
                                                        </option>
                                                        <option value="Environment"
                                                            {{ $user->category == 'Environment' ? 'selected' : '' }}>
                                                            Environment</option>
                                                        <option value="Education"
                                                            {{ $user->category == 'Education' ? 'selected' : '' }}>
                                                            Education
                                                        </option>
                                                    </select>
                                                </div>
                                            </div>

                                    </div>

                                    <!-- Modal footer -->
                                    <div class="modal-footer">
                                        <button type="submit" class="btn btn-primary">Save changes</button>
                                        <button type="button" class="btn btn-secondary"
                                            data-dismiss="modal">Close</button>
                                    </div>

                                    </form>

                                </div>
                            </div>
                        </div>

                    </tr>
                </tbody>

                @endforeach
            </table>
        </div>
        <!--/.charity-list -->
    </div>
</div>

<!--/.user-manage -->
@endsection