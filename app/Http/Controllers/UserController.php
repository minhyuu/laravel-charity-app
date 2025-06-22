<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    // Authenticate
    public function __construct() 
    {
        $this->middleware('auth');
        $this->middleware('authmanager') -> except('show', 'update', 'changePassword');
    }

    // FOR USER MANAGEMENT

    // Show all user
    public function index(Request $request)
    {
        $query = User::query();

        // Exclude manager role
        $query->where('role', '!=', 'Manager');

        // filter category
        if ($request->filled('category')) {
            $query->where('category', $request->category);
        }

        // filter role
        if ($request->filled('role')) {
            $query->where('role', $request->role);
        }

        // Filter search name
        if ($request->filled('search')) {
            $query->where('name', 'like' , $request->search . '%');
        }

        $users = $query->get();

        return view('user_management', compact('users'));
    }
    
    // Upddate role of user
    public function updateRole(Request $request, $id)
    {
        $user = User::findOrFail($id);
        
        $user->role = $request->role;
        if ($request->role == 'Donator') {
            $user->category = 'None';
        }
        if ($request->role == 'Administrator') {
            $user->category = $request->category;
        }
 
        $user->save();

        return redirect()->route('user_management')->with('message', 'Role updated successfully.');
    }


    // FOR PROFILE PAGE
 
    // Show profile page
    public function show()
    {
        $user = Auth::user(); // Assuming the user is authenticated;
        return view('profile', compact('user'));
    }

    // Update profile
    public function update(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,' . Auth::id()],
            'date_of_birth' => ['required', 'date'],
        ]);

        $user = Auth::user();

        $user->name = $request->name;
        $user->email = $request->email;
        $user->dob = $request->date_of_birth;

        $user->save();

        return redirect()->route('profile')->with('message', 'Profile updated successfully.');
    }

    // Update password
    public function changePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'new_password' => 'required|string|min:8|confirmed',
        ]);

        $user = Auth::user();

        if (!Hash::check($request->current_password, $user->password)) {
            return back()->withErrors(['current_password' => 'Current password does not match']);
        }

        $user->password = Hash::make($request->new_password);
        $user->save();

        return redirect()->route('profile')->with('message', 'Password updated successfully.');
    }
}


