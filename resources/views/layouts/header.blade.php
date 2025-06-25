<div class="container">
    <nav class="navbar navbar-expand-lg navbar-light">

        <!-- Logo -->
        <a class="navbar-brand" href="{{ route('main') }}">
            <img src="{{ secure_url('../images/logo.png') }}" alt="Logo" class="img-fluid"></a>
        
        <!-- Responsive toggler -->
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav"
            aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <!-- Navigation items -->
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ml-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('main') }}">Home</span></a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="{{ route('charity_list') }}">Charity List</a>
                </li>

                @guest 
                @if (Route::has('login'))
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('login') }}">Login</a>
                    </li>
                @endif

                @if (Route::has('register'))
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('register') }}">Register</a>
                    </li>
                @endif

                @else
                <li class="nav-item dropdown">
                    <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button"
                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                        {{ Auth::user()->name }}
                    </a>

                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">   
                        <!-- Display profile page for user login -->
                        @if (isset(Auth::user()->id))
                            <a class="dropdown-item" href="{{ secure_url('/profile') }}">Profile</a>
                        @endif

                        <!-- If user is system manager, display user management page link -->
                        @if (isset(Auth::user()->id) && Auth::user()->role == "Manager")
                            <a class="dropdown-item" href="{{ secure_url('/manage') }}">Project Management</a>
                            <a class="dropdown-item" href="{{ secure_url('/user_management') }}">User Management</a>
                        @endif
                    
                    	<!-- If user is donator, display registered user page link -->
                        @if (isset(Auth::user()->id) && Auth::user()->role == "Donator")
                            <a class="dropdown-item" href="{{ secure_url('/registered_user') }}">Dashboard</a>
                        @endif
                    
                    	<!-- If user is project administrator, display project administrator page link -->
                        @if (isset(Auth::user()->id) && Auth::user()->role == "Administrator")
                            <a class="dropdown-item" href="{{ secure_url('/manage') }}">Project Management</a>
                            <a class="dropdown-item" href="{{ secure_url('/project_administrator') }}">Dashboard</a>
                        @endif

                        <!-- Display dashboard page for System Manager -->
                        @if (isset(Auth::user()->id) && Auth::user()->role == "Manager")
                        <a class="dropdown-item" href="{{ secure_url('/dashboard_manager') }}">Dashboard</a>
                        @endif

                        <!-- Logout button for login user -->
                        <a class="dropdown-item" href="{{ secure_url('/logout') }}"
                            onclick="event.preventDefault();
                                            document.getElementById('logout-form').submit();">
                            {{ __('Logout') }}
                        </a>

                        <form id="logout-form" action="{{ secure_url('/logout') }}" method="POST" class="d-none">
                            @csrf
                        </form>

                    </div>
                </li>
                @endguest 
 
                <li class="nav-item mt-2 mt-lg-0 ml-lg-2">
                    <a href="#" class="btn btn-secondary" 
                    onclick="window.location='{{ URL::route('charity_list') }}'"
                    >Donate Now</a>
                </li>
            </ul>
        </div>
    </nav>
    <!--/.navbar -->
</div>