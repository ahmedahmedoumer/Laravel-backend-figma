<?php

namespace App\Http\Controllers\dashboard;

use App\Http\Controllers\Controller;
use App\Models\notification;
use App\Services\UserProfileUpdateServices;
use App\Models\designLibrary;
use App\Models\planLibrary;
use App\http\Requests\adminProfileUpdateRequest;
use Illuminate\Support\Facades\DB;

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
        $currentProjects = DB::table('task_progress_view')->get()->count();
        $newProject = designLibrary::whereMonth('approved_on', now()->month)->get()->count();
        $newTasks = planLibrary::where('status', '!=', NULL)->get()->count();
        $currentTasks = planLibrary::where('design_status', '!=', "approved")->get()->count();
        $notifications = notification::all();
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
