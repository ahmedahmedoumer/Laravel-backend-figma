<?php

namespace App\Http\Controllers\allTask;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\planLibrary;
use App\Models\brands;

class getAllTaskController extends Controller
{
    //
    public function getAllTask(){
        $fetchAllTask= planLibrary::with(['user'])->get();
        return response()->json($fetchAllTask, 200);
    }
    public function getReports(){
        $fetchTheDesignnerAndPlannerOfUser=brands::with(['planner','designer'])->get();
        return response()->json($fetchTheDesignnerAndPlannerOfUser, 200);
    }
}
