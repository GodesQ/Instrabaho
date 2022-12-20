<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\ProjectsController;
use App\Http\Controllers\Api\FreelancersController;

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


Route::get('projects', [ProjectsController::class, 'projects']);

Route::get('freelancers', [FreelancersController::class, 'freelancers']);

Route::group(['middleware' => ['auth:sanctum']], function () {

    Route::group(['middleware' => ['employer.access']], function () {

    });

    Route::post('logout', [AuthController::class, 'logout']);
});
