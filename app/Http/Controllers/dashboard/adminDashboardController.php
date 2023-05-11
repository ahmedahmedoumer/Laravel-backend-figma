<?php

namespace App\Http\Controllers\dashboard;

use App\Http\Controllers\Controller;
use App\Models\notification;
use App\Services\UserProfileUpdateServices;
use App\Models\designLibrary;
use App\Models\planLibrary;
use App\Http\Requests\adminProfileUpdateRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;



class adminDashboardController extends Controller
{
    //
    public function adminDashboard()
    {   
        try{
            $notificationReader = new notification();
            $notificationReader = $notificationReader::where('status', 'notread')->get();
        }
        catch(\Throwable $th){
         return response()->json(['error'=>$th],401);
        }    
    }
    public function adminProfileUpdateRequest(adminProfileUpdateRequest $request)
    {
        try{
              $userData = $request->only(['firstName', 'lastName', 'email', 'phone', 'title', 'status',  'password', 'confirmPassword']);
               $updateUserProfile = new UserProfileUpdateServices();
               $header = $updateUserProfile->updateUserProfile($userData);
               if ($header) {
               $data = "Successfully  Updated";
               return response()->json(['status' => 200, 'data' => $data]);
               }
               $data = "Failed to update check your entry data";
              return response()->json($data, 400);
            }
            catch(\Throwable $th){
                return response()->json(['error'=>$th],401);
            }
    }

    public function fetchAllDashboardData()
    {
        try{
        $currentProjects = DB::table('task_progress_view')->where('design_status','approved')->get()->count();
        $newProject = DB::table('task_progress_view')->where('design_status','approved')->whereMonth('design_approved_on', now()->month)->get()->count();
        $newTasks = DB::table('task_progress_view')->whereMonth('design_approved_on', now()->month)->get()->count();
        $currentTasks =DB::table('task_progress_view')->where('plan_status', "approved")->get()->count();
        $notifications = notification::where('status','notread');
        return response()->json([
            'current_projects' => $currentProjects,
            'newProject' => $newProject,
            'newTask' => $newTasks,
            'currentTask' => $currentTasks,
            'notification' => $notifications
        ], 200);
    }
    catch(\Throwable $th){
        return response()->json(['error'=>$th],401);
    }
    }
}
