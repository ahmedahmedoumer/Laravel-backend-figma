<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\loginController;
use App\Http\Controllers\PlanLibraryController;
use App\Http\Controllers\DesignLibraryController;
use App\Http\Controllers\adminDashboardController;
use App\Http\Controllers\allUsers\getUsersController;
use App\Http\Controllers\allUsers\updateDesignGuide;
use App\Http\Controllers\brandRe_assign\brandPlannerRe_assign;
use App\Http\Controllers\brandRe_assign\brandDesignerRe_assign;
use App\Http\Controllers\TeamMembers\getAllTeamMembersData;
use App\Http\Controllers\PlanLibrary\getAllPlanLibrary;
use App\Http\Controllers\allTask\getAllTaskController;

// use App\Http\Controller\adminDashboardController;


/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });
Route::post('/login',[loginController::class, 'adminLogin']);
Route::post('/update-profile',[adminDashboardController::class, 'adminProfileUpdateRequest'])->middleware('auth:sanctum');
Route::get('/dashboard',[adminDashboardController::class,'fetchAllDashboardData'])->middleware('auth:sanctum');



Route::post('/logout', [loginController::class, 'logoutUser'])->middleware('auth:sanctum');
Route::get('/all-users',[getUsersController::class,'getAllUsers'])->middleware('auth:sanctum');



Route::get('/all-team-members',[getAllTeamMembersData::class, 'getAllTeamMember'])->middleware('auth:sanctum');
Route::post('/team-members/add', [getAllTeamMembersData::class, 'addTeamMember'])->middleware('auth:sanctum');
Route::post('/team-members/update/{id}', [getAllTeamMembersData::class, 'editTeamMemberData'])->middleware('auth:sanctum');


Route::get('/get-all-plan-library',[getAllPlanLibrary::class, 'getAllListOfPlanLibray'])->middleware('auth:sanctum');
Route::get('/users',[getUsersController::class, 'getAllUsers'])->middleware('auth:sanctum');


Route::post('/users/planner/re-assigned/{brand_id}/{planner_id}',[brandPlannerRe_assign::class,'brandPlannerReassign'])->middleware('auth:sanctum');
Route::post('/users/designer/re-assigned/{brand_id}/{designer_id}', [brandDesignerRe_assign::class, 'brandDesignerReassign'])->middleware('auth:sanctum');
Route::post('/users/{id}/design-guide',[updateDesignGuide::class,'updateDesignGuide'])->middleware('auth:sanctum');

Route::get('/plan-library',[PlanLibraryController::class,'getAllPlanLibrary'])->middleware('auth:sanctum');
Route::post('/add-plan',[PlanLibraryController::class,'addPlanLibrary'])->middleware('auth:sanctum');


Route::get('/design-library',[DesignLibraryController::class,'getAllDesignLibrary'])->middleware('auth:sanctum');
Route::post('/add-design',[DesignLibraryController::class,'addDesignLibrary'])->middleware('auth:sanctum');
Route::post('/update-design/{id}',[DesignLibraryController::class,'updateDesignLibrary'])->middleware('auth:sanctum');

Route::get('/all-tasks',[getAllTaskController::class,'getAllTask'])->middleware('auth:sanctum');
Route::get('/reports',[getAllTaskController::class,'getReports'])->middleware('auth:sanctum');