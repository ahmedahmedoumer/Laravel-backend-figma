<?php

namespace App\Http\Controllers\searchTerm;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\brands;
use App\Models\brandsCompany;
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
                $query->where('designTitle', 'LIKE', '%' . $searchQuery . '%');
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
                ->orWhere('planPrompt', 'LIKE', '%' . $searchQuery . '%');
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
            $getAllTasks = brands::with('brandCompany','designs', 'plans')->whereHas('plans',function($query){
                $query->where('status','Approved');
            });
            if($request->filled('filter')){
               $getAllTasks=$getAllTasks->where('creationStatus',$request->filter);
            }
            if ($request->filled('search')) {
                $searchQuery=$request->search;
                $getAllTasks=$getAllTasks->where(function ($query) use ($searchQuery){
                     $query->where('firstName','LIKE','%'.$searchQuery.'%')
                     ->orWhere('creationStatus','LIKE','%'.$searchQuery.'%')
                     ->orWhere('brandsCompany', function ($find) {
                            $find->where('companyName', 'LIKE', '%'.$searchQuery.'%');
                        });
                     });
                }
           return response()->json($getAllTasks->paginate(6));
        } catch (\Throwable $th) {
            return response()->json(['error' => $th], 401);
        }
    }
    public function searchFromReports(Request $request)
    {

        $getAllReports = brands::with('brandsCompany', 'designs', 'plans');
        try {
        if ($request->filled('filters')) {
                $getAllReports=$getAllReports->where('creationStatus',$request->filter);
        }
        if ($request->filled('search')) 
        {
            $searchQuery=$request->input('search');
            $getAllReports->where(function ($query) use ($searchQuery){
                $query->where('firstName','LIKE','%'.$searchQuery.'%')
                ->orWhere('creationStatus', 'LIKE', '%' . $searchQuery . '%');
            });
        }
           return response()->json($getAllReports->paginate(6));
         } catch (\Throwable $th) {
            return response()->json(['error' => $th], 401);
        }

    }
}



  
