<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\designLibrary;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\JsonResponse;
use App\Http\Requests\addDesignFormRequest;

class DesignLibraryController extends Controller
{
    //
    public function getAllDesignLibrary(){
        $allDesignLibrary=designLibrary::all();
        return $allDesignLibrary ? response()->json($allDesignLibrary, 200) : response()->json("Empty Design Library", 400);
    }
    public function addDesignLibrary(addDesignFormRequest $request){
        $requestData=$request->only('designTitle','image','zipFile');
           $addDesignLibrary=designLibrary::create([
            'designTitle'=>$request->designTitle,
            'image'=>$request->image,
            'zipFile'=>$request->zipFile,
           ]);
           return $addDesignLibrary ? response()->json($addDesignLibrary,201) : response()->json("Failed to add design !!", 400);
    }
    public function updateDesignLibrary(Request $request,$id){
        $validator = Validator::make($request->all(), [
            'zipFile'=>'required'
        ]);
        if ($validator->fails()) {
            $response = new JsonResponse([
                'status' => 'validation error',
                'errors' => $validator->errors()
            ], 422);
            throw new \Illuminate\Validation\ValidationException($validator, $response);
        }
          $findDesignPlan=designLibrary::find($id);
          if($findDesignPlan){
          $findDesignPlan->sourceFile=$request->zipFile;
          $findDesignPlan->save();
          return  redirect('/design-library');
          }
          return response()->json("Failed to Update design !!", 400);
    }
}
