<?php

namespace App\Http\Controllers\allTask;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\designLibrary;
use App\Models\brands;


class getAllTaskController extends Controller
{
    //
    public function getAllTask(){
     try {
        $fetchAllTask=brands::with('designLibrary', 'brandsCompany')->get();
        return response()->json($fetchAllTask, 200);
        } catch (\Throwable $th) {
            return response()->json(['error'=>$th], 401);
        }    
    }
    public function getReports(){
        try {
              $fetchTheDesignnerAndPlannerOfUser = brands::with('brandsCompany', 'designLibrary', 'planLibrary')->get();
              return response()->json($fetchTheDesignnerAndPlannerOfUser, 200);
        } catch (\Throwable $th) {
            return response()->json(['error' => $th], 401);
        }    
      
    }

}
