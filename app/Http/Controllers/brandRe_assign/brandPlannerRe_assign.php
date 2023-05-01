<?php

namespace App\Http\Controllers\brandRe_assign;

use App\Http\Controllers\Controller;
use App\Models\brands;

// use App\Http\Controllers\allUsers\getUsersController;
use App\Models\User;
use Illuminate\Http\Request;

class brandPlannerRe_assign extends Controller
{
     public function brandPlannerReassign($brand_id,$planner_id){

        $findBrandRow=brands::find($brand_id);
        $findPlanner=User::where('id',$planner_id)->where('title','planner')->first();
        if($findBrandRow && $findPlanner){
        $findBrandRow->planners_id=$planner_id;
        $saveAssigning=$findBrandRow->save();
     if ($saveAssigning) {
            $allEmployeeData = brands::with(['planner', 'designer', 'brandsCompany'])->get();
            return response()->json(['AllUsers' => $allEmployeeData],200);
     }
            return response()->json(['data' => "Failed to assign Planner !!"], 200);
    }
            return response()->json(['data' => "Failed to assign Planner check the assigned member !!"], 200);
     }
}
