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
             $allEmployeeData = brands::with(['planner', 'designer', 'brandsCompany'])->get();
              return $allEmployeeData;
            if ($request->filled('filters')) {
            $allEmployeeData=$allEmployeeData->where('creation_status',$request->filter);
            }
            if ($request->filled('search')) {
               $searchQuery=$request->input('search');
               $allEmployeeData=$allEmployeeData->where(function ($query) use ($searchQuery){
                $query->where('firstName','%',"%$searchQuery%")
                ->orWhere('lasName','%',"%$searchQuery%")
                ->orWhere('emails','%',"%$searchQuery%")
                ->orWhere('phone', 'like', "%$searchQuery%")
                ->orWhere('location', 'like', "%$searchQuery%")
                ->orWhere('title', 'like', "%$searchQuery%")
                ->orWhere('planner.firstName', 'like', "%$searchQuery%")
                ->orWhere('designner.firstName', 'like', "%$searchQuery%");
            });
            }
             $allEmployeeData=$allEmployeeData->paginate(6);
             return response()->json($allEmployeeData,200);
        } catch (\Throwable $th) {
            return response()->json(['error' => $th], 401);
        }
    }
    public function searchFromUsers(Request $request)
    {
        try {
            $allEmployeeData = brands::with('brandsCompany')->get();
            if ($request->filled('filters')) {
            $allEmployeeData = $allEmployeeData->where('creation_status', $request->filter);
            }
           if ($request->filled('search')) {
            $searchQuery = $request->input('search');
            $allEmployeeData->where(function ($query) use ($searchQuery) {
                $query->where('firstName', 'like', "%$searchQuery%")
                ->orWhere('lastName', 'like', "%$searchQuery%")
                ->orWhere('emails', 'like', "%$searchQuery%")
                ->orWhere('phone', 'like', "%$searchQuery%")
                ->orWhere('location', 'like', "%$searchQuery%")
                ->orWhere('title', 'like', "%$searchQuery%")
                ->orWhere('address', 'like', "%$searchQuery%")
                ->orWhere('brands_company.companyName', 'like', "%$searchQuery%");
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
      
        $allEmployeeData = User::all();
        if ($request->filled('filters')) {
            $allEmployeeData = $allEmployeeData->where('status', $request->filter);
        }
        if ($request->filled('search')) {
            $searchQuery = $request->input('search');
            $allEmployeeData->where(function ($query) use ($searchQuery) {
                $query->where('firstName', 'like', "%$searchQuery%")
                ->orWhere('lastName', 'like', "%$searchQuery%")
                ->orWhere('emails', 'like', "%$searchQuery%")
                ->orWhere('phone', 'like', "%$searchQuery%")
                ->orWhere('title', 'like', "%$searchQuery%");
            });
        }
            $allEmployeeData =$allEmployeeData->paginate(6);
        return response()->json(['data',$allEmployeeData], 200);
        } catch (\Throwable $th) {
            return response()->json(['error' => $th], 401);
        }

    }
    public function searchFromDesignLibraries(Request $request)
    {
        try {
        $allDesignLibraries = designLibrary::all();
        if ($request->filled('filters')) {
            $allDesignLibraries = $allDesignLibraries->where('status', $request->filter);
        }
        if ($request->filled('search')) {
            $searchQuery = $request->input('search');
            $allDesignLibraries->where(function ($query) use ($searchQuery) {
                $query->where('designTitle', 'like', "%$searchQuery%")
                ->orWhere('brands_id', 'like', "%$searchQuery%")
                ->orWhere('designer_id', 'like', "%$searchQuery%");
            });
        }
            $allDesignLibraries = $allDesignLibraries->paginate(6);
            return response()->json(['data', $allDesignLibraries], 200);
        } catch (\Throwable $th) {
            return response()->json(['error' => $th], 401);
        }

    }
    public function searchFromPlanLibraries(Request $request)
    {
        try {
        $allPlanLibraries = planLibrary::all();
        if ($request->filled('filters')) {
            $allPlanLibraries = $allPlanLibraries->where('status', $request->filter);
        }
        if ($request->filled('search')) {
            $searchQuery = $request->input('search');
            $allPlanLibraries->where(function ($query) use ($searchQuery) {
                $query->where('planTitle', 'like', "%$searchQuery%")
                ->orWhere('planDescription', 'like', "%$searchQuery%")
                ->orWhere('planPrompt', 'like', "%$searchQuery%")
                ->orWhere('brands_id', 'like', "%$searchQuery%")
                ->orWhere('planner_id', 'like', "%$searchQuery%");
            });
        }
        $allPlanLibraries = $allPlanLibraries->paginate(6);
        return response()->json(['data', $allPlanLibraries], 200);
        } catch (\Throwable $th) {
            return response()->json(['error' => $th], 401);
        }
    }
    public function searchFromAllTasks(Request $request)
    {
        try {
        $getAllTasks= DB::table('task_progress_view')->get();
           return response()->json($getAllTasks->paginate(6));
        } catch (\Throwable $th) {
            return response()->json(['error' => $th], 401);
        }
    }
    public function searchFromReports(Request $request)
    {   
      try{
        $getAllTasks = DB::table('task_progress_view')->get();
        return response()->json($getAllTasks->paginate(6));
         } catch (\Throwable $th) {
            return response()->json(['error' => $th], 401);
        }

    }
}
