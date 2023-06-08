<?php

namespace App\Http\Controllers\PlanLibrary;

// use Maatwebsite\Excel\Facades\Excel;
use App\Http\Controllers\Controller;
use App\Http\Requests\planFormRequest;
use App\Http\Requests\plansformRequest;
use App\Models\planLibrary;
use Illuminate\Http\Request;
use App\Models\plans;
use App\Models\brands;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use League\Csv\Reader;
class PlanLibraryController extends Controller
{


 ////////////////////////////   for plan Library page //////////////////////////////////////////////////
public function getAllPlanLibrary(Request $request)
{
        try {
            $page = $request->query('perPage');
            $currentPage=$request->query('currentPage');
             $allPlanLibrary=planLibrary::paginate(perPage:$page,page:$currentPage);
            if ($allPlanLibrary) {
            return response()->json($allPlanLibrary,200);
            }
            $allPlanLibrary=Null;
              return response()->json($allPlanLibrary,200);
        } catch (\Throwable $th) {
            return response()->json(['error' => $th], 401);
        }
 }
public function addPlanLibrary(planFormRequest $request)
    {
        try {
            $planRequest = $request->only('data.title', 'data.description', 'data.prompt');
            $createPlan = planLibrary::create([
                'planTitle' => $planRequest['data']['title'],
                'planDescription' => $planRequest['data']['description'],
                'planPrompt' => $planRequest['data']['prompt']
            ]);
            return $createPlan ? response()->json(planLibrary::paginate(perPage:4), 200) : response()->json('Failed to register plan ', 400);
        } catch (\Throwable $th) {
            return response()->json(['error' => $th], 401);
        }
   }
public function updatePlanLibrary(planFormRequest $request)
    {
        try {
            $planRequest = $request->only('data.id','data.title', 'data.description', 'data.prompt');
            $findPlan = planLibrary::findOrFail($planRequest['data']['id']);
            $chec = null;
            if ($findPlan) {
                $findPlan->planTitle = $planRequest['data']['title'];
                $findPlan->planDescription = $planRequest['data']['description'];
                $findPlan->planPrompt = $planRequest['data']['prompt'];
                $check = $findPlan->save();
            }
            return $check ? response()->json(planLibrary::paginate(perPage:4), 200) : response()->json('Failed to update plan ', 400);
        } catch (\Throwable $th) {
            return response()->json(['error' => $th], 401);
        }
    }
///////////////////////for all tasks page /////////////////////////////////////////////////////////////
public function addPlan(plansformRequest $request)
{
        try {
            $planRequest = $request->only('id','textOnPost', 'caption', 'hashTag');
            $createPlan = plans::create([
                'brands_id'=>$planRequest['id'],
                'textOnPost' => $planRequest['textOnPost'],
                'caption' => $planRequest['caption'],
                'hashTag' => $planRequest['hashTag']
            ]);
            return $createPlan ? response()->json(planLibrary::all(), 200) : response()->json('Failed to register plan ', 400);
        } catch (\Throwable $th) {
            return response()->json(['error' => $th], 401);
        }
}
public function addbulkPlan(Request $request)
    {

        try {
            $request->validate([
             'zipFile' => 'required|mimes:csv',
             'userId'=>'required',
            ]);
            return $request->zipFile;
            $csvFile= Reader::createFromPath($request->file('zipFile')->getRealPath());
            $csvFile->setHeaderOffset(0);
            $drowData=null;
            foreach ($csvFile as $row) {
                $plans = new plans();
                $plans->brands_id=$request->userId;
                $plans->textOnPost = $row['textOnPost'];
                $plans->planDescription = $row['caption'];
                $plans->planPrompt = $row['hashTag'];
                $checkCreated = $plans->save();
            }
            return $checkCreated ? response()->json('Successefully created', 200) : response()->json('Failed to Add bulk plan', 400);
        } catch (\Throwable $th) {
            return response()->json(['error' => $th], 401);
        }
    }
public function setStatusNeedEditForPlanRequest(Request $request)
    {
        $userId=$request->query('userID');
        try {
            $findUserPlan = plans::where('brands_id', $userId)
                                  ->update(['status'=>'Need Edit']);
            return $findUserPlan 
                               ? response()->json('successfully update Status', 200) 
                               : response()->json('Failed to update Status', 200);
        } catch (\Throwable $th) {
            return response()->json('Something Wrong',401);
        }
    }
public function planApprove(Request $request)
    {
        $userId=$request->query('userID');
        try {
            $approvePlan=plans::where('brands_id',$userId)
                          ->update([
                            'status'=>"approved",
                            'approved_on'=>now(),
                            'approved_by'=>Auth::id(),
                          ]);
            return $approvePlan?
                            response()->json( plans::paginate(4), 200)
                            :response()->json(401);
        } catch (\Throwable $th) {
            return response()->json(['error' => $th], 401);
        }
    }
public function deletePlan(Request $request)
{
    $planId=$request->query('planId');
    return $planId;
        try {
            $plans=plans::findOrFail($planId);
            $checkDelete=$plans->delete();
            return $checkDelete 
                              ? response()->json(200) 
                              : response()->json(401);
        } catch (\Throwable $th) {
            return response()->json(['error' => $th], 401);
        }
}

public function getPlanUser(Request $request){
    try {
    // $planner=$request->query('plannerId');
    $userId=$request->query('userId');
    $user=brands::with('brandsCompany')->where('id',$userId)->first();
    return $user?
                 response()->json($user, 200)
                 :response()->json('', 401);
    } catch (\Throwable $th) {
            return response()->json(['error' => $th], 401);
    }
}
public function getallPlansForSingleUser(Request $request){
     $userId=$request->query('userId');
     $planner=$request->query('planId');
     $plans=plans::where('brands_id',$userId)
                ->orderBy('created_at','desc')
                ->paginate(perPage:4);
     return $plans ? response()->json($plans,200)
                   : response()->json(null,401);
}
    
   

   
}
