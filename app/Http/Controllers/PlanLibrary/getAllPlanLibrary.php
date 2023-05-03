<?php

namespace App\Http\Controllers\PlanLibrary;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\planLibrary;

class getAllPlanLibrary extends Controller
{
    public function getAllListOfPlanLibray(){
          $allListOfPlanLibrary=planLibrary::all();
          return response()->json(['data'=>$allListOfPlanLibrary],200);
    }
}
