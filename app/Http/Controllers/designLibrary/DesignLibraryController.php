<?php

namespace App\Http\Controllers\designLibrary;

use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Http\Request;
use App\Models\designLibrary;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\JsonResponse;
use App\Http\Requests\addDesignFormRequest;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use Maatwebsite\Excel\Concerns\ToArray;


class DesignLibraryController extends Controller
{
    //
    public function getAllDesignLibrary(){
        try {
        $allDesignLibrary=designLibrary::all();
        return $allDesignLibrary ? response()->json($allDesignLibrary, 200) : response()->json("Empty Design Library", 400);
        } catch (\Throwable $th) {
            return response()->json(['error'=>$th],401);
        }
    }
    public function addDesignLibrary(addDesignFormRequest $request){
        try {
        $requestData=$request->only('designTitle','image','zipFile');
        $zipFileName=$request->file('zipFile');
        $imageFileName=$request->file('image');
        $imageFileOriginalName= $imageFileName->getClientOriginalName();
        $zipFileOriginalName = $zipFileName->getClientOriginalName();
        $storepPathForZipFile = public_path() . '/uploads/zipFiles';
        $storepPathForImageFile = public_path() . '/uploads/imageFiles';
        $zipFileName->move($storepPathForZipFile, $zipFileOriginalName);
        $imageFileName->move($storepPathForImageFile, $imageFileOriginalName);

        $ZipFilestoreAs='/uploads/zipFiles/'. $zipFileOriginalName;
        $ImageFilestoreAs = '/uploads/imageFiles/' . $imageFileOriginalName;

        $addDesignLibrary=designLibrary::create([
            'designTitle'=> $requestData['designTitle'],
            'image'=> $ImageFilestoreAs,
            'sourceFile'=> $ZipFilestoreAs,
           ]);
           return $addDesignLibrary ? response()->json($addDesignLibrary,201) : response()->json("Failed to add design !!", 400);
        } catch (\Throwable $th) {
            return response()->json(['error'=>$th],401);
        }
    }
    public function updateDesignLibrary(Request $request,$id){
        try {
           $validator = Validator::make($request->all(), [
                'sourceFile'=>'required|mimes:zip'
            ]);
           if ($validator->fails()) {
            $response = new JsonResponse([
                'status' => 'validation error',
                'errors' => $validator->errors()
            ], 422);
            throw new \Illuminate\Validation\ValidationException($validator, $response);
            }
            $findDesignPlan=designLibrary::find($id);
            $check=null;
            if($findDesignPlan){
            $file=$request->sourceFile;
            $zipFileName = $file->getClientOriginalName();
            $storepPathForZipFile = public_path() . '/uploads/zipFiles';

            $file->move($storepPathForZipFile, $zipFileName);
            $path ='/uploads/zipFiles/'.$zipFileName;

            $findDesignPlan->sourceFile=$path;
            $check=$findDesignPlan->save();
            }
            $allDesignLibrary = designLibrary::all();
            return $allDesignLibrary && $check ? response()->json(["message"=>"successfully updated",'data'=>$allDesignLibrary], 200) : response()->json("Empty Design Library", 400);
        } catch (\Throwable $th) {
          return response()->json(['error'=>$th],401);
        }
    }
    public function deleteDesignRequest($id){
        try {
             $findDesignRequest=designLibrary::findOrFail($id);
             $checkDelete=$findDesignRequest->delete();
             $allDesignLibrary = designLibrary::all();
             return ($checkDelete && $allDesignLibrary) ? response()->json($allDesignLibrary, 200) : response()->json("Empty Design Library", 400);
        } catch (\Throwable $th) {
            return response()->json(['error'=>$th],401);
        }
    }
    public function approveDesignRequest($id){
        try {
             DB::beginTransaction();
             $findDesignLibrary = designLibrary::findOrFail($id);
             $findDesignLibrary->status = "Approve";
             $findDesignLibrary->save();
             $findBrands = User::findOrFail($findDesignLibrary->brands_id);
             $findBrands->designers_id = $findDesignLibrary->designer_id;
            $check = $findBrands->save();
            if (!$check) {
            DB::rollBack();
            return response()->json('Failed to register plan ', 400);
            }
            DB::commit();
            return response()->json(designLibrary::paginate(4), 200);
        } catch (\Throwable $th) {
            return response()->json(['error'=>$th],401);
        }
    }
    public function setStatusNeedEditForDesignRequest(Request $request){
           $data=$request->data;
           try {
            foreach ($data as $key) {
                $designItem = designLibrary::findOrFail($key->id);
                $designItem->status = "Need Edit";
                $designItem->save();
            }
            return response()->json('successfully update Status', 200);
           } catch (\Throwable $th) {
             return response()->json('Something Wrong',401);
           }
    }
    public function addbulkDesign(Request $request)
    {
       try {
           $request->validate([
              'zipFile' => 'required|mimes:xlsx,xls,csv'
            ]);
            $path = $request->file('zipFile');
            $data = Excel::toArray(new ToArray(), $path);
            foreach ($data[0] as $row) {
                $validatedRow = Validator::make($row, [
                   'designTitle' => 'required', 
                ])->validate();
            }
           $checkCreated = designLibrary::create($validatedRow);
           return $checkCreated ? response()->json('Successefully created', 200) : response()->json('Successefully created', 400);
        } catch (\Throwable $th) {
            return response()->json(['error' => $th], 401);
        }
    }
}
