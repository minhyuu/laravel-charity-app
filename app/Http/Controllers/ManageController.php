<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Project;
use App\Models\Donation;
use App\Models\User;


class ManageController extends Controller
{
    // Authenticate
    public function __construct() 
    {
        $this->middleware('auth');
        $this->middleware('authadmin');
    }

    /*Index page*/
    public function index(Request $request)
    {
        $query = Project::query();

        $query->where('status', '!=', 'removed');

        if ($request->filled('category')) {
            $query->where('category', $request->category);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('search')) {
            $query->where('name', 'like', $request->search . '%');
        }

        $projects = $query->get();

        // Update the status of each project based on collected amount
        foreach ($projects as $project) {
        if (($project->collected_amount / $project->goal_amount) * 100 >= 100) {
            if ($project->status != 'completed' && $project->status != 'removed') {
                $project->status = 'completed';
                $project->save();
            }
        } else {
            if ($project->status != 'ongoing' && $project->status != 'removed') {
                $project->status = 'ongoing';
                $project->save();
            }
        }}   

        // Fetch donations with related user and project data
        $donations = Donation::with(['user', 'project'])->get();

        //Management page
        return view('management.manage', compact('projects', 'donations'));
    }

    /* Create new project */
    public function create(){
        // Create new project
        return view('management.create');
    }

    /* Store new project to the database */
    public function store(Request $request) {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'goal_amount' => 'required|numeric',
            'category' => 'required|string',
        ]);

        $project = new Project;
        $project->name = $request->name;
        $project->description = $request->description;
        $project->goal_amount = $request->goal_amount;
        $project->category = $request->category;
        $project->status = 'ongoing';
        $project->collected_amount = 0; // Initialize collected amount to 0

        $project->save();

        return redirect()->route('manage')->with('success', 'Project created successfully.');
    }


    /* Edit existing project */
    public function edit($id)
    {
        $project = Project::findOrFail($id);

        return view('management.edit', compact('project'));
    }

    /* Update existing project */
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'goal_amount' => 'required|numeric',
            'category' => 'required|string',
            'status' => 'required|string',
        ]);

        $project = Project::findOrFail($id);
        $project->name = $request->name;
        $project->description = $request->description;
        $project->goal_amount = $request->goal_amount;
        $project->category = $request->category;
        $project->status = $request->status;

        $project->save();

        return redirect()->route('manage')->with('success', 'Project updated successfully.');
    }

    public function deleteAndReset($id)
    {
        // Find the specific project
        $project = Project::find($id);
        
        if (!$project) {
            return redirect()->route('manage')->with('error', 'Project not found.');
        }

        // Store project details and related donations
        $projectDetails = $project->toArray();
        $donations = Donation::where('project_id', $id)->get();

        // Change the status of the project to "removed"
        $project->status = 'removed';
        $project->save();

        // Get all projects ordered by current ID
        $projects = Project::orderBy('id')->get();

        // Prepare session data for removed project
        if ($projectDetails['status'] == 'ongoing') {
            return redirect()->route('manage')->with([
                'success' => 'Project removed successfully. All donation were refunded to donators',
                'deletedProjectDetails' => $projectDetails,
                'deletedDonations' => $donations
            ]);
        } else {
            return redirect()->route('manage')->with('success', 'Project removed successfully. All donation were refunded to donators');
        }
    }

}
