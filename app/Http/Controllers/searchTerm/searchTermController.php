<?php

namespace App\Http\Controllers\searchTerm;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\brands;
use App\Models\designLibrary;
use App\Models\planLibrary;
use App\Models\User;
use Illuminate\Support\Facades\DB;
class searchTermController extends Controller
{
    public function searchFromAllUsers(Request $request){
        try {
             $allEmployeeData = brands::with(['planner', 'designer', 'brandsCompany']);
            if ($request->filled('filters')) {
            $allEmployeeData=$allEmployeeData->where('creationStatus',$request->filters);
            }
            if ($request->filled('search')) {
               $searchQuery=$request->input('search');
               $allEmployeeData=$allEmployeeData
                ->where(function ($query) use ($searchQuery){
                $query->where('firstName','LIKE', '%' . $searchQuery . '%')
                ->orWhere('lastName','LIKE','%'.$searchQuery.'%')
                ->orWhere('email','LIKE', '%' . $searchQuery . '%')
                ->orWhere('phone', 'LIKE', '%' . $searchQuery . '%')
                ->orWhere('location', 'LIKE', '%' . $searchQuery . '%')
                ->orWhere('title', 'LIKE', '%' . $searchQuery . '%')
                ->orWhere('planners_id', 'LIKE', '%' . $searchQuery . '%')
                ->orWhere('designers_id', 'LIKE', '%' . $searchQuery . '%');
            });
            }
             $allEmployeeData=$allEmployeeData->orderBy('id', 'ASC')->paginate(6);
             return response()->json($allEmployeeData,200);
        } catch (\Throwable $th) {
            return response()->json(['error' => $th], 401);
        }
    }
    public function searchFromUsers(Request $request)
    {
        try {
            $allEmployeeData = brands::with('brandsCompany');
            if ($request->filled('filters')) {
            $allEmployeeData = $allEmployeeData->where('creation_status', $request->filter);
            }
           if ($request->filled('search')) {
            $searchQuery = $request->input('search');
            $allEmployeeData->where(function ($query) use ($searchQuery) {
                $query->where('firstName','LIKE', '%' . $searchQuery . '%')
                ->orWhere('lastName', 'LIKE', '%' . $searchQuery . '%')
                ->orWhere('email','LIKE', '%' . $searchQuery . '%')
                ->orWhere('phone','LIKE', '%' . $searchQuery . '%')
                ->orWhere('location', 'LIKE', '%' . $searchQuery . '%')
                ->orWhere('title','LIKE', '%' . $searchQuery . '%')
                ->orWhere('address','LIKE', '%' . $searchQuery . '%');
            });
            }
            $allEmployeeData = $allEmployeeData->orderBy('id', 'ASC')->paginate(10);
            return response()->json(['data', $allEmployeeData], 200);
        } catch (\Throwable $th) {
            return response()->json(['error' => $th], 401);
        }
    }
    public function searchFromTeamMembers(Request $request)
    {
        try { 
        $allEmployeeData = DB::table('users');
        if ($request->filled('filters')) {
            $allEmployeeData = $allEmployeeData->where('status', $request->filters);
        }

        if ($request->filled('search')) {
            $searchQuery = $request->input('search');
            $allEmployeeData->where(function ($query) use ($searchQuery) {
                $query->where('firstName','LIKE', '%' . $searchQuery . '%')
                ->orWhere('lastName','LIKE', '%' . $searchQuery . '%')
                ->orWhere('email','LIKE', '%' . $searchQuery . '%')
                ->orWhere('phone', 'LIKE', '%' . $searchQuery . '%')
                ->orWhere('title', 'LIKE', '%' . $searchQuery . '%');
            });
        }
            $allEmployeeData =$allEmployeeData->orderBy('id','ASC')->paginate(6);
        return response()->json(['data',$allEmployeeData], 200);
        } catch (\Throwable $th) {
            return response()->json(['error' => $th], 401);
        }

    }
    public function searchFromDesignLibraries(Request $request)
    {
        try {
        $allDesignLibraries = DB::table('design_libraries');
        if ($request->filled('filters')) {
            $allDesignLibraries = $allDesignLibraries->where('status', $request->filters);
        }
        if ($request->filled('search')) {
            $searchQuery = $request->input('search');
            $allDesignLibraries->where(function ($query) use ($searchQuery) {
                $query->where('designTitle', 'LIKE', '%' . $searchQuery . '%')
                ->orWhere('brands_id','LIKE', '%' . $searchQuery . '%')
                ->orWhere('designer_id', 'LIKE', '%' . $searchQuery . '%');
            });
        }
            $allDesignLibraries = $allDesignLibraries->orderBy('id','ASC')->paginate(6);
            return response()->json(['data', $allDesignLibraries], 200);
        } catch (\Throwable $th) {
            return response()->json(['error' => $th], 401);
        }

    }
    public function searchFromPlanLibraries(Request $request)
    {
        try {
        $allPlanLibraries = DB::table('plan_libraries');
        if ($request->filled('filters')) {
            $allPlanLibraries = $allPlanLibraries->where('status', $request->filters);
        }
        if ($request->filled('search')) {
            $searchQuery = $request->input('search');
            $allPlanLibraries->where(function ($query) use ($searchQuery) {
                $query->where('planTitle', 'LIKE', '%' . $searchQuery . '%')
                ->orWhere('planDescription', 'LIKE', '%' . $searchQuery . '%')
                ->orWhere('planPrompt', 'LIKE', '%' . $searchQuery . '%')
                ->orWhere('brands_id','LIKE', '%' . $searchQuery . '%')
                ->orWhere('planner_id','LIKE', '%' . $searchQuery . '%');
            });
        }
        $allPlanLibraries = $allPlanLibraries->orderBy('id','ASC')->paginate(6);
        return response()->json(['data', $allPlanLibraries], 200);
        } catch (\Throwable $th) {
            return response()->json(['error' => $th], 401);
        }
    }
    public function searchFromAllTasks(Request $request)
    {
        try {
        $getAllTasks= DB::table('task_progress_view');
           return response()->json($getAllTasks->paginate(6));
        } catch (\Throwable $th) {
            return response()->json(['error' => $th], 401);
        }
    }
    public function searchFromReports(Request $request)
    {   
      try{
        $getAllTasks = DB::table('task_progress_view');
        return response()->json($getAllTasks->paginate(6));
         } catch (\Throwable $th) {
            return response()->json(['error' => $th], 401);
        }

    }
}
