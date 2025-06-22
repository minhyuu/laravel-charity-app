<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Project;
use App\Models\Donation;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    // Authenticate
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('authadmin') -> except('user');
        $this->middleware('authmanager') -> except('admin', 'user') ;
    }

    // Dashboard for manager
    public function index()
    {
        // Count the number of users with the role 'Donator'
        $donatorCount = User::where('role', 'Donator')->count();

        // Count the number of users with the role 'Administrator'
        $administratorCount = User::where('role', 'Administrator')->count();

        // Count the number of projects with the status 'ongoing'
        $ongoingCount = Project::where('status', 'ongoing')->count();

        // Count the number of projects with the status 'completed'
        $completedCount = Project::where('status', 'completed')->count();
        
        return view('dashboard.manager', compact('donatorCount', 'administratorCount', 'ongoingCount', 'completedCount'));
    }

	// Dashboard for project administrator page
    public function admin()
    {
        // $projects = Project::All();
        $projects = Project::where('status', 'ongoing')
                   ->orWhere('status', 'completed')
                   ->get();
    	$users = User::All();
        return view('project_administrator', compact('projects','users'));
    }

    //  Registered user dashboard
	public function user()
    {
        $donations = Donation::where('user_id', Auth::user()->id)
        ->orderBy('created_at', 'desc')
        ->with('project')
        ->get();

        return view('registered_user', compact('donations'));
    }
}
