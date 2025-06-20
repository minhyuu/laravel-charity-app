<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    public function index(Request $request)
    {
        $query = Project::query();

        // filter category
        if ($request->filled('category')) {
            $query->where('category', $request->category);
        }
        
        // Only show ongoing projects
        $query->where('status', 'ongoing');

        // filter name
        if ($request->filled('search')) {
            $query->where('name', 'like' , $request->search . '%');
        }

        $projects = $query->get();

        return view('charity_list', compact('projects'));
    }
}
