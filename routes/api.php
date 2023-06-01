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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

//all login and dashbord page end points are here
Route::post('/login', [loginController::class, 'adminLogin']);

Route::post('/UpdatecheckValidation',[adminDashboardController::class, 'UpdateDataCheckValidation'])->middleware('auth:sanctum');
Route::post('/update-profile',[adminDashboardController::class, 'adminProfileUpdateRequest'])->middleware('auth:sanctum');
Route::get('/dashboard',[adminDashboardController::class,'fetchAllDashboardData'])->middleware('auth:sanctum');


Route::get('/all-users',[getUsersController::class,'getAllUsers'])->middleware('auth:sanctum');
Route::get('/logout', [loginController::class, 'logoutUser'])->middleware('auth:sanctum');
Route::get('/users', [getUsersController::class, 'getAllUsers'])->middleware('auth:sanctum');


//all team member api's are here
Route::get('/all-team-members',[getAllTeamMembersData::class, 'getAllTeamMember'])->middleware('auth:sanctum');
Route::post('/team-members/add', [getAllTeamMembersData::class, 'addTeamMember'])->middleware('auth:sanctum');
Route::post('/team-members/update', [getAllTeamMembersData::class, 'editTeamMemberData'])->middleware('auth:sanctum');

//all plan category api's are here
Route::get('/plan-library', [PlanLibraryController::class, 'getAllPlanLibrary'])->middleware('auth:sanctum');
Route::post('/plan-library/update-plan', [PlanLibraryController::class, 'updatePlanLibrary'])->middleware('auth:sanctum');
Route::post('/add-planLibrary', [PlanLibraryController::class, 'addPlanLibrary'])->middleware('auth:sanctum');


Route::post('/add-plan', [PlanLibraryController::class, 'addPlan'])->middleware('auth:sanctum');
Route::get('/get-all-plan', [PlanLibraryController::class, 'getAllListOfPlan'])->middleware('auth:sanctum');
Route::post('/delete-plan/{id}',[PlanLibraryController::class ,'deletePlan'])->middleware('auth:sanctum');


Route::post('/add-bulk-plan',[PlanLibraryController::class,'addbulkPlan'])->middleware('auth:sanctum');
Route::post('/plan/approve/{id}',[PlanLibraryController::class,'planApprove'])->middleware('auth:sanctum');
Route::post('/all-tasks/request-plan-for-need-edit/{id}',[PlanLibraryController::class, 'setStatusNeedEditForPlanRequest'])->middleware('auth:sanctum');



//all user's page api's are here
Route::get('/users/planner/re-assigned',[brandPlannerRe_assign::class,'brandPlannerReassign'])->middleware('auth:sanctum');
Route::post('/users/designer/re-assigned', [brandDesignerRe_assign::class, 'brandDesignerReassign'])->middleware('auth:sanctum');
Route::post('/users/{id}/design-guide',[updateDesignGuide::class,'updateDesignGuide'])->middleware('auth:sanctum');



// all design category api's are here
Route::get('/get-designs',[DesignLibraryController::class,'getDesignForSingleUser'])->middleware('auth:sanctum');
Route::get('/design-library',[DesignLibraryController::class,'getAllDesignLibrary'])->middleware('auth:sanctum');
Route::post('/add-design',[DesignLibraryController::class,'addDesignLibrary'])->middleware('auth:sanctum');
Route::post('/update-design',[DesignLibraryController::class,'updateDesignLibrary'])->middleware('auth:sanctum');
Route::get('/delete-design',[DesignLibraryController::class,'deleteDesign'])->middleware('auth:sanctum');

// all all tasks and reports page api's are here
Route::post('/all-tasks/delete-design-request/{id}', [DesignLibraryController::class, 'deleteDesignRequest'])->middleware('auth:sanctum');
Route::post('all-tasks/add-bulk-design',[DesignLibraryController::class,'addbulkDesign'])->middleware('auth:sanctum');
route::post('/add-design-plan',[DesignLibraryController::class,'addDesignPlan'])->middleware('auth:sanctum');

Route::get('/all-tasks/approve-design-request', [DesignLibraryController::class, 'approveDesignRequest'])->middleware('auth:sanctum');
Route::get('/all-tasks/request-design-for-need-edit', [DesignLibraryController::class, 'setStatusNeedEditForDesignRequest'])->middleware('auth:sanctum');

Route::get('/all-tasks',[getAllTaskController::class,'getAllTask'])->middleware('auth:sanctum');
Route::get('/reports',[getAllTaskController::class,'getReports'])->middleware('auth:sanctum');


//all search term here

Route::post('/all-users/search-from-all-users',[searchTermController::class,'searchFromAllUsers'])->middleware('auth:sanctum');
Route::post('/all-users/search-from-users', [searchTermController::class, 'searchFromUsers'])->middleware('auth:sanctum');
Route::post('/all-users/search-from-team-members', [searchTermController::class, 'searchFromTeamMembers'])->middleware('auth:sanctum');
Route::post('/all-users/search-from-plan-libraries', [searchTermController::class, 'searchFromPlanLibraries'])->middleware('auth:sanctum');
Route::post('/all-users/search-from-design-libraries', [searchTermController::class, 'searchFromDesignLibraries'])->middleware('auth:sanctum');
Route::post('/all-users/search-from-all-tasks', [searchTermController::class, 'searchFromAllTasks'])->middleware('auth:sanctum');
Route::post('/all-users/search-from-reports', [searchTermController::class, 'searchFromReports'])->middleware('auth:sanctum');

// 