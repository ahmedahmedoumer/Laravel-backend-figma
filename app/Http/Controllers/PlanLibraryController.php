<?php

namespace App\Http\Controllers;

use App\Http\Requests\planFormRequest;
use App\Models\planLibrary;

class PlanLibraryController extends Controller
{
    //
    public function getAllPlanLibrary(){
        $allPlanLibrary=planLibrary::all();
        if ($allPlanLibrary) {
            return response()->json(['data'=>$allPlanLibrary],200);
        }
        $allPlanLibrary=Null;
        return response()->json(['data'=>$allPlanLibrary,'message'=>"Empty plan Library"],200);
    }

    public function addPlanLibrary(planFormRequest $request){
      $planRequest=$request->only('planTitle','planDescription','planPrompt');
      $createPlan=planLibrary::create([
        'planTitle'=>$request->planTitle,
        'planDescription'=>$request->planDescription,
        'planPrompt'=>$request->planPrompt ]);
   return $createPlan ? response()->json(planLibrary::all(), 200) : response()->json('Failed to register plan ', 400);
}
}
