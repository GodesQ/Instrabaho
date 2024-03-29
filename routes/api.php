<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\ProjectsController;
use App\Http\Controllers\Api\FreelancersController;
use App\Http\Controllers\Api\EmployersController;
use App\Http\Controllers\Api\ProjectProposalController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\ProjectChatController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post('login', [AuthController::class, 'login']);
Route::post('register', [AuthController::class, 'register']);

Route::group(['middleware' => ['auth:sanctum']], function () {

    Route::post('/user_change_password', [UserController::class, 'user_change_password'])->name('user_change_password');
    Route::post('/change_user_picture', [UserController::class, 'change_user_picture'])->name('change_user_picture');

    Route::post('freelancer/save_role', [FreelancersController::class, 'save_role_form'])->name('freelancer.save_role_form');
    Route::post('employer/save_role', [EmployersController::class, 'save_role_form'])->name('employer.save_role_form');


    Route::get('projects', [ProjectsController::class, 'projects']);
    Route::get('fetch_projects', [ProjectsController::class, 'fetch_projects']);

    Route::get('freelancers', [FreelancersController::class, 'freelancers']);
    Route::get('fetch_freelancers', [FreelancersController::class, 'fetch_freelancers']);

    Route::post('/store_proposal', [ProjectProposalController::class, 'store'])->name('proposal.store');

    Route::group(['prefix'=> 'employer', 'middleware'=> ['employer.access']], function(){
        Route::post('/update_profile', [EmployersController::class, 'update_profile'])->name('employer.update_profile');

        # Routes for projects
        Route::get('/projects', [ProjectsController::class, 'employer_projects']);
        Route::get('/projects/ongoing', [ProjectsController::class, 'employer_ongoing_projects']);
        Route::get('/projects/completed', [ProjectsController::class, 'employer_completed_projects']);
        Route::get('/create_project', [ProjectsController::class, 'create']);
        Route::post('/store_project', [ProjectsController::class, 'store']);
        Route::get('/edit_project/{project_id}', [ProjectsController::class, 'edit']);
        Route::post('/update_project', [ProjectsController::class, 'update']);
        Route::delete('/delete_project', [ProjectsController::class, 'destroy']);
    });

    Route::group(['prefix'=> 'freelancer', 'middleware'=> ['freelancer.access']], function(){
        Route::post('/update_profile', [FreelancersController::class, 'update_profile'])->name('freelancer.update_profile');
        Route::get('/freelancer_skills', [FreelancersController::class, 'fetch_freelancer_skills']);
        Route::post('/freelancer_skills', [FreelancersController::class, 'store_freelancer_skills']);

        Route::get('/freelancer_projects', [FreelancersController::class, 'fetch_freelancer_projects']);
        Route::post('/freelancer_projects', [FreelancersController::class, 'store_freelancer_projects']);

        Route::get('/freelancer_certificates', [FreelancersController::class, 'fetch_freelancer_certificates']);
        Route::post('/freelancer_certificates', [FreelancersController::class, 'store_freelancer_certificates']);

        Route::get('/freelancer_experiences', [FreelancersController::class, 'fetch_freelancer_experiences']);
        Route::post('/freelancer_experiences', [FreelancersController::class, 'store_freelancer_experiences']);

        Route::get('/freelancer_educations', [FreelancersController::class, 'fetch_freelancer_educations']);
        Route::post('/freelancer_educations', [FreelancersController::class, 'store_freelancer_educations']);

        Route::get('/projects/ongoing', [ProjectsController::class, 'freelancer_ongoing_projects']);
        Route::get('/projects/completed', [ProjectsController::class, 'freelancer_completed_projects']);
        Route::get('proposal_lists', [ProjectProposalController::class, 'proposals_for_freelancers'])->name('freelancer.proposals');
    });

    Route::post('/submit_proposal', [ProjectProposalController::class, 'store'])->middleware('freelancer.access');
    Route::get('/proposal/info/{id}', [ProjectProposalController::class, 'proposal']);

    Route::get('/proposal/get_chat/{id}/{type}', [ProjectChatController::class, 'project_get_chat'])->name('project_get_chat');
    Route::post('/send_project_chat', [ProjectChatController::class, 'send_project_chat'])->name('send_project_chat');

    Route::post('logout', [AuthController::class, 'logout']);
});
