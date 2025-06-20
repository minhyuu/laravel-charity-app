<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\ManageController;          //Manage Page Controller 
use App\Http\Controllers\MasterController;          //Master Page Controller 
use App\Http\Controllers\ProjectController;         //Charity List Controller
use App\Http\Controllers\UserController;            //User Controller  
use App\Http\Controllers\DashboardController;        //Dashboard Controller  
use App\Http\Controllers\DonateController;          // Donate controller
 
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/welcome', function () {
    return view('welcome');
});

Auth::routes();

// Routes for navigation
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/', [App\Http\Controllers\HomeController::class, 'main'])->name('main');

// Route for charity list page
Route::get('/charity_list', [ProjectController::class, 'index'])->name('charity_list');

// Route for user management page
Route::get('/user_management', [UserController::class, 'index'])->name('user_management');
Route::get('/edit_role/{id}', [UserController::class, 'edit'])->name('edit_role');
Route::put('/update_role/{id}', [UserController::class, 'updateRole'])->name('update_role');

// Route for dashboard registered user page
Route::get('/registered_user', [DashboardController::class, 'user'])->name('registered_user');

// Route for dashboard project administrator page
Route::get('/project_administrator', [DashboardController::class, 'admin'])->name('project_administrator');

// Route for dashboard page
Route::get('/dashboard_manager', [DashboardController::class, 'index'])->name('dashboard_manager');

// Route for profile page
Route::get('/profile', [UserController::class,'show'])->name('profile');
Route::put('/profile_update', [UserController::class, 'update'])->name('profile_update');
Route::post('/password_update', [UserController::class, 'changePassword'])->name('password_update');


//The Routes For Manage Page
Route::group(['middleware' => ['auth', 'role.project.filter']], function () {
    Route::get('/manage', [ManageController::class, 'index'])->name('manage');
    Route::get('/create', [ManageController::class, 'create'])->name('create');     //Create new project route
    Route::post('/store', [ManageController::class, 'store'])->name('store');       //Store new project route
    Route::get('/edit/{id}', [ManageController::class, 'edit'])->name('edit');
    Route::put('/update/{id}', [ManageController::class, 'update'])->name('update');
    Route::delete('/deleteAndReset/{id}', [ManageController::class, 'deleteAndReset'])->name('deleteAndReset');
});


//The Routes For Donate Page
Route::get('/donate/{id}', [DonateController::class, 'index'])->name('donate');
Route::post('/create_donate/{id}', [DonateController::class, 'store'])->name('create_donate');
