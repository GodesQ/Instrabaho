<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\ProjectsController;
use App\Http\Controllers\Api\FreelancersController;
use App\Http\Controllers\Api\EmployersController;
use App\Http\Controllers\Api\ProjectProposalController;
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

    Route::post('freelancer/save_role', [FreelancersController::class, 'save_role_form'])->name('freelancer.save_role_form');
    Route::post('employer/save_role', [EmployersController::class, 'save_role_form'])->name('employer.save_role_form');


    Route::get('projects', [ProjectsController::class, 'projects']);
    Route::get('fetch_projects', [ProjectsController::class, 'fetch_projects']);

    Route::get('freelancers', [FreelancersController::class, 'freelancers']);
    Route::get('fetch_freelancers', [ProjectsController::class, 'fetch_freelancers']);

    Route::post('/store_proposal', [ProjectProposalController::class, 'store'])->name('proposal.store');

    Route::group(['middleware' => ['employer.access']], function () {

    });

    Route::group(['prefix'=> 'freelancer', 'middleware'=> ['freelancer.access']], function(){

    });



    Route::post('logout', [AuthController::class, 'logout']);
});
