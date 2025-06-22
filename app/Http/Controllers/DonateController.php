<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Donation;
use App\Models\Project;
use Illuminate\Support\Facades\Auth;

class DonateController extends Controller
{
    // Authenticate
    public function __construct()
    {
        $this->middleware('auth');
    }

    // Show donate page
    public function index($id)
    {
        $project = Project::findOrFail($id);
        return view('donate', compact('project'));
    }

    // Store donation
    public function store(Request $request, $id) {
        $request->validate([
            'amount' => 'required|numeric',
        ]);

        $project = Project::findOrFail($id);

        // Create new donation
        $donation = new Donation;
        $donation->amount = $request->amount;
        $donation->user_id = Auth::user()->id;
        $donation->project_id = $project->id;
        $donation->save();

        // Update collected amount in project table
        $project->collected_amount = $project->collected_amount + $request->amount;
        if ($project->collected_amount >= $project->goal_amount) 
        {
            $project->status = 'completed';
        }
        $project->save();

        return redirect()->route('registered_user')->with('message', 'Donate Successfully! Thank You for Your Generous!');
    }
}
