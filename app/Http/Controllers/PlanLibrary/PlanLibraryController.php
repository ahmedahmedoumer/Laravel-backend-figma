<?php

namespace App\Http\Controllers\PlanLibrary;

use Maatwebsite\Excel\Facades\Excel;
use App\Http\Controllers\Controller;
use App\Http\Requests\planFormRequest;
use App\Models\planLibrary;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Concerns\ToArray;

class PlanLibraryController extends Controller
{
    //
    public function getAllPlanLibrary(){
        try {
        $allPlanLibrary=planLibrary::paginate(4);
        if ($allPlanLibrary) {
            return response()->json(['data'=>$allPlanLibrary],200);
        }
        $allPlanLibrary=Null;
        return response()->json(['data'=>$allPlanLibrary,'message'=>"Empty plan Library"],200);
        } catch (\Throwable $th) {
            return response()->json(['error' => $th], 401);
        }
    }

    public function addPlanLibrary(planFormRequest $request){
        try {
      $planRequest=$request->only('planTitle','planDescription','planPrompt');
      $createPlan=planLibrary::create([
        'planTitle'=> $planRequest['planTitle'],
        'planDescription'=> $planRequest['planDescription'],
        'planPrompt'=> $planRequest['planPrompt']]);
       return $createPlan ? response()->json(planLibrary::paginate(4), 200) : response()->json('Failed to register plan ', 400);
        } catch (\Throwable $th) {
            return response()->json(['error' => $th], 401);
        }
}
public function deletePlan($id){
        try {
       $planLibrary=planLibrary::find($id);
       $checkDelete=$planLibrary->delete();
      return $checkDelete ? response()->json(['Deleted successfully'],200) : response()->json(['Deleted successfully'],400);
        } catch (\Throwable $th) {
            return response()->json(['error' => $th], 401);
        }
}
public function addbulkPlan(Request $request){
        try {
    $request->validate([
        'zipFile'=> 'required|mimes:xlsx,xls,csv'
        ]);
        $path=$request->file('zipFile');
        $data = Excel::toArray(new ToArray(), $path);
        foreach ($data[0] as $row) {
           $validatedRow = Validator::make($row, [
                'planTitle' => 'required',
                'planDescription' =>'required',
                'planPrompt' => 'required',
         ])->validate();
        }
           $checkCreated= planLibrary::create($validatedRow);
           return $checkCreated ? response()->json('Successefully created',200): response()->json('Successefully created', 400);
        } catch (\Throwable $th) {
            return response()->json(['error' => $th], 401);
        }
    }
    public function planApprove($id){
        try {
         DB::beginTransaction();
        $findPLanLibrary = planLibrary::findOrFail($id);
         $findPLanLibrary->status="Approve";
        $findPLanLibrary->approved_on = now();
        $findPLanLibrary->approved_by = Auth::id();
         $findPLanLibrary->save();
         $findBrands=User::findOrFail($findPLanLibrary->brands_id);
         $findBrands->planners_id=$findPLanLibrary->planner_id;
         $check= $findBrands->save();
         if(!$check){
           DB::rollBack();
           return response()->json('Failed to register plan ', 400);
         }
         DB::commit();
        return response()->json(planLibrary::paginate(4), 200);
        } catch (\Throwable $th) {
            return response()->json(['error' => $th], 401);
        }
    }
}
