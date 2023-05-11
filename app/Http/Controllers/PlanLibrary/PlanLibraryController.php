<?php

namespace App\Http\Controllers\PlanLibrary;

// use Maatwebsite\Excel\Facades\Excel;
use App\Http\Controllers\Controller;
use App\Http\Requests\planFormRequest;
use App\Models\planLibrary;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\brands;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use League\Csv\Reader;
use League\Csv\Statement;
// use Maatwebsite\Excel\Concerns\ToArray;

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

    public function addPlanLibrary(plansFormRequest $request){
        try {

            dd('hello');
      $planRequest=$request->only('planTitle','planDescription','planPrompt');
      $createPlan=planLibrary::create([
        'planTitle'=> $planRequest['planTitle'],
        'planDescription'=> $planRequest['planDescription'],
        'planPrompt'=> $planRequest['planPrompt']]);
       return $createPlan ? response()->json(planLibrary::all(), 200) : response()->json('Failed to register plan ', 400);
        } catch (\Throwable $th) {
            return response()->json(['error' => $th], 401);
        }
}
public function deletePlan($id){
        try {
       $planLibrary=planLibrary::findOrFail($id);
       $findBrandsById=brands::findOrFail($planLibrary->brands_id);
       $findBrandsById->planners_id=NULL;
       $checkDelete=$planLibrary->delete()  &&  $findBrandsById->save();
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
        $csvFile= Reader::createFromPath($request->file('zipFile')->getRealPath());
        $csvFile->setHeaderOffset(0);
       
        foreach ($csvFile as $row) {
            $validator = Validator::make($row, [
                 'planTitle' => 'required',
                 'planDescription' =>'required',
                 'planPrompt' => 'required',
            ]);
            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }
            $planLibrary=new planLibrary();
            $planLibrary->planTitle=$row['planTitle'];
            $planLibrary->planDescription=$row['planDescription'];
            $planLibrary->planPrompt=$row['planPrompt'];
            $checkCreated=$planLibrary->save();
        }
           return $checkCreated ? response()->json('Successefully created',200): response()->json('Failed to Add bulk plan', 400);
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
          $findBrands=brands::findOrFail($findPLanLibrary->brands_id);
          $findBrands->planners_id=$findPLanLibrary->planner_id;
          $check= $findBrands->save();
         if(!$check){
           DB::rollBack();
           return response()->json('Failed to register plan ', 400);
          }
         DB::commit();
        return response()->json(['message'=>"Successfully Approved plan ", planLibrary::paginate(4)], 200);
        } catch (\Throwable $th) {
            DB::rollBack();
            return response()->json(['error' => $th], 401);
        }
    }
    public function updatePlanLibrary(planFormRequest $request, $id){

        try {
            $planRequest = $request->only('planTitle', 'planDescription', 'planPrompt');
            $findPlan=planLibrary::findOrFail($id);
            $chec=null;
            if($findPlan){
                  $findPlan->planTitle=$planRequest['planTitle'];
                  $findPlan->planDescription=$planRequest['planDescription'];
                  $findPlan->planPrompt=$planRequest['planPrompt'];
                  $check=$findPlan->save();
            }
            return $check ? response()->json(planLibrary::all(), 200) : response()->json('Failed to update plan ', 400);
        } catch (\Throwable $th) {
            return response()->json(['error' => $th], 401);
        }
    }
}
