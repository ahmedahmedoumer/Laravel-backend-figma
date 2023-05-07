<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\loginController;
use App\Http\Controllers\PlanLibrary\PlanLibraryController;
use App\Http\Controllers\designLibrary\DesignLibraryController;
use App\Http\Controllers\dashboard\adminDashboardController;
use App\Http\Controllers\allUsers\getUsersController;
use App\Http\Controllers\allUsers\updateDesignGuide;
use App\Http\Controllers\brandRe_assign\brandPlannerRe_assign;
use App\Http\Controllers\brandRe_assign\brandDesignerRe_assign;
use App\Http\Controllers\TeamMembers\getAllTeamMembersData;
use App\Http\Controllers\PlanLibrary\getAllPlanLibrary;
use App\Http\Controllers\searchTerm\searchTermController;
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

//all login and dashbord page end points are here
Route::post('/login', [loginController::class, 'adminLogin']);
Route::group(['middleware','auth:sanctum'],function(){

Route::post('/update-profile',[adminDashboardController::class, 'adminProfileUpdateRequest']);
Route::get('/dashboard',[adminDashboardController::class,'fetchAllDashboardData']);



Route::post('/logout', [loginController::class, 'logoutUser']);
Route::get('/all-users',[getUsersController::class,'getAllUsers']);
Route::get('/users', [getUsersController::class, 'getAllUsers']);


//all team member api's are here
Route::get('/all-team-members',[getAllTeamMembersData::class, 'getAllTeamMember']);
Route::post('/team-members/add', [getAllTeamMembersData::class, 'addTeamMember']);
Route::post('/team-members/update/{id}', [getAllTeamMembersData::class, 'editTeamMemberData']);

//all plan category api's are here
Route::get('/plan-library', [PlanLibraryController::class, 'getAllPlanLibrary']);
Route::post('/plan-library/update-plan/{id}', [PlanLibraryController::class, 'updatePlanLibrary']);
Route::post('/add-plan', [PlanLibraryController::class, 'addPlanLibrary']);

Route::get('/get-all-plan-library', [getAllPlanLibrary::class, 'getAllListOfPlanLibray']);
Route::post('/reports/delete-plan/{id}',[PlanLibraryController::class ,'deletePlan']);
Route::post('/add-bulk-plan',[PlanLibraryController::class,'addbulkPlan']);
Route::post('/plan/approve/{id}',[PlanLibraryController::class,'planApprove']);



//all user's page api's are here
Route::post('/users/planner/re-assigned/{brand_id}/{planner_id}',[brandPlannerRe_assign::class,'brandPlannerReassign']);
Route::post('/users/designer/re-assigned/{brand_id}/{designer_id}', [brandDesignerRe_assign::class, 'brandDesignerReassign']);
Route::post('/users/{id}/design-guide',[updateDesignGuide::class,'updateDesignGuide']);



// all design category api's are here
Route::get('/design-library',[DesignLibraryController::class,'getAllDesignLibrary']);
Route::post('/add-design',[DesignLibraryController::class,'addDesignLibrary']);
Route::post('/update-design/{id}',[DesignLibraryController::class,'updateDesignLibrary']);


// all all tasks and reports page api's are here
Route::post('/all-tasks/delete-design-request/{id}', [DesignLibraryController::class, 'deleteDesignRequest']);
Route::post('/all-tasks/approve-design-request/{id}', [DesignLibraryController::class, 'approveDesignRequest']);
Route::post('/all-tasks/request-design-for-need-edit/{id}', [DesignLibraryController::class, 'setStatusNeedEditForDesignRequest']);

Route::get('/all-tasks',[getAllTaskController::class,'getAllTask']);
Route::get('/reports',[getAllTaskController::class,'getReports']);


//all search term here

Route::post('/all-users/search-from-all-users',[searchTermController::class,'searchFromAllUsers']);
Route::post('/all-users/search-from-users', [searchTermController::class, 'searchFromUsers']);
Route::post('/all-users/search-from-team-members', [searchTermController::class, 'searchFromTeamMembers']);
Route::post('/all-users/search-from-plan-libraries', [searchTermController::class, 'searchFromPlanLibraries']);
Route::post('/all-users/search-from-design-libraries', [searchTermController::class, 'searchFromDesignLibraries']);
Route::post('/all-users/search-from-all-tasks', [searchTermController::class, 'searchFromAllTasks']);
Route::post('/all-users/search-from-reports', [searchTermController::class, 'searchFromReports']);

});