<?php

namespace App\Http\Controllers\allTask;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\designLibrary;
use App\Models\brands;


class getAllTaskController extends Controller
{
    //
    public function getAllTask(Request $request){
     try {
        $page = $request->query('perPage');
        $currentPage=$request->query('currentPage');

        $fetchAllTask=brands::with('brandsCompany','plans','designs')->whereHas('plans',function($query){
            $query->where('status','Approved');
        })->paginate(perPage:$page,page:$currentPage);
        return response()->json($fetchAllTask, 200);
        } catch (\Throwable $th) {
            return response()->json(['error'=>$th], 401);
        }    
    }
    public function getReports(Request $request){
        try {
            $page = $request->query('perPage');
            $currentPage=$request->query('currentPage');
              $fetchTheDesignnerAndPlannerOfUser = brands::with('brandsCompany', 'designs', 'plans','planner','designer')->whereHas('plans',function($query){
                $query->where('status','Approved');
              })->paginate(perPage:$page,page:$currentPage);
              return response()->json($fetchTheDesignnerAndPlannerOfUser, 200);
        } catch (\Throwable $th) {
            return response()->json(['error' => $th], 401);
        }    
      
    }

}
